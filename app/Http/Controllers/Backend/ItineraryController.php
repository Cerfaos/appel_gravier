<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use App\Models\ItineraryImage;
use App\Services\GpxParserService;
use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ItineraryController extends Controller
{
    protected $gpxParser;

    public function __construct(GpxParserService $gpxParser)
    {
        $this->gpxParser = $gpxParser;
    }

    // Afficher tous les itinéraires (admin)
    public function index(Request $request)
    {
        $query = Itinerary::with(['user', 'featuredImage']);
        
        // Filtrage par statut
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        
        // Statistiques pour la vue
        $stats = [
            'total' => Itinerary::count(),
            'published' => Itinerary::where('status', 'published')->count(),
            'draft' => Itinerary::where('status', 'draft')->count()
        ];
        
        $itineraries = $query->latest()->paginate(10);
        
        return view('admin.itineraries.index', compact('itineraries', 'stats'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('admin.itineraries.create');
    }

    // Enregistrer un nouvel itinéraire
    public function store(Request $request)
    {
        
        Log::info('ItineraryController::store - Début de la création', [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'has_gpx' => $request->hasFile('gpx_file'),
            'has_images' => $request->hasFile('images'),
            'request_data' => $request->except(['gpx_file', 'images'])
        ]);
        
        try {
            // Créer l'itinéraire de base
            $itinerary = new Itinerary();
            $itinerary->user_id = auth()->id();
            $itinerary->title = $request->title;
            $itinerary->slug = Str::slug($request->title);
            $itinerary->description = $request->description;
            $itinerary->personal_comment = $request->personal_comment;
            $itinerary->difficulty_level = $request->difficulty_level;
            $itinerary->departement = $request->departement;
            $itinerary->pays = $request->pays;
            $itinerary->meta_title = $request->meta_title;
            $itinerary->meta_description = $request->meta_description;
            $itinerary->status = $request->input('status', 'draft');

            // Upload et parse du fichier GPX si présent
            if ($request->hasFile('gpx_file')) {
                $gpxFile = $request->file('gpx_file');
                $gpxContent = file_get_contents($gpxFile->getRealPath());
                
                // Parser le GPX
                $gpxData = $this->gpxParser->parse($gpxContent);
                
                // Sauvegarder le fichier GPX avec l'extension .gpx
                $filename = time() . '_' . uniqid() . '.gpx';
                $gpxPath = $gpxFile->storeAs('gpx', $filename, 'public');
                
                // Ajouter les données GPX à l'itinéraire
                $itinerary->gpx_file_path = $gpxPath;
                $itinerary->distance_km = $gpxData['statistics']['distance_km'];
                $itinerary->elevation_gain_m = $gpxData['statistics']['elevation_gain_m'];
                $itinerary->elevation_loss_m = $gpxData['statistics']['elevation_loss_m'];
                $itinerary->estimated_duration_minutes = round(($gpxData['statistics']['distance_km'] / 25) * 60); // 25 km/h estimation
                $itinerary->min_latitude = $gpxData['statistics']['min_latitude'];
                $itinerary->max_latitude = $gpxData['statistics']['max_latitude'];
                $itinerary->min_longitude = $gpxData['statistics']['min_longitude'];
                $itinerary->max_longitude = $gpxData['statistics']['max_longitude'];
            }
            
            // Définir la date de publication si publié
            if ($itinerary->status === 'published') {
                $itinerary->published_at = now();
            }
            
            Log::info('ItineraryController::store - Avant save()', [
                'itinerary_data' => $itinerary->toArray()
            ]);
            
            $saved = $itinerary->save();
            
            Log::info('ItineraryController::store - Après save()', [
                'save_result' => $saved,
                'itinerary_id' => $itinerary->id,
                'itinerary_exists' => $itinerary->exists
            ]);
            
            // Sauvegarder les points GPS si il y en a
            if (isset($gpxData) && isset($gpxData['points'])) {
                foreach ($gpxData['points'] as $index => $point) {
                    $itinerary->gpxPoints()->create([
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
                            $imagePath = $this->uploadItineraryImage($image);
                            
                            // Créer l'enregistrement en base
                            ItineraryImage::create([
                                'itinerary_id' => $itinerary->id,
                                'image_path' => $imagePath,
                                'caption' => $request->input("image_captions.{$index}", ''),
                                'is_featured' => $request->featured_image_index == $index,
                                'order_position' => $index
                            ]);
                            
                        } catch (\Exception $e) {
                            // Log l'erreur et l'ajouter à la notification
                            Log::error('Erreur upload image: ' . $e->getMessage());
                            $imageErrors[] = "Image {$index}: " . $e->getMessage();
                        }
                    }
                }
            }
            
            $message = 'Itinéraire créé avec succès';
            if (!empty($imageErrors)) {
                $message .= ' mais avec des erreurs d\'images: ' . implode(', ', $imageErrors);
            }
            
            $notification = array(
                'message' => $message,
                'alert-type' => !empty($imageErrors) ? 'warning' : 'success'
            );
            
            Log::info('ItineraryController::store - Fin avec succès', [
                'itinerary_id' => $itinerary->id,
                'message' => $message
            ]);
            
            return redirect()->route('admin.all.itinerary')->with($notification);
            
        } catch (\Exception $e) {
            Log::error('ItineraryController::store - Erreur', [
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

    // Afficher les détails d'un itinéraire
    public function show($id)
    {
        $itinerary = Itinerary::with(['images', 'gpxPoints', 'user'])->findOrFail($id);
        return view('admin.itineraries.show', compact('itinerary'));
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $itinerary = Itinerary::with(['images', 'gpxPoints', 'user', 'featuredImage'])->findOrFail($id);
        return view('admin.itineraries.edit', compact('itinerary'));
    }

    // Mettre à jour un itinéraire
    public function update(UpdateItineraryRequest $request)
    {
        $id = $request->id;
        $itinerary = Itinerary::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Mise à jour des champs de base
            $itinerary->title = $request->title;
            $itinerary->slug = Str::slug($request->title);
            $itinerary->description = $request->description;
            $itinerary->personal_comment = $request->personal_comment;
            $itinerary->difficulty_level = $request->difficulty_level;
            $itinerary->departement = $request->departement;
            $itinerary->pays = $request->pays;
            $itinerary->meta_title = $request->meta_title;
            $itinerary->meta_description = $request->meta_description;
            
            // Gestion du statut et date de publication
            $oldStatus = $itinerary->status;
            $newStatus = $request->input('status', $itinerary->status);
            $itinerary->status = $newStatus;
            
            if ($newStatus === 'published' && $oldStatus !== 'published') {
                $itinerary->published_at = now();
            } elseif ($newStatus !== 'published') {
                $itinerary->published_at = null;
            }
            
            // Si un nouveau fichier GPX est uploadé
            if ($request->hasFile('gpx_file')) {
                // Supprimer l'ancien fichier
                if ($itinerary->gpx_file_path) {
                    Storage::disk('public')->delete($itinerary->gpx_file_path);
                }
                
                // Traiter le nouveau fichier
                $gpxFile = $request->file('gpx_file');
                $gpxContent = file_get_contents($gpxFile->getRealPath());
                $gpxData = $this->gpxParser->parse($gpxContent);
                
                // Sauvegarder le fichier GPX avec l'extension .gpx
                $filename = time() . '_' . uniqid() . '.gpx';
                $gpxPath = $gpxFile->storeAs('gpx', $filename, 'public');
                
                // Mettre à jour les statistiques
                $itinerary->gpx_file_path = $gpxPath;
                $itinerary->distance_km = $gpxData['statistics']['distance_km'];
                $itinerary->elevation_gain_m = $gpxData['statistics']['elevation_gain_m'];
                $itinerary->elevation_loss_m = $gpxData['statistics']['elevation_loss_m'];
                $itinerary->estimated_duration_minutes = round(($gpxData['statistics']['distance_km'] / 25) * 60); // 25 km/h estimation
                $itinerary->min_latitude = $gpxData['statistics']['min_latitude'];
                $itinerary->max_latitude = $gpxData['statistics']['max_latitude'];
                $itinerary->min_longitude = $gpxData['statistics']['min_longitude'];
                $itinerary->max_longitude = $gpxData['statistics']['max_longitude'];
                
                // Supprimer les anciens points et ajouter les nouveaux
                $itinerary->gpxPoints()->delete();
                foreach ($gpxData['points'] as $index => $point) {
                    $itinerary->gpxPoints()->create([
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
                    $image = ItineraryImage::where('itinerary_id', $itinerary->id)->find($imageId);
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
            
            // Gestion de la nouvelle image principale
            if ($request->filled('new_featured_image_id')) {
                // Désactiver toutes les images principales actuelles
                ItineraryImage::where('itinerary_id', $itinerary->id)->update(['is_featured' => false]);
                
                // Activer la nouvelle image principale
                $newFeaturedImage = ItineraryImage::where('itinerary_id', $itinerary->id)
                    ->find($request->new_featured_image_id);
                if ($newFeaturedImage) {
                    $newFeaturedImage->is_featured = true;
                    $newFeaturedImage->save();
                }
            }

            // Gestion des modifications des légendes d'images existantes
            if ($request->has('image_captions')) {
                foreach ($request->image_captions as $imageId => $caption) {
                    $image = ItineraryImage::where('itinerary_id', $itinerary->id)->find($imageId);
                    if ($image) {
                        $image->caption = $caption;
                        $image->save();
                    }
                }
            }
            
            $itinerary->save();
            
            // Gérer les nouvelles images si présentes
            $imageErrors = [];
            if ($request->hasFile('new_images')) {
                $existingImagesCount = $itinerary->images()->count();
                
                foreach ($request->file('new_images') as $index => $image) {
                    if ($image->isValid()) {
                        try {
                            $imagePath = $this->uploadItineraryImage($image);
                            
                            // Créer l'enregistrement en base
                            ItineraryImage::create([
                                'itinerary_id' => $itinerary->id,
                                'image_path' => $imagePath,
                                'caption' => $request->input("new_image_captions.{$index}", ''),
                                'is_featured' => false, // Les nouvelles images ne sont jamais featured par défaut
                                'order_position' => $existingImagesCount + $index
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Erreur upload image itinéraire update: ' . $e->getMessage());
                            $imageErrors[] = "Image {$index}: " . $e->getMessage();
                        }
                    }
                }
            }
            
            DB::commit();
            
            $message = 'Itinéraire mis à jour avec succès';
            if (!empty($imageErrors)) {
                $message .= ' mais avec des erreurs d\'images: ' . implode(', ', $imageErrors);
            }
            
            $notification = array(
                'message' => $message,
                'alert-type' => !empty($imageErrors) ? 'warning' : 'success'
            );
            
            return redirect()->route('admin.all.itinerary')->with($notification);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $notification = array(
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification)->withInput();
        }
    }

    // Supprimer un itinéraire
    public function destroy($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        
        // Supprimer le fichier GPX
        if ($itinerary->gpx_file_path) {
            Storage::disk('public')->delete($itinerary->gpx_file_path);
        }
        
        // Supprimer les images
        foreach ($itinerary->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }
        
        // Supprimer l'itinéraire (les points et images seront supprimés en cascade)
        $itinerary->delete();
        
        $notification = array(
            'message' => 'Itinéraire supprimé avec succès',
            'alert-type' => 'warning'
        );
        
        return redirect()->route('admin.all.itinerary')->with($notification);
    }

    // Publier un itinéraire
    public function publish($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->status = 'published';
        $itinerary->published_at = now();
        $itinerary->save();
        
        $notification = array(
            'message' => 'Itinéraire publié avec succès',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }

    // Dépublier un itinéraire
    public function unpublish($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->status = 'draft';
        $itinerary->published_at = null;
        $itinerary->save();
        
        $notification = array(
            'message' => 'Itinéraire dépublié',
            'alert-type' => 'info'
        );
        
        return redirect()->back()->with($notification);
    }

    // Supprimer une image d'itinéraire
    public function deleteImage($id)
    {
        $image = ItineraryImage::findOrFail($id);
        $itineraryId = $image->itinerary_id;
        
        // Supprimer le fichier physique
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }
        
        // Supprimer aussi la vignette si elle existe
        $thumbPath = str_replace('/itinerary/', '/itinerary/thumb_', $image->image_path);
        if (file_exists(public_path($thumbPath))) {
            unlink(public_path($thumbPath));
        }
        
        // Supprimer l'enregistrement en base
        $image->delete();
        
        $notification = array(
            'message' => 'Image supprimée avec succès',
            'alert-type' => 'success'
        );
        
        return redirect()->route('admin.edit.itinerary', $itineraryId)->with($notification);
    }

    /**
     * Upload et redimensionnement des images d'itinéraire
     * Principe exact comme SliderController : import → resize → export vers public
     */
    private function uploadItineraryImage($file)
    {
        try {
            
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
            $uploadDir = base_path('upload/itinerary');
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
            
            // Retourner le chemin relatif pour la base de données
            return 'upload/itinerary/' . $name_gen;
            
        } catch (\Exception $e) {
            Log::error('Erreur uploadItineraryImage: ' . $e->getMessage());
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