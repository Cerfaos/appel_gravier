<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpgCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'icon',
        'color',
        'order_position',
        'status'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function exercises(): HasMany
    {
        return $this->hasMany(PpgExercise::class, 'category_id')->orderBy('order_position');
    }

    public function programs(): HasMany
    {
        return $this->hasMany(PpgProgram::class, 'category_id')->orderBy('order_position');
    }

    public function publishedExercises(): HasMany
    {
        return $this->exercises()->where('status', 'published');
    }

    public function publishedPrograms(): HasMany
    {
        return $this->programs()->where('status', 'published');
    }
}
