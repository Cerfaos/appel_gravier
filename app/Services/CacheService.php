<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheService
{
    const CACHE_TAGS = [
        'itineraries' => 'itineraries',
        'sorties' => 'sorties',
        'stats' => 'stats',
        'gpx' => 'gpx',
        'users' => 'users'
    ];

    const CACHE_TTL = [
        'short' => 300,    // 5 minutes
        'medium' => 1800,  // 30 minutes
        'long' => 3600,    // 1 hour
        'daily' => 86400,  // 24 hours
        'weekly' => 604800 // 7 days
    ];

    /**
     * Cache des itinéraires populaires
     */
    public function getPopularItineraries(int $limit = 10)
    {
        $cacheKey = 'popular_itineraries_' . $limit;
        
        // Vérifier si le cache supporte les tags
        if ($this->supportsTagging()) {
            return Cache::tags([self::CACHE_TAGS['itineraries']])
                ->remember($cacheKey, self::CACHE_TTL['medium'], function () use ($limit) {
                    return $this->fetchPopularItineraries($limit);
                });
        }
        
        // Fallback pour les stores sans tags
        return Cache::remember($cacheKey, self::CACHE_TTL['medium'], function () use ($limit) {
            return $this->fetchPopularItineraries($limit);
        });
    }

    /**
     * Cache des statistiques du dashboard admin
     */
    public function getDashboardStats()
    {
        return Cache::tags([self::CACHE_TAGS['stats']])
            ->remember('admin_dashboard_stats', self::CACHE_TTL['short'], function () {
                return [
                    'total_itineraries' => \App\Models\Itinerary::count(),
                    'published_itineraries' => \App\Models\Itinerary::where('status', 'published')->count(),
                    'total_sorties' => \App\Models\Sortie::count(),
                    'total_users' => \App\Models\User::count(),
                    'recent_contacts' => \App\Models\Contact::where('created_at', '>=', now()->subDays(7))->count(),
                    'total_gpx_points' => \App\Models\GpxPoint::count(),
                ];
            });
    }

    /**
     * Cache des données GPX lourdes
     */
    public function getGpxData(int $itineraryId)
    {
        return Cache::tags([self::CACHE_TAGS['gpx']])
            ->remember('gpx_data_' . $itineraryId, self::CACHE_TTL['long'], function () use ($itineraryId) {
                $itinerary = \App\Models\Itinerary::with('gpxPoints')->find($itineraryId);
                
                if (!$itinerary || $itinerary->gpxPoints->isEmpty()) {
                    return null;
                }

                return [
                    'points' => $itinerary->gpxPoints->map(function ($point) {
                        return [
                            'lat' => (float) $point->latitude,
                            'lng' => (float) $point->longitude,
                            'elevation' => (float) $point->elevation,
                            'order' => $point->point_order
                        ];
                    }),
                    'bounds' => [
                        'min_lat' => (float) $itinerary->min_latitude,
                        'max_lat' => (float) $itinerary->max_latitude,
                        'min_lng' => (float) $itinerary->min_longitude,
                        'max_lng' => (float) $itinerary->max_longitude,
                    ],
                    'stats' => [
                        'distance' => (float) $itinerary->distance_km,
                        'elevation_gain' => $itinerary->elevation_gain_m,
                        'elevation_loss' => $itinerary->elevation_loss_m,
                    ]
                ];
            });
    }

    /**
     * Cache des itinéraires par région
     */
    public function getItinerariesByRegion(string $region, int $limit = 20)
    {
        return Cache::tags([self::CACHE_TAGS['itineraries']])
            ->remember('itineraries_region_' . $region . '_' . $limit, self::CACHE_TTL['medium'], function () use ($region, $limit) {
                return \App\Models\Itinerary::with(['featuredImage', 'user'])
                    ->where('status', 'published')
                    ->where('departement', 'LIKE', '%' . $region . '%')
                    ->orderBy('created_at', 'desc')
                    ->take($limit)
                    ->get();
            });
    }

    /**
     * Cache des métadonnées pour le SEO
     */
    public function getSeoMetadata(string $route, $id = null)
    {
        $cacheKey = 'seo_metadata_' . $route . ($id ? '_' . $id : '');
        
        return Cache::tags(['seo'])
            ->remember($cacheKey, self::CACHE_TTL['daily'], function () use ($route, $id) {
                switch ($route) {
                    case 'itinerary':
                        if ($id) {
                            $itinerary = \App\Models\Itinerary::find($id);
                            return [
                                'title' => $itinerary->meta_title ?? $itinerary->title,
                                'description' => $itinerary->meta_description ?? substr($itinerary->description, 0, 160),
                                'image' => $itinerary->og_image ?? $itinerary->featuredImage?->image_path,
                            ];
                        }
                        break;
                    case 'home':
                        return [
                            'title' => 'Cerfaos - Gravel Biking Adventures',
                            'description' => 'Découvrez les meilleurs itinéraires de gravel bike en France et partagez vos aventures.',
                            'image' => '/images/home-og.jpg',
                        ];
                }
                return null;
            });
    }

    /**
     * Invalider le cache par tags
     */
    public function invalidateTag(string $tag): bool
    {
        try {
            Cache::tags([$tag])->flush();
            Log::info("Cache invalidated for tag: {$tag}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to invalidate cache for tag: {$tag}", ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Invalider le cache après modification d'un itinéraire
     */
    public function invalidateItineraryCache(int $itineraryId): void
    {
        $this->invalidateTag(self::CACHE_TAGS['itineraries']);
        $this->invalidateTag(self::CACHE_TAGS['stats']);
        Cache::forget('gpx_data_' . $itineraryId);
        
        Log::info("Invalidated cache for itinerary: {$itineraryId}");
    }

    /**
     * Invalider le cache après modification d'une sortie
     */
    public function invalidateSortieCache(int $sortieId): void
    {
        $this->invalidateTag(self::CACHE_TAGS['sorties']);
        $this->invalidateTag(self::CACHE_TAGS['stats']);
        
        Log::info("Invalidated cache for sortie: {$sortieId}");
    }

    /**
     * Précharger le cache des données populaires
     */
    public function warmupCache(): void
    {
        try {
            Log::info('Starting cache warmup...');
            
            // Précharger les itinéraires populaires
            $this->getPopularItineraries(10);
            $this->getPopularItineraries(20);
            
            // Précharger les statistiques
            $this->getDashboardStats();
            
            // Précharger les métadonnées SEO communes
            $this->getSeoMetadata('home');
            
            Log::info('Cache warmup completed successfully');
        } catch (\Exception $e) {
            Log::error('Cache warmup failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Obtenir les statistiques du cache
     */
    public function getCacheStats(): array
    {
        try {
            $redis = app('redis');
            $info = $redis->info('memory');
            
            return [
                'memory_used' => $info['used_memory_human'] ?? 'N/A',
                'memory_peak' => $info['used_memory_peak_human'] ?? 'N/A',
                'keys_count' => $redis->dbsize() ?? 0,
                'hit_rate' => $this->calculateHitRate(),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get cache stats', ['error' => $e->getMessage()]);
            return ['error' => 'Unable to retrieve cache statistics'];
        }
    }

    /**
     * Calculer le taux de réussite du cache
     */
    private function calculateHitRate(): string
    {
        try {
            $redis = app('redis');
            $info = $redis->info('stats');
            
            $hits = $info['keyspace_hits'] ?? 0;
            $misses = $info['keyspace_misses'] ?? 0;
            $total = $hits + $misses;
            
            if ($total === 0) {
                return '0%';
            }
            
            return round(($hits / $total) * 100, 2) . '%';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Vérifier si le driver de cache supporte les tags
     */
    private function supportsTagging(): bool
    {
        $driver = Cache::getStore();
        return method_exists($driver, 'tags');
    }

    /**
     * Récupérer les itinéraires populaires depuis la DB
     */
    private function fetchPopularItineraries(int $limit)
    {
        return \App\Models\Itinerary::with(['featuredImage', 'user'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
}