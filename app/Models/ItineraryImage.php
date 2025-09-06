<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItineraryImage extends Model
{
    protected $fillable = [
        'itinerary_id', 'image_path', 'caption', 'is_featured', 'order_position'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order_position' => 'integer',
    ];

    // Relations
    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }

    // Méthodes pour les formats d'image (exactement comme SliderController)
    public function getImageUrl($format = 'main'): string
    {
        if (!$this->image_path) return '';
        
        // Principe SliderController : chemin direct vers public
        if ($format === 'thumb') {
            $pathInfo = pathinfo($this->image_path);
            $directory = $pathInfo['dirname'];
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'];
            return asset($directory . '/thumb_' . $filename . '.' . $extension);
        }
        
        // Image principale (comme SliderController)
        return asset($this->image_path);
    }

    // Accesseurs simples (principe SliderController)
    public function getThumbImageAttribute(): string
    {
        return $this->getImageUrl('thumb');
    }

    public function getMainImageAttribute(): string
    {
        return $this->getImageUrl('main');
    }

    // Compatibilité (tous pointent vers l'image principale redimensionnée)
    public function getMediumImageAttribute(): string
    {
        return $this->getMainImageAttribute();
    }

    public function getHeroImageAttribute(): string
    {
        return $this->getMainImageAttribute();
    }

    public function getDetailImageAttribute(): string
    {
        return $this->getMainImageAttribute();
    }

    public function getFullImagePathAttribute(): string
    {
        return $this->getMainImageAttribute();
    }
}
