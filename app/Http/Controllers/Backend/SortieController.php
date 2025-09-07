<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sortie;
use App\Models\SortieImage;
use App\Services\GpxParserService;
use App\Http\Requests\StoreSortieRequest;
use App\Http\Requests\UpdateSortieRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SortieController extends Controller
{
    protected $gpxParser;

    public function __construct(GpxParserService $gpxParser)
    {
        $this->gpxParser = $gpxParser;
    }

    // Afficher toutes les sorties (admin)
    public function index(Request $request)
    {
        $query = Sortie::with(['user', 'featuredImage']);
        
        // Filtrage par statut
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        
        // Statistiques pour la vue
        $stats = [
            'total' => Sortie::count(),
            'published' => Sortie::where('status', 'published')->count(),
            'draft' => Sortie::where('status', 'draft')->count()
        ];
        
        $sorties = $query->latest()->paginate(10);
        
        return view('admin.sorties.index', compact('sorties', 'stats'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('admin.sorties.create');
    }

    // Enregistrer une nouvelle sortie
    public function store(Request $request)
    {
        // EMERGENCY DEBUG - Log EVERYTHING that reaches this method
        Log::emergency('SortieController::store - REACHED!', [
            'all_data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url(),
            'user_id' => auth()->id(),
            'has_files' => !empty($request->allFiles()),
            'csrf_token' => $request->input('_token')
        ]);
        
        Log::info('SortieController::store - Début de la création', [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'has_gpx' => $request->hasFile('gpx_file'),
            'has_images' => $request->hasFile('images'),
            'request_data' => $request->except(['gpx_file', 'images'])
        ]);
        
        try {
            // Créer la sortie de base
            $sortie = new Sortie();
            $sortie->user_id = auth()->id();
            $sortie->title = $request->title;
            $sortie->slug = Str::slug($request->title);
            $sortie->description = $request->description;
            $sortie->personal_comment = $request->personal_comment;
            $sortie->difficulty_level = $request->difficulty_level;
            $sortie->departement = $request->departement;
            $sortie->pays = $request->pays;
            $sortie->actual_duration_minutes = $request->actual_duration_minutes;
            $sortie->weather_conditions = $request->weather_conditions;
            $sortie->sortie_date = $request->sortie_date;
            $sortie->meta_title = $request->meta_title;
            $sortie->meta_description = $request->meta_description;
            $sortie->status = $request->input('status', 'draft');

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
            
            // Gérer les images si présentes
            $imageErrors = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    if ($image->isValid()) {
                        try {
                            $imagePath = $this->uploadSortieImage($image);
                            
                            // Créer l'enregistrement en base
                            SortieImage::create([
                                'sortie_id' => $sortie->id,
                                'image_path' => $imagePath,
                                'caption' => $request->input("image_captions.{$index}", ''),
                                'is_featured' => $request->featured_image_index == $index,
                                'order_position' => $index
                            ]);
                        } catch (\Exception $e) {
                            // Log l'erreur et l'ajouter à la notification
                            Log::error('Erreur upload image sortie: ' . $e->getMessage());
                            $imageErrors[] = "Image {$index}: " . $e->getMessage();
                        }
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
    public function update(UpdateSortieRequest $request)
    {
        $id = $request->id;
        $sortie = Sortie::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Mise à jour des champs de base
            $sortie->title = $request->title;
            $sortie->slug = Str::slug($request->title);
            $sortie->description = $request->description;
            $sortie->personal_comment = $request->personal_comment;
            $sortie->difficulty_level = $request->difficulty_level;
            $sortie->departement = $request->departement;
            $sortie->pays = $request->pays;
            $sortie->actual_duration_minutes = $request->actual_duration_minutes;
            $sortie->weather_conditions = $request->weather_conditions;
            $sortie->sortie_date = $request->sortie_date;
            $sortie->meta_title = $request->meta_title;
            $sortie->meta_description = $request->meta_description;
            
            // Gestion du statut et date de publication
            $oldStatus = $sortie->status;
            $newStatus = $request->input('status', $sortie->status);
            $sortie->status = $newStatus;
            
            if ($newStatus === 'published' && $oldStatus !== 'published') {
                $sortie->published_at = now();
            } elseif ($newStatus !== 'published') {
                $sortie->published_at = null;
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
            
            // Gérer les nouvelles images si présentes
            $imageErrors = [];
            $newImages = [];
            
            // Debug logging
            Log::info('Sortie Update - Debug info:', [
                'has_new_images' => $request->hasFile('new_images'),
                'new_images_count' => $request->hasFile('new_images') ? count($request->file('new_images')) : 0,
                'all_files' => $request->allFiles(),
                'sortie_id' => $sortie->id
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