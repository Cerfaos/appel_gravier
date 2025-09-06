<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'key', 
        'title',
        'description',
        'content',
        'image',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    // Helper method pour récupérer du contenu par clé
    public static function getContent($key, $default = null)
    {
        $content = static::where('key', $key)->first();
        return $content ? $content : $default;
    }

    // Helper method pour récupérer une valeur spécifique
    public static function getValue($key, $field = 'content', $default = '')
    {
        $content = static::where('key', $key)->first();
        return $content ? $content->$field : $default;
    }
}