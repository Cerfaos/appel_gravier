<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpgExercise extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'instructions',
        'difficulty_level',
        'duration_minutes',
        'sets',
        'reps',
        'rest_time',
        'equipment',
        'target_muscles',
        'images',
        'video_url',
        'tips',
        'precautions',
        'order_position',
        'status',
        'published_at'
    ];

    protected $casts = [
        'images' => 'array',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PpgCategory::class, 'category_id');
    }

    public function featuredImage()
    {
        if ($this->images && count($this->images) > 0) {
            return $this->images[0];
        }
        return null;
    }
}
