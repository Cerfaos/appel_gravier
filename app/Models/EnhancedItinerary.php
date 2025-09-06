<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class EnhancedItinerary extends Model
{
    use HasFactory;

    protected $table = 'itineraries';

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
        "elevation_gain_m" => "integer",
        "elevation_loss_m" => "integer",
        "estimated_duration_minutes" => "integer",
        "min_latitude" => "decimal:8",
        "max_latitude" => "decimal:8",
        "min_longitude" => "decimal:8",
        "max_longitude" => "decimal:8",
    ];

    protected $with = ['featuredImage']; // Always eager load featured image

    // Indexes for better performance
    protected $indexHints = [
        'status',
        'difficulty_level', 
        'departement',
        'published_at'
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

    // Optimized scopes for common queries
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeByDifficulty(Builder $query, string $difficulty): Builder
    {
        return $query->where('difficulty_level', $difficulty);
    }

    public function scopeByDepartement(Builder $query, string $departement): Builder
    {
        return $query->where('departement', $departement);
    }

    public function scopeWithDistance(Builder $query, float $minDistance = null, float $maxDistance = null): Builder
    {
        if ($minDistance !== null) {
            $query->where('distance_km', '>=', $minDistance);
        }
        if ($maxDistance !== null) {
            $query->where('distance_km', '<=', $maxDistance);
        }
        return $query;
    }

    public function scopeWithElevation(Builder $query, int $minElevation = null, int $maxElevation = null): Builder
    {
        if ($minElevation !== null) {
            $query->where('elevation_gain_m', '>=', $minElevation);
        }
        if ($maxElevation !== null) {
            $query->where('elevation_gain_m', '<=', $maxElevation);
        }
        return $query;
    }

    // Cache popular statistics
    public static function getCachedStats(): array
    {
        return Cache::remember('itinerary_stats', 3600, function () {
            $published = self::published();
            
            return [
                'total_published' => $published->count(),
                'by_difficulty' => [
                    'facile' => $published->byDifficulty('facile')->count(),
                    'moyen' => $published->byDifficulty('moyen')->count(),
                    'difficile' => $published->byDifficulty('difficile')->count(),
                ],
                'total_distance' => $published->sum('distance_km'),
                'total_elevation' => $published->sum('elevation_gain_m'),
                'average_distance' => $published->avg('distance_km'),
                'average_elevation' => $published->avg('elevation_gain_m'),
                'popular_departments' => $published
                    ->select('departement')
                    ->whereNotNull('departement')
                    ->groupBy('departement')
                    ->orderByRaw('COUNT(*) DESC')
                    ->limit(10)
                    ->pluck('departement')
                    ->toArray(),
            ];
        });
    }

    // Optimized search
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('departement', 'like', "%{$search}%")
              ->orWhere('pays', 'like', "%{$search}%");
        });
    }

    // Get similar itineraries (cached)
    public function getSimilarItineraries(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        $cacheKey = "similar_itineraries_{$this->id}_{$limit}";
        
        return Cache::remember($cacheKey, 1800, function () use ($limit) {
            return self::published()
                ->where('id', '!=', $this->id)
                ->where(function ($query) {
                    // Similar difficulty
                    $query->where('difficulty_level', $this->difficulty_level)
                          // Or similar distance (±20%)
                          ->orWhereBetween('distance_km', [
                              $this->distance_km * 0.8,
                              $this->distance_km * 1.2
                          ])
                          // Or same departement
                          ->orWhere('departement', $this->departement);
                })
                ->with(['featuredImage', 'user'])
                ->limit($limit)
                ->get();
        });
    }

    // SEO optimized URL generation
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getUrlAttribute(): string
    {
        return route('itineraries.show', $this->slug);
    }

    // Performance: Accessor for formatted data
    public function getFormattedDistanceAttribute(): string
    {
        return number_format($this->distance_km, 1) . ' km';
    }

    public function getFormattedElevationAttribute(): string
    {
        return number_format($this->elevation_gain_m) . ' m D+';
    }

    public function getFormattedDurationAttribute(): string
    {
        $hours = intval($this->estimated_duration_minutes / 60);
        $minutes = $this->estimated_duration_minutes % 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    // Clear related caches when model changes
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('itinerary_stats');
        });

        static::deleted(function () {
            Cache::forget('itinerary_stats');
        });
    }
}