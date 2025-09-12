<?php

namespace App\Services;

use App\Models\Sortie;
use App\Models\SortieImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SortieService
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Créer une nouvelle sortie
     */
    public function createSortie(array $data): Sortie
    {
        // Générer le slug automatiquement
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        
        // Créer la sortie
        return Sortie::create($data);
    }

    /**
     * Mettre à jour une sortie
     */
    public function updateSortie(Sortie $sortie, array $data): Sortie
    {
        // Mettre à jour le slug si le titre change
        if (isset($data['title']) && $data['title'] !== $sortie->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        $sortie->update($data);
        return $sortie->fresh();
    }

    /**
     * Publier une sortie
     */
    public function publishSortie(Sortie $sortie): Sortie
    {
        $sortie->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return $sortie;
    }

    /**
     * Dépublier une sortie
     */
    public function unpublishSortie(Sortie $sortie): Sortie
    {
        $sortie->update([
            'status' => 'draft',
            'published_at' => null
        ]);

        return $sortie;
    }

    /**
     * Upload et traitement d'image
     */
    public function uploadImage(UploadedFile $file, string $directory = 'sortie'): string
    {
        // Générer un nom unique
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "upload/{$directory}/" . $filename;

        // Redimensionner et optimiser l'image
        $image = $this->imageManager->read($file->getPathname());
        
        // Redimensionner si trop grande (max 1920px)
        if ($image->width() > 1920) {
            $image->scale(width: 1920);
        }

        // Sauvegarder avec compression
        $image->save(public_path($path), quality: 85);

        return $path;
    }

    /**
     * Ajouter une image à une sortie
     */
    public function addImageToSortie(Sortie $sortie, UploadedFile $file, bool $isFeatured = false): SortieImage
    {
        $imagePath = $this->uploadImage($file);

        return SortieImage::create([
            'sortie_id' => $sortie->id,
            'image_path' => $imagePath,
            'is_featured' => $isFeatured,
            'order_position' => $this->getNextImagePosition($sortie)
        ]);
    }

    /**
     * Supprimer une image
     */
    public function deleteImage(SortieImage $image): bool
    {
        // Supprimer le fichier physique
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Supprimer de la DB
        return $image->delete();
    }

    /**
     * Générer un slug unique
     */
    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Sortie::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Obtenir la prochaine position pour une image
     */
    private function getNextImagePosition(Sortie $sortie): int
    {
        return $sortie->images()->max('order_position') + 1 ?? 1;
    }

    /**
     * Obtenir les sorties avec pagination et filtres
     */
    public function getSorties(array $filters = [], int $perPage = 15)
    {
        $query = Sortie::with(['user', 'featuredImage']);

        // Filtres
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['departement'])) {
            $query->where('departement', $filters['departement']);
        }

        if (isset($filters['difficulty'])) {
            $query->where('difficulty_level', $filters['difficulty']);
        }

        return $query->latest('published_at')->paginate($perPage);
    }

    /**
     * Obtenir les sorties publiques pour le frontend
     */
    public function getPublishedSorties(int $limit = null)
    {
        $query = Sortie::where('status', 'published')
            ->with(['featuredImage', 'user'])
            ->latest('published_at');

        return $limit ? $query->take($limit)->get() : $query->paginate(12);
    }
}