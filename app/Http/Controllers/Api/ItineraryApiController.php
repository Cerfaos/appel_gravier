<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\ImageResource;
use App\Models\Itinerary;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItineraryApiController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
        
        // Rate limiting pour l'API
        $this->middleware('throttle:api')->except(['index', 'show']);
        $this->middleware('throttle:api-list')->only(['index']);
        $this->middleware('throttle:api-detail')->only(['show']);
    }

    /**
     * Lister les itinéraires avec pagination et filtres
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
            'status' => 'string|in:published,draft',
            'difficulty' => 'string|in:facile,moyen,difficile,expert',
            'departement' => 'string|max:100',
            'pays' => 'string|max:100',
            'min_distance' => 'numeric|min:0',
            'max_distance' => 'numeric|min:0',
            'sort' => 'string|in:created_at,updated_at,distance_km,title',
            'direction' => 'string|in:asc,desc',
            'search' => 'string|max:255',
            'include' => 'string', // user,images,featuredImage,gpxPoints
        ]);

        $perPage = min($request->get('per_page', 15), 50);
        $query = Itinerary::query();

        // Filtres de base
        $query->where('status', 'published');

        // Filtres optionnels
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        if ($request->filled('departement')) {
            $query->where('departement', 'like', '%' . $request->departement . '%');
        }

        if ($request->filled('pays')) {
            $query->where('pays', 'like', '%' . $request->pays . '%');
        }

        if ($request->filled('min_distance')) {
            $query->where('distance_km', '>=', $request->min_distance);
        }

        if ($request->filled('max_distance')) {
            $query->where('distance_km', '<=', $request->max_distance);
        }

        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('departement', 'like', "%{$search}%");
            });
        }

        // Relations à charger
        $includes = $this->parseIncludes($request->get('include', ''));
        if (!empty($includes)) {
            $query->with($includes);
        }

        // Tri
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $itineraries = $query->paginate($perPage);

        return ItineraryResource::collection($itineraries)
            ->additional([
                'meta' => [
                    'filters_applied' => $request->only(['difficulty', 'departement', 'pays', 'min_distance', 'max_distance', 'search']),
                    'available_filters' => $this->getAvailableFilters(),
                ],
            ]);
    }

    /**
     * Afficher un itinéraire spécifique
     */
    public function show(Request $request, int $id): ItineraryResource
    {
        $request->validate([
            'include' => 'string',
        ]);

        $includes = $this->parseIncludes($request->get('include', 'user,featuredImage'));
        
        $itinerary = Itinerary::where('status', 'published')
            ->with($includes)
            ->findOrFail($id);

        return new ItineraryResource($itinerary);
    }

    /**
     * Obtenir les points GPX d'un itinéraire
     */
    public function gpxPoints(int $id)
    {
        $itinerary = Itinerary::where('status', 'published')->findOrFail($id);
        
        // Utiliser le cache pour les données GPX
        $gpxData = $this->cacheService->getGpxData($id);
        
        if (!$gpxData) {
            return response()->json([
                'message' => 'Aucune donnée GPX disponible pour cet itinéraire'
            ], 404);
        }

        return response()->json([
            'data' => $gpxData,
            'meta' => [
                'itinerary_id' => $id,
                'points_count' => count($gpxData['points']),
                'generated_at' => now()->toISOString(),
            ],
        ]);
    }

    /**
     * Obtenir les images d'un itinéraire
     */
    public function images(int $id): AnonymousResourceCollection
    {
        $itinerary = Itinerary::where('status', 'published')
            ->with('images')
            ->findOrFail($id);

        return ImageResource::collection($itinerary->images);
    }

    /**
     * Recherche géographique avancée
     */
    public function searchNearby(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_km' => 'integer|min:1|max:100',
            'limit' => 'integer|min:1|max:50',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->get('radius_km', 25);
        $limit = $request->get('limit', 20);

        // Utiliser la formule Haversine pour calculer la distance
        $itineraries = Itinerary::where('status', 'published')
            ->selectRaw("
                *, 
                (6371 * acos(cos(radians(?)) * cos(radians((min_latitude + max_latitude) / 2)) 
                * cos(radians((min_longitude + max_longitude) / 2) - radians(?)) 
                + sin(radians(?)) * sin(radians((min_latitude + max_latitude) / 2)))) AS distance_km
            ", [$lat, $lng, $lat])
            ->having('distance_km', '<=', $radius)
            ->orderBy('distance_km')
            ->with(['user', 'featuredImage'])
            ->limit($limit)
            ->get();

        return ItineraryResource::collection($itineraries)
            ->additional([
                'meta' => [
                    'search_center' => ['latitude' => $lat, 'longitude' => $lng],
                    'radius_km' => $radius,
                    'results_count' => $itineraries->count(),
                ],
            ]);
    }

    /**
     * Statistiques des itinéraires
     */
    public function statistics()
    {
        $stats = [
            'total_published' => Itinerary::where('status', 'published')->count(),
            'total_distance_km' => Itinerary::where('status', 'published')->sum('distance_km'),
            'average_distance_km' => Itinerary::where('status', 'published')->avg('distance_km'),
            'difficulty_distribution' => Itinerary::where('status', 'published')
                ->groupBy('difficulty_level')
                ->selectRaw('difficulty_level, count(*) as count')
                ->pluck('count', 'difficulty_level'),
            'by_departement' => Itinerary::where('status', 'published')
                ->whereNotNull('departement')
                ->groupBy('departement')
                ->selectRaw('departement, count(*) as count')
                ->orderByDesc('count')
                ->limit(10)
                ->pluck('count', 'departement'),
        ];

        return response()->json([
            'data' => $stats,
            'generated_at' => now()->toISOString(),
        ]);
    }

    /**
     * Parser les relations à inclure
     */
    private function parseIncludes(string $include): array
    {
        if (empty($include)) {
            return [];
        }

        $allowed = ['user', 'images', 'featuredImage', 'gpxPoints'];
        $requested = array_map('trim', explode(',', $include));
        
        return array_intersect($requested, $allowed);
    }

    /**
     * Obtenir les filtres disponibles
     */
    private function getAvailableFilters(): array
    {
        return [
            'difficulty_levels' => ['facile', 'moyen', 'difficile', 'expert'],
            'departements' => Itinerary::where('status', 'published')
                ->whereNotNull('departement')
                ->distinct()
                ->pluck('departement')
                ->filter()
                ->values(),
            'countries' => Itinerary::where('status', 'published')
                ->whereNotNull('pays')
                ->distinct()
                ->pluck('pays')
                ->filter()
                ->values(),
            'distance_range' => [
                'min' => Itinerary::where('status', 'published')->min('distance_km'),
                'max' => Itinerary::where('status', 'published')->max('distance_km'),
            ],
        ];
    }
}