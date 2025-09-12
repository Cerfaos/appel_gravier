<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sortie;
use App\Models\SortieImage;
use App\Services\GpxParserService;
use App\Services\SortieService;
use App\Http\Requests\StoreSortieRequest;
use App\Http\Requests\UpdateSortieRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SortieController extends Controller
{
    protected $gpxParser;
    protected $sortieService;

    public function __construct(GpxParserService $gpxParser, SortieService $sortieService)
    {
        $this->gpxParser = $gpxParser;
        $this->sortieService = $sortieService;
    }

    // Afficher toutes les sorties (admin)
    public function index(Request $request)
    {
        // Utiliser le service pour récupérer les sorties avec filtres
        $filters = [];
        if ($request->filled('status')) {
            $filters['status'] = $request->get('status');
        }
        
        $sorties = $this->sortieService->getSorties($filters, 10);
        
        // Statistiques pour la vue
        $stats = [
            'total' => Sortie::count(),
            'published' => Sortie::where('status', 'published')->count(),
            'draft' => Sortie::where('status', 'draft')->count()
        ];
        
        return view('admin.sorties.index', compact('sorties', 'stats'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('admin.sorties.create');
    }

    // API pour récupérer les images du mois courant
    public function getMonthlyImages(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        Log::info('API getMonthlyImages appelée', [
            'year' => $year,
            'month' => $month,
            'user_id' => auth()->id()
        ]);

        $images = SortieImage::whereHas('sortie', function ($query) use ($year, $month) {
                $query->whereYear('sortie_date', $year)
                      ->whereMonth('sortie_date', $month);
            })
            ->with('sortie:id,title,sortie_date')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('image_path') // Grouper par chemin d'image pour éviter les doublons
            ->map(function ($duplicates) {
                // Prendre la première occurrence de chaque image unique
                $image = $duplicates->first();
                // Compter les utilisations et lister les sorties
                $usedInSorties = $duplicates->map(function($dup) {
                    return $dup->sortie->title;
                })->unique()->join(', ');
                
                return [
                    'id' => $image->id,
                    'url' => asset($image->image_path),
                    'caption' => $image->caption ?: ('Image ' . basename($image->image_path)),
                    'is_featured' => $image->is_featured,
                    'sortie_title' => $image->sortie->title,
                    'sortie_date' => $image->sortie->sortie_date->format('d/m/Y'),
                    'used_count' => $duplicates->count(),
                    'used_in_sorties' => $usedInSorties
                ];
            })
            ->values(); // Réindexer le tableau

        Log::info('Images trouvées: ' . $images->count());

        return response()->json($images);
    }

    // Enregistrer une nouvelle sortie
    public function store(StoreSortieRequest $request)
    {
        Log::info('SortieController::store - Création via service', [
            'user_id' => auth()->id(),
            'title' => $request->title
        ]);
        
        try {
            // Utiliser le service pour créer la sortie
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            
            $sortie = $this->sortieService->createSortie($data);

            // Upload et parse du fichier GPX si présent
            if ($request->hasFile('gpx_file')) {
                $gpxFile = $request->file('gpx_file');
                $gpxContent = file_get_contents($gpxFile->getRealPath());
                
                // Parser le GPX
                $gpxData = $this->gpxParser->parse($gpxContent);
                
                // Sauvegarder le fichier GPX avec l'extension .gpx
                $filename = time() . '_' . uniqid() . '.gpx';
                $gpxPath = $gpxFile->storeAs('gpx', $filename, 'public');
                
                // Ajouter les données GPX à la sortie
                $sortie->gpx_file_path = $gpxPath;
                $sortie->distance_km = $gpxData['statistics']['distance_km'];
                $sortie->elevation_gain_m = $gpxData['statistics']['elevation_gain_m'];
                $sortie->elevation_loss_m = $gpxData['statistics']['elevation_loss_m'];
                $sortie->estimated_duration_minutes = round(($gpxData['statistics']['distance_km'] / 25) * 60); // 25 km/h estimation
                $sortie->min_latitude = $gpxData['statistics']['min_latitude'];
                $sortie->max_latitude = $gpxData['statistics']['max_latitude'];
                $sortie->min_longitude = $gpxData['statistics']['min_longitude'];
                $sortie->max_longitude = $gpxData['statistics']['max_longitude'];
            }
            
            // Définir la date de publication si publié
            if ($sortie->status === 'published') {
                $sortie->published_at = now();
            }
            
            Log::info('SortieController::store - Avant save()', [
                'sortie_data' => $sortie->toArray()
            ]);
            
            $saved = $sortie->save();
            
            Log::info('SortieController::store - Après save()', [
                'save_result' => $saved,
                'sortie_id' => $sortie->id,
                'sortie_exists' => $sortie->exists
            ]);
            
            // Sauvegarder les points GPS si il y en a
            if (isset($gpxData) && isset($gpxData['points'])) {
                foreach ($gpxData['points'] as $index => $point) {
                    $sortie->gpxPoints()->create([
                        'latitude' => $point['latitude'],
                        'longitude' => $point['longitude'],
                        'elevation' => $point['elevation'],
                        'point_order' => $index
                    ]);
                }
            }
            
            // Gérer les images si présentes via le service
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $isFeatured = $request->input('featured_image_index') == $index;
                    $this->sortieService->addImageToSortie($sortie, $image, $isFeatured);
                }
            }
            
            // 2. Gérer les images sélectionnées de la galerie mensuelle
            if ($request->filled('selected_monthly_images')) {
                $selectedImageIds = $request->input('selected_monthly_images');
                Log::info('Images sélectionnées de la galerie:', $selectedImageIds);
                
                foreach ($selectedImageIds as $index => $imageId) {
                    try {
                        // Récupérer l'image originale
                        $originalImage = SortieImage::find($imageId);
                        Log::info('Image originale trouvée:', [
                            'id' => $imageId,
                            'exists' => $originalImage ? 'oui' : 'non',
                            'path' => $originalImage ? $originalImage->image_path : 'N/A'
                        ]);
                        
                        if ($originalImage) {
                            // Créer une nouvelle entrée qui référence la même image physique
                            $newImage = SortieImage::create([
                                'sortie_id' => $sortie->id,
                                'image_path' => $originalImage->image_path, // Réutiliser le même chemin
                                'caption' => $originalImage->caption,
                                'is_featured' => ($totalImagesAdded === 0 && $sortie->images()->count() === 0), // Première image = featured si aucune autre
                                'order_position' => $totalImagesAdded
                            ]);
                            
                            Log::info('Image réutilisée créée:', [
                                'new_id' => $newImage->id,
                                'sortie_id' => $sortie->id,
                                'path' => $newImage->image_path
                            ]);
                            
                            $totalImagesAdded++;
                        }
                    } catch (\Exception $e) {
                        Log::error('Erreur lors de la réutilisation d\'image: ' . $e->getMessage());
                        $imageErrors[] = "Image de galerie {$index}: " . $e->getMessage();
                    }
                }
            }
            
            $message = 'Sortie créée avec succès';
            if (!empty($imageErrors)) {
                $message .= ' mais avec des erreurs d\'images: ' . implode(', ', $imageErrors);
            }
            
            $notification = array(
                'message' => $message,
                'alert-type' => !empty($imageErrors) ? 'warning' : 'success'
            );
            
            Log::info('SortieController::store - Fin avec succès', [
                'sortie_id' => $sortie->id,
                'message' => $message
            ]);
            
            return redirect()->route('admin.all.sortie')->with($notification);
            
        } catch (\Exception $e) {
            Log::error('SortieController::store - Erreur', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'request_data' => $request->except(['gpx_file', 'images'])
            ]);
            
            $notification = array(
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification)->withInput();
        }
    }

    // Afficher les détails d'une sortie
    public function show($id)
    {
        $sortie = Sortie::with(['images', 'gpxPoints', 'user'])->findOrFail($id);
        return view('admin.sorties.show', compact('sortie'));
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $sortie = Sortie::with(['images', 'gpxPoints', 'user', 'featuredImage'])->findOrFail($id);
        return view('admin.sorties.edit', compact('sortie'));
    }

    // Mettre à jour une sortie
    public function update(UpdateSortieRequest $request, $id)
    {
        Log::info('SortieController::update - Mise à jour via service', [
            'sortie_id' => $id,
            'user_id' => auth()->id()
        ]);
        
        $sortie = Sortie::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Utiliser le service pour la mise à jour
            $data = $request->validated();
            $sortie = $this->sortieService->updateSortie($sortie, $data);
            
            // Gérer la publication/dépublication via le service
            if ($data['status'] === 'published' && $sortie->status !== 'published') {
                $sortie = $this->sortieService->publishSortie($sortie);
            } elseif ($data['status'] !== 'published' && $sortie->status === 'published') {
                $sortie = $this->sortieService->unpublishSortie($sortie);
            }
            
            // Si un nouveau fichier GPX est uploadé
            if ($request->hasFile('gpx_file')) {
                // Supprimer l'ancien fichier
                if ($sortie->gpx_file_path) {
                    Storage::disk('public')->delete($sortie->gpx_file_path);
                }
                
                // Traiter le nouveau fichier
                $gpxFile = $request->file('gpx_file');
                $gpxContent = file_get_contents($gpxFile->getRealPath());
                $gpxData = $this->gpxParser->parse($gpxContent);
                
                // Sauvegarder le fichier GPX avec l'extension .gpx
                $filename = time() . '_' . uniqid() . '.gpx';
                $gpxPath = $gpxFile->storeAs('gpx', $filename, 'public');
                
                // Mettre à jour les statistiques
                $sortie->gpx_file_path = $gpxPath;
                $sortie->distance_km = $gpxData['statistics']['distance_km'];
                $sortie->elevation_gain_m = $gpxData['statistics']['elevation_gain_m'];
                $sortie->elevation_loss_m = $gpxData['statistics']['elevation_loss_m'];
                $sortie->estimated_duration_minutes = round(($gpxData['statistics']['distance_km'] / 25) * 60); // 25 km/h estimation
                $sortie->min_latitude = $gpxData['statistics']['min_latitude'];
                $sortie->max_latitude = $gpxData['statistics']['max_latitude'];
                $sortie->min_longitude = $gpxData['statistics']['min_longitude'];
                $sortie->max_longitude = $gpxData['statistics']['max_longitude'];
                
                // Supprimer les anciens points et ajouter les nouveaux
                $sortie->gpxPoints()->delete();
                foreach ($gpxData['points'] as $index => $point) {
                    $sortie->gpxPoints()->create([
                        'latitude' => $point['latitude'],
                        'longitude' => $point['longitude'],
                        'elevation' => $point['elevation'],
                        'point_order' => $index,
                        'timestamp' => $point['timestamp'] ?? null
                    ]);
                }
            }
            
            // Gestion de la suppression d'images marquées
            if ($request->filled('images_to_delete')) {
                $imagesToDelete = explode(',', $request->images_to_delete);
                foreach ($imagesToDelete as $imageId) {
                    $image = SortieImage::where('sortie_id', $sortie->id)->find($imageId);
                    if ($image) {
                        // Supprimer le fichier physique
                        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                        }
                        // Supprimer l'enregistrement
                        $image->delete();
                    }
                }
            }
            
            // Variable pour suivre si on a défini une featured image
            $featuredImageSet = false;

            // Gestion des modifications des légendes d'images existantes
            if ($request->has('existing_images')) {
                foreach ($request->existing_images as $imageId => $imageData) {
                    $image = SortieImage::where('sortie_id', $sortie->id)->find($imageId);
                    if ($image) {
                        if (isset($imageData['caption'])) {
                            $image->caption = $imageData['caption'];
                        }
                        if (isset($imageData['order'])) {
                            $image->order_position = $imageData['order'];
                        }
                        $image->save();
                    }
                }
            }
            
            $sortie->save();
            
            // Gérer les images sélectionnées de la galerie mensuelle
            $totalImagesAdded = 0;
            if ($request->filled('selected_monthly_images')) {
                Log::info('Images sélectionnées de la galerie: ' . json_encode($request->selected_monthly_images));
                
                foreach ($request->selected_monthly_images as $imageId) {
                    try {
                        $originalImage = SortieImage::find($imageId);
                        if ($originalImage) {
                            $newImage = SortieImage::create([
                                'sortie_id' => $sortie->id,
                                'image_path' => $originalImage->image_path,
                                'caption' => $originalImage->caption,
                                'is_featured' => ($totalImagesAdded === 0 && $sortie->images()->count() === 0),
                                'order_position' => $totalImagesAdded
                            ]);
                            
                            Log::info('Image réutilisée créée pour mise à jour:', [
                                'new_id' => $newImage->id,
                                'sortie_id' => $sortie->id,
                                'path' => $newImage->image_path
                            ]);
                            
                            $totalImagesAdded++;
                        }
                    } catch (\Exception $e) {
                        Log::error('Erreur lors de la réutilisation d\'image en mise à jour: ' . $e->getMessage());
                    }
                }
            }

            // Gérer les nouvelles images si présentes
            $imageErrors = [];
            $newImages = [];
            
            // Debug logging
            Log::info('Sortie Update - Debug info:', [
                'has_new_images' => $request->hasFile('new_images'),
                'new_images_count' => $request->hasFile('new_images') ? count($request->file('new_images')) : 0,
                'all_files' => $request->allFiles(),
                'sortie_id' => $sortie->id,
                'selected_monthly_count' => $request->filled('selected_monthly_images') ? count($request->selected_monthly_images) : 0
            ]);
            
            if ($request->hasFile('new_images')) {
                $existingImagesCount = $sortie->images()->count();
                
                foreach ($request->file('new_images') as $index => $image) {
                    if ($image->isValid()) {
                        try {
                            $imagePath = $this->uploadSortieImage($image);
                            
                            // Créer l'enregistrement en base
                            $newImage = SortieImage::create([
                                'sortie_id' => $sortie->id,
                                'image_path' => $imagePath,
                                'caption' => $request->input("new_image_captions.{$index}", ''),
                                'is_featured' => false, // Sera défini plus bas si c'est l'image featured
                                'order_position' => $existingImagesCount + $index
                            ]);
                            
                            $newImages[$index] = $newImage;
                        } catch (\Exception $e) {
                            Log::error('Erreur upload image sortie update: ' . $e->getMessage());
                            $imageErrors[] = "Image {$index}: " . $e->getMessage();
                        }
                    }
                }
                
                // Gérer l'image principale parmi les nouvelles images (priorité)
                if ($request->filled('new_featured_image_index') && isset($newImages[$request->new_featured_image_index])) {
                    // Désactiver toutes les images principales actuelles
                    SortieImage::where('sortie_id', $sortie->id)->update(['is_featured' => false]);
                    
                    // Activer la nouvelle image principale
                    $featuredImage = $newImages[$request->new_featured_image_index];
                    $featuredImage->is_featured = true;
                    $featuredImage->save();
                    $featuredImageSet = true;
                }
            }
            
            // Gestion de l'image principale parmi les images existantes (si aucune nouvelle featured n'a été définie)
            if (!$featuredImageSet && $request->filled('existing_images_featured')) {
                // Désactiver toutes les images principales actuelles
                SortieImage::where('sortie_id', $sortie->id)->update(['is_featured' => false]);
                
                // Activer l'image principale sélectionnée
                $featuredImage = SortieImage::where('sortie_id', $sortie->id)
                    ->find($request->existing_images_featured);
                if ($featuredImage) {
                    $featuredImage->is_featured = true;
                    $featuredImage->save();
                }
            }
            
            DB::commit();
            
            $message = 'Sortie mise à jour avec succès';
            if (!empty($imageErrors)) {
                $message .= ' mais avec des erreurs d\'images: ' . implode(', ', $imageErrors);
            }
            
            $notification = array(
                'message' => $message,
                'alert-type' => !empty($imageErrors) ? 'warning' : 'success'
            );
            
            return redirect()->route('admin.all.sortie')->with($notification);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $notification = array(
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification)->withInput();
        }
    }

    // Supprimer une sortie
    public function destroy($id)
    {
        $sortie = Sortie::findOrFail($id);
        
        // Supprimer le fichier GPX
        if ($sortie->gpx_file_path) {
            Storage::disk('public')->delete($sortie->gpx_file_path);
        }
        
        // Supprimer les images
        foreach ($sortie->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }
        
        // Supprimer la sortie (les points et images seront supprimés en cascade)
        $sortie->delete();
        
        $notification = array(
            'message' => 'Sortie supprimée avec succès',
            'alert-type' => 'warning'
        );
        
        return redirect()->route('admin.all.sortie')->with($notification);
    }

    // Publier une sortie
    public function publish($id)
    {
        $sortie = Sortie::findOrFail($id);
        $sortie->status = 'published';
        $sortie->published_at = now();
        $sortie->save();
        
        $notification = array(
            'message' => 'Sortie publiée avec succès',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }

    // Dépublier une sortie
    public function unpublish($id)
    {
        $sortie = Sortie::findOrFail($id);
        $sortie->status = 'draft';
        $sortie->published_at = null;
        $sortie->save();
        
        $notification = array(
            'message' => 'Sortie dépubliée',
            'alert-type' => 'info'
        );
        
        return redirect()->back()->with($notification);
    }

    // Supprimer une image de sortie
    public function deleteImage($id)
    {
        $image = SortieImage::findOrFail($id);
        $sortieId = $image->sortie_id;
        
        // Supprimer le fichier physique
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }
        
        // Supprimer aussi la vignette si elle existe
        $thumbPath = str_replace('/sortie/', '/sortie/thumb_', $image->image_path);
        if (file_exists(public_path($thumbPath))) {
            unlink(public_path($thumbPath));
        }
        
        // Supprimer l'enregistrement en base
        $image->delete();
        
        $notification = array(
            'message' => 'Image supprimée avec succès',
            'alert-type' => 'success'
        );
        
        return redirect()->route('admin.edit.sortie', $sortieId)->with($notification);
    }

    /**
     * Upload et redimensionnement des images de sortie
     */
    private function uploadSortieImage($file)
    {
        try {
            // Log détaillé pour le débogage
            Log::info('uploadSortieImage appelée avec:', [
                'file_exists' => $file ? 'oui' : 'non',
                'file_class' => $file ? get_class($file) : 'null',
                'is_valid' => $file ? ($file->isValid() ? 'oui' : 'non') : 'n/a',
                'original_name' => $file ? $file->getClientOriginalName() : 'n/a',
                'mime_type' => $file ? $file->getMimeType() : 'n/a',
                'size' => $file ? $file->getSize() : 'n/a',
                'error' => $file ? $file->getError() : 'n/a'
            ]);
            
            // Vérifier que le fichier est valide
            if (!$file) {
                throw new \Exception('Fichier null ou vide');
            }
            
            if (!$file->isValid()) {
                $error = $file->getError();
                $errorMessage = $this->getUploadErrorMessage($error);
                throw new \Exception('Fichier invalide: ' . $errorMessage . ' (code: ' . $error . ')');
            }
            
            // Créer le répertoire s'il n'existe pas
            $uploadDir = base_path('upload/sortie');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Générer un nom unique pour le fichier
            $extension = $file->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.' . $extension;
            
            // Créer le gestionnaire d'image
            $manager = new ImageManager(new Driver());
            
            // Lire et redimensionner l'image principale
            $image = $manager->read($file);
            $image->resize(618, 306);
            
            // Sauvegarder l'image principale
            $mainImagePath = $uploadDir . '/' . $name_gen;
            $image->save($mainImagePath);
            
            // Créer et sauvegarder la vignette
            $thumbImage = $manager->read($file);
            $thumbImage->resize(300, 200);
            
            $thumbName = 'thumb_' . $name_gen;
            $thumbPath = $uploadDir . '/' . $thumbName;
            $thumbImage->save($thumbPath);
            
            // Vérifier que les fichiers ont été créés
            if (!file_exists($mainImagePath)) {
                throw new \Exception('Erreur lors de la sauvegarde de l\'image principale');
            }
            
            if (!file_exists($thumbPath)) {
                throw new \Exception('Erreur lors de la sauvegarde de la vignette');
            }
            
            Log::info('Image traitée avec succès:', [
                'main_path' => $mainImagePath,
                'thumb_path' => $thumbPath,
                'return_path' => 'upload/sortie/' . $name_gen
            ]);
            
            // Retourner le chemin relatif pour la base de données
            return 'upload/sortie/' . $name_gen;
            
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur uploadSortieImage: ' . $e->getMessage());
            throw new \Exception('Erreur lors du traitement de l\'image: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtenir un message d'erreur lisible pour les codes d'erreur d'upload
     */
    private function getUploadErrorMessage($errorCode)
    {
        $errors = [
            UPLOAD_ERR_OK => 'Aucune erreur',
            UPLOAD_ERR_INI_SIZE => 'Fichier trop volumineux (php.ini)',
            UPLOAD_ERR_FORM_SIZE => 'Fichier trop volumineux (formulaire)',
            UPLOAD_ERR_PARTIAL => 'Upload partiel',
            UPLOAD_ERR_NO_FILE => 'Aucun fichier',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant',
            UPLOAD_ERR_CANT_WRITE => 'Erreur d\'écriture',
            UPLOAD_ERR_EXTENSION => 'Extension bloquée'
        ];
        
        return $errors[$errorCode] ?? 'Erreur inconnue (code: ' . $errorCode . ')';
    }
}