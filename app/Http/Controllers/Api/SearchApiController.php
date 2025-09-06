<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\SortieResource;
use App\Http\Resources\UserResource;
use App\Services\AdvancedSearchService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="SearchResult",
 *     type="object",
 *     @OA\Property(property="itineraries", type="array", @OA\Items(ref="#/components/schemas/Itinerary")),
 *     @OA\Property(property="sorties", type="array", @OA\Items(ref="#/components/schemas/Sortie")),
 *     @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/User")),
 *     @OA\Property(property="total_results", type="integer", example=42),
 *     @OA\Property(property="search_time_ms", type="number", format="float", example=15.6)
 * )
 * 
 * @OA\Schema(
 *     schema="GeographicSearchResult",
 *     type="object",
 *     @OA\Property(property="results", type="array", @OA\Items(ref="#/components/schemas/Itinerary")),
 *     @OA\Property(property="center", type="object",
 *         @OA\Property(property="latitude", type="number", format="float"),
 *         @OA\Property(property="longitude", type="number", format="float")
 *     ),
 *     @OA\Property(property="radius_km", type="integer"),
 *     @OA\Property(property="total_found", type="integer")
 * )
 */
class SearchApiController extends Controller
{
    protected $searchService;

    public function __construct(AdvancedSearchService $searchService)
    {
        $this->searchService = $searchService;
        $this->middleware('throttle:search');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/search",
     *     summary="Recherche unifiée multi-modèles",
     *     description="Effectue une recherche dans tous les types de contenu (itinéraires, sorties, utilisateurs)",
     *     tags={"Search"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         description="Terme de recherche",
     *         @OA\Schema(type="string", minLength=2, maxLength=255, example="gravel pyrenees")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Type de contenu à rechercher",
     *         @OA\Schema(type="string", enum={"all", "itineraries", "sorties", "users"}, default="all")
     *     ),
     *     @OA\Parameter(
     *         name="difficulty[]",
     *         in="query",
     *         description="Niveaux de difficulté",
     *         @OA\Schema(type="array", @OA\Items(type="string", enum={"facile", "moyen", "difficile", "expert"}))
     *     ),
     *     @OA\Parameter(
     *         name="min_distance",
     *         in="query",
     *         description="Distance minimale en km",
     *         @OA\Schema(type="number", minimum=0)
     *     ),
     *     @OA\Parameter(
     *         name="max_distance",
     *         in="query",
     *         description="Distance maximale en km",
     *         @OA\Schema(type="number", minimum=0)
     *     ),
     *     @OA\Parameter(
     *         name="near_lat",
     *         in="query",
     *         description="Latitude pour recherche géographique",
     *         @OA\Schema(type="number", minimum=-90, maximum=90)
     *     ),
     *     @OA\Parameter(
     *         name="near_lng",
     *         in="query",
     *         description="Longitude pour recherche géographique",
     *         @OA\Schema(type="number", minimum=-180, maximum=180)
     *     ),
     *     @OA\Parameter(
     *         name="radius_km",
     *         in="query",
     *         description="Rayon de recherche en km",
     *         @OA\Schema(type="integer", minimum=1, maximum=100, default=25)
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Nombre maximum de résultats",
     *         @OA\Schema(type="integer", minimum=1, maximum=50, default=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Résultats de recherche",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/SearchResult"),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="query", type="string"),
     *                 @OA\Property(property="total_results", type="integer"),
     *                 @OA\Property(property="search_time_ms", type="number")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Erreur de validation"),
     *     @OA\Response(response=429, description="Trop de requêtes")
     * )
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255',
            'type' => 'sometimes|string|in:all,itineraries,sorties,users',
            'difficulty' => 'sometimes|array',
            'difficulty.*' => 'string|in:facile,moyen,difficile,expert',
            'min_distance' => 'sometimes|numeric|min:0',
            'max_distance' => 'sometimes|numeric|min:0',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date|after_or_equal:date_from',
            'include_past' => 'sometimes|boolean',
            'limit' => 'sometimes|integer|min:1|max:50',
            'near_lat' => 'sometimes|numeric|between:-90,90',
            'near_lng' => 'sometimes|numeric|between:-180,180',
            'radius_km' => 'sometimes|integer|min:1|max:100',
        ]);

        $query = $request->get('q');
        $type = $request->get('type', 'all');
        $options = $request->only([
            'difficulty', 'min_distance', 'max_distance',
            'date_from', 'date_to', 'include_past', 'limit'
        ]);

        // Recherche géographique
        if ($request->filled('near_lat') && $request->filled('near_lng')) {
            $options['near'] = [
                'latitude' => $request->near_lat,
                'longitude' => $request->near_lng,
                'radius_km' => $request->get('radius_km', 25),
            ];
        }

        // Recherche selon le type demandé
        if ($type === 'all') {
            $results = $this->searchService->search($query, $options);
            
            return response()->json([
                'data' => [
                    'itineraries' => ItineraryResource::collection($results['itineraries']),
                    'sorties' => SortieResource::collection($results['sorties']),
                    'users' => UserResource::collection($results['users']),
                ],
                'meta' => $results['meta'],
            ]);
        }

        // Recherche spécialisée
        switch ($type) {
            case 'itineraries':
                $results = $this->searchService->searchItineraries($query, $options);
                return response()->json([
                    'data' => ItineraryResource::collection($results),
                    'meta' => [
                        'query' => $query,
                        'type' => 'itineraries',
                        'count' => $results->count(),
                    ],
                ]);

            case 'sorties':
                $results = $this->searchService->searchSorties($query, $options);
                return response()->json([
                    'data' => SortieResource::collection($results),
                    'meta' => [
                        'query' => $query,
                        'type' => 'sorties',
                        'count' => $results->count(),
                    ],
                ]);

            case 'users':
                $results = $this->searchService->searchUsers($query, $options);
                return response()->json([
                    'data' => UserResource::collection($results),
                    'meta' => [
                        'query' => $query,
                        'type' => 'users',
                        'count' => $results->count(),
                    ],
                ]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/search/nearby",
     *     summary="Recherche géographique de proximité",
     *     description="Recherche des itinéraires dans un rayon géographique donné",
     *     tags={"Search"},
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         required=true,
     *         description="Latitude du point central",
     *         @OA\Schema(type="number", minimum=-90, maximum=90, example=45.7640)
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         required=true,
     *         description="Longitude du point central",
     *         @OA\Schema(type="number", minimum=-180, maximum=180, example=4.8357)
     *     ),
     *     @OA\Parameter(
     *         name="radius_km",
     *         in="query",
     *         description="Rayon de recherche en kilomètres",
     *         @OA\Schema(type="integer", minimum=1, maximum=100, default=25)
     *     ),
     *     @OA\Parameter(
     *         name="difficulty[]",
     *         in="query",
     *         description="Niveaux de difficulté à inclure",
     *         @OA\Schema(type="array", @OA\Items(type="string", enum={"facile", "moyen", "difficile", "expert"}))
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Nombre maximum de résultats",
     *         @OA\Schema(type="integer", minimum=1, maximum=50, default=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itinéraires trouvés à proximité",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Itinerary")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="search_center", type="object",
     *                     @OA\Property(property="latitude", type="number"),
     *                     @OA\Property(property="longitude", type="number")
     *                 ),
     *                 @OA\Property(property="radius_km", type="integer"),
     *                 @OA\Property(property="count", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Erreur de validation"),
     *     @OA\Response(response=429, description="Trop de requêtes")
     * )
     */
    public function searchNearby(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_km' => 'sometimes|integer|min:1|max:100',
            'difficulty' => 'sometimes|array',
            'difficulty.*' => 'string|in:facile,moyen,difficile,expert',
            'limit' => 'sometimes|integer|min:1|max:50',
        ]);

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $options = $request->only(['radius_km', 'difficulty', 'limit']);

        $results = $this->searchService->searchNearby($latitude, $longitude, $options);

        return response()->json([
            'data' => ItineraryResource::collection($results),
            'meta' => [
                'search_center' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
                'radius_km' => $options['radius_km'] ?? 25,
                'count' => $results->count(),
            ],
        ]);
    }

    /**
     * Suggestions de recherche
     */
    public function suggestions(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1|max:100',
            'limit' => 'sometimes|integer|min:1|max:20',
        ]);

        $partial = $request->get('q');
        $limit = $request->get('limit', 10);

        $suggestions = $this->searchService->getSuggestions($partial, $limit);

        return response()->json([
            'data' => $suggestions,
            'meta' => [
                'query' => $partial,
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Analytics de recherche (admin only)
     */
    public function analytics()
    {
        $analytics = $this->searchService->getSearchAnalytics();

        return response()->json([
            'data' => $analytics,
            'meta' => [
                'generated_at' => now()->toISOString(),
            ],
        ]);
    }

    /**
     * Recherche avancée avec filtres multiples
     */
    public function advanced(Request $request)
    {
        $request->validate([
            'keywords' => 'sometimes|string|max:255',
            'title_only' => 'sometimes|boolean',
            'user_id' => 'sometimes|integer|exists:users,id',
            'difficulty' => 'sometimes|array',
            'difficulty.*' => 'string|in:facile,moyen,difficile,expert',
            'distance_min' => 'sometimes|numeric|min:0',
            'distance_max' => 'sometimes|numeric|min:0',
            'elevation_min' => 'sometimes|integer|min:0',
            'elevation_max' => 'sometimes|integer|min:0',
            'departement' => 'sometimes|string|max:100',
            'pays' => 'sometimes|string|max:100',
            'created_after' => 'sometimes|date',
            'created_before' => 'sometimes|date|after_or_equal:created_after',
            'has_gpx' => 'sometimes|boolean',
            'has_images' => 'sometimes|boolean',
            'sort_by' => 'sometimes|string|in:relevance,created_at,distance,difficulty,title',
            'sort_direction' => 'sometimes|string|in:asc,desc',
            'limit' => 'sometimes|integer|min:1|max:100',
        ]);

        $query = \App\Models\Itinerary::query()
            ->where('status', 'published')
            ->with(['user', 'featuredImage']);

        // Recherche par mots-clés
        if ($request->filled('keywords')) {
            $keywords = $request->keywords;
            
            if ($request->get('title_only')) {
                $query->where('title', 'like', "%{$keywords}%");
            } else {
                $query->where(function ($q) use ($keywords) {
                    $q->where('title', 'like', "%{$keywords}%")
                      ->orWhere('description', 'like', "%{$keywords}%")
                      ->orWhere('departement', 'like', "%{$keywords}%");
                });
            }
        }

        // Filtres spécifiques
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('difficulty')) {
            $query->whereIn('difficulty_level', $request->difficulty);
        }

        if ($request->filled('distance_min')) {
            $query->where('distance_km', '>=', $request->distance_min);
        }

        if ($request->filled('distance_max')) {
            $query->where('distance_km', '<=', $request->distance_max);
        }

        if ($request->filled('elevation_min')) {
            $query->where('elevation_gain_m', '>=', $request->elevation_min);
        }

        if ($request->filled('elevation_max')) {
            $query->where('elevation_gain_m', '<=', $request->elevation_max);
        }

        if ($request->filled('departement')) {
            $query->where('departement', 'like', '%' . $request->departement . '%');
        }

        if ($request->filled('pays')) {
            $query->where('pays', 'like', '%' . $request->pays . '%');
        }

        if ($request->filled('created_after')) {
            $query->where('created_at', '>=', $request->created_after);
        }

        if ($request->filled('created_before')) {
            $query->where('created_at', '<=', $request->created_before);
        }

        if ($request->get('has_gpx')) {
            $query->whereNotNull('gpx_file_path');
        }

        if ($request->get('has_images')) {
            $query->whereHas('images');
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        switch ($sortBy) {
            case 'relevance':
                // Si pas de recherche textuelle, tri par date
                if (!$request->filled('keywords')) {
                    $query->orderBy('created_at', 'desc');
                }
                // Sinon le tri par pertinence est déjà appliqué
                break;
            case 'distance':
                $query->orderBy('distance_km', $sortDirection);
                break;
            case 'difficulty':
                $query->orderByRaw("FIELD(difficulty_level, 'facile', 'moyen', 'difficile', 'expert') " . $sortDirection);
                break;
            case 'title':
                $query->orderBy('title', $sortDirection);
                break;
            default:
                $query->orderBy($sortBy, $sortDirection);
        }

        $limit = min($request->get('limit', 20), 100);
        $results = $query->limit($limit)->get();

        return response()->json([
            'data' => ItineraryResource::collection($results),
            'meta' => [
                'filters_applied' => $request->except(['sort_by', 'sort_direction', 'limit']),
                'sort' => [
                    'by' => $sortBy,
                    'direction' => $sortDirection,
                ],
                'count' => $results->count(),
                'limit' => $limit,
            ],
        ]);
    }
}