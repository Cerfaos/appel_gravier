<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clarify extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'features',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
