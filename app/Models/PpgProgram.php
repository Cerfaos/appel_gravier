<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpgProgram extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'objectives',
        'difficulty_level',
        'duration_weeks',
        'sessions_per_week',
        'session_duration_minutes',
        'exercises',
        'progression_notes',
        'target_audience',
        'images',
        'order_position',
        'status',
        'published_at'
    ];

    protected $casts = [
        'exercises' => 'array',
        'images' => 'array',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PpgCategory::class, 'category_id');
    }

    public function getExerciseDetails()
    {
        if (!$this->exercises) {
            return collect();
        }

        $exerciseIds = array_column($this->exercises, 'exercise_id');
        return PpgExercise::whereIn('id', $exerciseIds)->get()->keyBy('id');
    }

    public function featuredImage()
    {
        if ($this->images && count($this->images) > 0) {
            return $this->images[0];
        }
        return null;
    }
}
