<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => asset($this->image_path),
            'caption' => $this->caption,
            'is_featured' => (bool) $this->is_featured,
            'order_position' => $this->order_position,
            
            // Métadonnées d'image (si disponibles)
            'metadata' => $this->when($this->shouldIncludeMetadata(), [
                'file_size' => $this->getFileSize(),
                'dimensions' => $this->getImageDimensions(),
                'mime_type' => $this->getMimeType(),
            ]),
            
            // Versions redimensionnées (si disponibles)
            'sizes' => [
                'thumbnail' => $this->getThumbnailUrl(),
                'medium' => $this->getMediumUrl(),
                'large' => asset($this->image_path), // Image originale
            ],
            
            // Timestamps
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }

    /**
     * Déterminer si les métadonnées doivent être incluses
     */
    private function shouldIncludeMetadata(): bool
    {
        return request()->has('include_metadata') || auth()->user()?->role === 'admin';
    }

    /**
     * Obtenir la taille du fichier
     */
    private function getFileSize(): ?int
    {
        $path = public_path($this->image_path);
        return file_exists($path) ? filesize($path) : null;
    }

    /**
     * Obtenir les dimensions de l'image
     */
    private function getImageDimensions(): ?array
    {
        $path = public_path($this->image_path);
        if (!file_exists($path)) {
            return null;
        }

        $dimensions = getimagesize($path);
        if (!$dimensions) {
            return null;
        }

        return [
            'width' => $dimensions[0],
            'height' => $dimensions[1],
            'aspect_ratio' => round($dimensions[0] / $dimensions[1], 2),
        ];
    }

    /**
     * Obtenir le type MIME
     */
    private function getMimeType(): ?string
    {
        $path = public_path($this->image_path);
        return file_exists($path) ? mime_content_type($path) : null;
    }

    /**
     * Obtenir l'URL de la miniature
     */
    private function getThumbnailUrl(): string
    {
        // Logique pour générer ou récupérer l'URL de la miniature
        $pathInfo = pathinfo($this->image_path);
        $thumbnailPath = $pathInfo['dirname'] . '/thumbs/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
        
        return file_exists(public_path($thumbnailPath)) 
            ? asset($thumbnailPath) 
            : asset($this->image_path);
    }

    /**
     * Obtenir l'URL de la taille moyenne
     */
    private function getMediumUrl(): string
    {
        // Logique pour générer ou récupérer l'URL de taille moyenne
        $pathInfo = pathinfo($this->image_path);
        $mediumPath = $pathInfo['dirname'] . '/medium/' . $pathInfo['filename'] . '_medium.' . $pathInfo['extension'];
        
        return file_exists(public_path($mediumPath)) 
            ? asset($mediumPath) 
            : asset($this->image_path);
    }
}