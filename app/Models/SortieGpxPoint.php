<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SortieGpxPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'sortie_id',
        'latitude',
        'longitude',
        'elevation',
        'point_order',
        'timestamp'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'elevation' => 'decimal:2',
        'point_order' => 'integer',
        'timestamp' => 'datetime'
    ];

    public function sortie(): BelongsTo
    {
        return $this->belongsTo(Sortie::class);
    }
}