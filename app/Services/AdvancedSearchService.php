<?php

namespace App\Services;

use App\Models\Itinerary;
use App\Models\Sortie;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdvancedSearchService
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Recherche unifiée multi-modèles avec scoring de pertinence
     */
    public function search(string $query, array $options = []): array
    {
        $cacheKey = "search_" . md5($query . serialize($options));
        
        return $this->cacheService->remember($cacheKey, 300, function () use ($query, $options) {
            $results = [
                'itineraries' => $this->searchItineraries($query, $options),
                'sorties' => $this->searchSorties($query, $options),
                'users' => $this->searchUsers($query, $options),
                'meta' => [
                    'query' => $query,
                    'options' => $options,
                    'search_time' => microtime(true),
                ]
            ];
            
            $results['meta']['total_results'] = 
                count($results['itineraries']) + 
                count($results['sorties']) + 
                count($results['users']);
            
            $results['meta']['search_time'] = round(microtime(true) - $results['meta']['search_time'], 3);
            
            return $results;
        });
    }

    /**
     * Recherche d'itinéraires avec scoring de pertinence
     */
    public function searchItineraries(string $query, array $options = []): Collection
    {
        $builder = Itinerary::query()
            ->where('status', 'published')
            ->with(['user', 'featuredImage']);

        // Recherche full-text si MySQL
        if (DB::getDriverName() === 'mysql' && !empty($query)) {
            $builder = $this->addFullTextSearch($builder, $query, [
                'title' => 3.0,        // Titre : poids élevé
                'description' => 1.5,   // Description : poids moyen
                'departement' => 2.0,   // Département : poids élevé
                'pays' => 1.0          // Pays : poids standard
            ]);
        } else {
            // Fallback pour autres bases de données
            $builder = $this->addLikeSearch($builder, $query, [
                'title', 'description', 'departement', 'pays'
            ]);
        }

        // Filtres géographiques
        if (!empty($options['near'])) {
            $builder = $this->addGeographicFilter($builder, $options['near']);
        }

        // Filtres de difficulté
        if (!empty($options['difficulty'])) {
            $builder->whereIn('difficulty_level', (array) $options['difficulty']);
        }

        // Filtres de distance
        if (!empty($options['min_distance'])) {
            $builder->where('distance_km', '>=', $options['min_distance']);
        }
        if (!empty($options['max_distance'])) {
            $builder->where('distance_km', '<=', $options['max_distance']);
        }

        $limit = min($options['limit'] ?? 20, 50);
        
        return $builder->limit($limit)->get();
    }

    /**
     * Recherche de sorties avec filtres temporels
     */
    public function searchSorties(string $query, array $options = []): Collection
    {
        $builder = Sortie::query()
            ->where('status', 'published')
            ->with(['user', 'featuredImage']);

        // Recherche full-text si MySQL
        if (DB::getDriverName() === 'mysql' && !empty($query)) {
            $builder = $this->addFullTextSearch($builder, $query, [
                'title' => 3.0,
                'description' => 1.5,
                'lieu_depart' => 2.0,
            ]);
        } else {
            $builder = $this->addLikeSearch($builder, $query, [
                'title', 'description', 'lieu_depart'
            ]);
        }

        // Filtres temporels
        if (!empty($options['date_from'])) {
            $builder->where('date_sortie', '>=', $options['date_from']);
        }
        if (!empty($options['date_to'])) {
            $builder->where('date_sortie', '<=', $options['date_to']);
        }

        // Filtres de difficulté
        if (!empty($options['difficulty'])) {
            $builder->whereIn('difficulty_level', (array) $options['difficulty']);
        }

        // Par défaut, afficher les sorties à venir
        if (!isset($options['include_past'])) {
            $builder->where('date_sortie', '>=', now());
        }

        $limit = min($options['limit'] ?? 20, 50);
        
        return $builder->orderBy('date_sortie', 'asc')->limit($limit)->get();
    }

    /**
     * Recherche d'utilisateurs (données publiques uniquement)
     */
    public function searchUsers(string $query, array $options = []): Collection
    {
        $builder = User::query()
            ->whereNotNull('email_verified_at')
            ->whereNull('banned_at');

        if (!empty($query)) {
            if (DB::getDriverName() === 'mysql') {
                $builder = $this->addFullTextSearch($builder, $query, [
                    'name' => 1.0,
                ]);
            } else {
                $builder->where('name', 'like', "%{$query}%");
            }
        }

        $limit = min($options['limit'] ?? 10, 20);
        
        return $builder->orderBy('name')->limit($limit)->get();
    }

    /**
     * Recherche géographique avancée avec rayon
     */
    public function searchNearby(float $latitude, float $longitude, array $options = []): Collection
    {
        $radius = $options['radius_km'] ?? 25;
        $limit = min($options['limit'] ?? 20, 50);

        // Utiliser la formule Haversine pour calculer les distances
        $query = Itinerary::where('status', 'published')
            ->selectRaw("
                *, 
                (6371 * acos(cos(radians(?)) * cos(radians((min_latitude + max_latitude) / 2)) 
                * cos(radians((min_longitude + max_longitude) / 2) - radians(?)) 
                + sin(radians(?)) * sin(radians((min_latitude + max_latitude) / 2)))) AS distance_km
            ", [$latitude, $longitude, $latitude])
            ->having('distance_km', '<=', $radius)
            ->with(['user', 'featuredImage'])
            ->orderBy('distance_km');

        // Filtres supplémentaires
        if (!empty($options['difficulty'])) {
            $query->whereIn('difficulty_level', (array) $options['difficulty']);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Suggestions de recherche basées sur l'historique
     */
    public function getSuggestions(string $partial, int $limit = 10): array
    {
        $cacheKey = "search_suggestions_" . md5($partial);
        
        return $this->cacheService->remember($cacheKey, 3600, function () use ($partial, $limit) {
            $suggestions = [];

            // Suggestions depuis les titres d'itinéraires
            $itineraryTitles = DB::table('itineraries')
                ->where('status', 'published')
                ->where('title', 'like', "%{$partial}%")
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->pluck('title')
                ->unique()
                ->values();

            // Suggestions depuis les départements
            $departments = DB::table('itineraries')
                ->where('status', 'published')
                ->where('departement', 'like', "%{$partial}%")
                ->distinct()
                ->limit(5)
                ->pluck('departement')
                ->filter()
                ->unique()
                ->values();

            // Suggestions depuis les lieux de départ des sorties
            $locations = DB::table('sorties')
                ->where('status', 'published')
                ->where('lieu_depart', 'like', "%{$partial}%")
                ->distinct()
                ->limit(5)
                ->pluck('lieu_depart')
                ->filter()
                ->unique()
                ->values();

            return [
                'titles' => $itineraryTitles->toArray(),
                'departments' => $departments->toArray(),
                'locations' => $locations->toArray(),
                'generated_at' => now()->toISOString(),
            ];
        });
    }

    /**
     * Analytics de recherche
     */
    public function getSearchAnalytics(): array
    {
        return $this->cacheService->remember('search_analytics', 3600, function () {
            return [
                'popular_searches' => $this->getPopularSearches(),
                'trending_topics' => $this->getTrendingTopics(),
                'search_volume' => $this->getSearchVolume(),
                'no_results_queries' => $this->getNoResultsQueries(),
            ];
        });
    }

    /**
     * Ajouter recherche full-text MySQL avec scoring
     */
    protected function addFullTextSearch(Builder $builder, string $query, array $weights): Builder
    {
        $fields = array_keys($weights);
        $fieldsString = implode(', ', $fields);
        
        // Recherche full-text avec score de pertinence
        $builder->whereRaw("MATCH({$fieldsString}) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query])
               ->selectRaw("*, MATCH({$fieldsString}) AGAINST(? IN NATURAL LANGUAGE MODE) as relevance_score", [$query])
               ->orderByDesc('relevance_score');

        return $builder;
    }

    /**
     * Fallback recherche LIKE pour autres bases de données
     */
    protected function addLikeSearch(Builder $builder, string $query, array $fields): Builder
    {
        if (empty($query)) {
            return $builder;
        }

        $builder->where(function ($q) use ($query, $fields) {
            foreach ($fields as $field) {
                $q->orWhere($field, 'like', "%{$query}%");
            }
        });

        return $builder;
    }

    /**
     * Ajouter filtre géographique
     */
    protected function addGeographicFilter(Builder $builder, array $location): Builder
    {
        if (isset($location['latitude']) && isset($location['longitude'])) {
            $radius = $location['radius_km'] ?? 50;
            $lat = $location['latitude'];
            $lng = $location['longitude'];

            $builder->whereRaw("
                (6371 * acos(cos(radians(?)) * cos(radians((min_latitude + max_latitude) / 2)) 
                * cos(radians((min_longitude + max_longitude) / 2) - radians(?)) 
                + sin(radians(?)) * sin(radians((min_latitude + max_latitude) / 2)))) <= ?
            ", [$lat, $lng, $lat, $radius]);
        }

        return $builder;
    }

    /**
     * Recherches populaires (simulation - à implémenter avec tracking réel)
     */
    protected function getPopularSearches(): array
    {
        return [
            'vtt' => 450,
            'gravel' => 320,
            'montagne' => 280,
            'forêt' => 240,
            'débutant' => 190,
        ];
    }

    /**
     * Sujets tendance (simulation)
     */
    protected function getTrendingTopics(): array
    {
        return [
            'bikepacking' => '+25%',
            'gravel' => '+18%',
            'alpes' => '+12%',
            'vosges' => '+8%',
        ];
    }

    /**
     * Volume de recherche (simulation)
     */
    protected function getSearchVolume(): array
    {
        return [
            'today' => 1250,
            'week' => 8900,
            'month' => 35600,
        ];
    }

    /**
     * Requêtes sans résultat (simulation)
     */
    protected function getNoResultsQueries(): array
    {
        return [
            'velo electrique',
            'route fermée',
            'piste cyclable paris',
        ];
    }
}