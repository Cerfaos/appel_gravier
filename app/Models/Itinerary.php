<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "title", "slug", "description", "departement", "pays", "personal_comment",
        "gpx_file_path", "distance_km", "elevation_gain_m", "elevation_loss_m",
        "difficulty_level", "estimated_duration_minutes", "min_latitude",
        "max_latitude", "min_longitude", "max_longitude", "status",
        "published_at", "meta_title", "meta_description", "og_image"
    ];

    protected $casts = [
        "published_at" => "datetime",
        "distance_km" => "decimal:2",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gpxPoints(): HasMany
    {
        return $this->hasMany(GpxPoint::class)->orderBy("point_order");
    }

    public function images(): HasMany
    {
        return $this->hasMany(ItineraryImage::class)->orderBy("order_position");
    }

    public function featuredImage()
    {
        return $this->hasOne(ItineraryImage::class)->where("is_featured", true);
    }
}