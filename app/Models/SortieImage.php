<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SortieImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sortie_id',
        'image_path',
        'caption',
        'is_featured',
        'order_position'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order_position' => 'integer'
    ];

    public function sortie(): BelongsTo
    {
        return $this->belongsTo(Sortie::class);
    }

    // Accesseurs pour les URLs des images
    public function getMainImageAttribute()
    {
        return asset($this->image_path);
    }
    
    public function getMediumImageAttribute()
    {
        return asset($this->image_path);
    }

    public function getDetailImageAttribute()
    {
        return asset($this->image_path);
    }
}