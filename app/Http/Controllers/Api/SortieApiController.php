<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SortieResource;
use App\Models\Sortie;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SortieApiController extends Controller
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
     * Lister les sorties avec pagination et filtres
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
            'status' => 'string|in:published,draft',
            'difficulty' => 'string|in:facile,moyen,difficile,expert',
            'date_from' => 'date',
            'date_to' => 'date',
            'sort' => 'string|in:created_at,updated_at,date_sortie,participants_count',
            'direction' => 'string|in:asc,desc',
            'search' => 'string|max:255',
            'include' => 'string',
        ]);

        $perPage = min($request->get('per_page', 15), 50);
        $query = Sortie::query();

        // Filtres de base
        $query->where('status', 'published');

        // Filtres optionnels
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        if ($request->filled('date_from')) {
            $query->where('date_sortie', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_sortie', '<=', $request->date_to);
        }

        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('lieu_depart', 'like', "%{$search}%");
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
        $sorties = $query->paginate($perPage);

        return SortieResource::collection($sorties)
            ->additional([
                'meta' => [
                    'filters_applied' => $request->only(['difficulty', 'date_from', 'date_to', 'search']),
                    'available_filters' => $this->getAvailableFilters(),
                ],
            ]);
    }

    /**
     * Afficher une sortie spécifique
     */
    public function show(Request $request, int $id): SortieResource
    {
        $request->validate([
            'include' => 'string',
        ]);

        $includes = $this->parseIncludes($request->get('include', 'user,featuredImage'));
        
        $sortie = Sortie::where('status', 'published')
            ->with($includes)
            ->findOrFail($id);

        return new SortieResource($sortie);
    }

    /**
     * Obtenir les statistiques des sorties
     */
    public function statistics()
    {
        $stats = [
            'total_published' => Sortie::where('status', 'published')->count(),
            'upcoming_sorties' => Sortie::where('status', 'published')
                ->where('date_sortie', '>', now())
                ->count(),
            'average_participants' => Sortie::where('status', 'published')->avg('participants_max'),
            'difficulty_distribution' => Sortie::where('status', 'published')
                ->groupBy('difficulty_level')
                ->selectRaw('difficulty_level, count(*) as count')
                ->pluck('count', 'difficulty_level'),
            'by_month' => Sortie::where('status', 'published')
                ->where('date_sortie', '>=', now()->subYear())
                ->groupByRaw('YEAR(date_sortie), MONTH(date_sortie)')
                ->selectRaw('YEAR(date_sortie) as year, MONTH(date_sortie) as month, count(*) as count')
                ->orderBy('year')
                ->orderBy('month')
                ->get(),
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

        $allowed = ['user', 'images', 'featuredImage', 'participants'];
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
            'date_range' => [
                'min' => Sortie::where('status', 'published')->min('date_sortie'),
                'max' => Sortie::where('status', 'published')->max('date_sortie'),
            ],
        ];
    }

    // Méthodes pour les utilisateurs authentifiés (similaires à ItineraryApiController)
    public function userSorties(Request $request)
    {
        $user = auth()->user();
        $sorties = $user->sorties()
            ->with(['featuredImage'])
            ->latest()
            ->paginate(15);

        return SortieResource::collection($sorties);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_sortie' => 'required|date|after:now',
            'lieu_depart' => 'required|string|max:255',
            'difficulty_level' => 'required|in:facile,moyen,difficile,expert',
            'participants_max' => 'integer|min:1|max:100',
        ]);

        $sortie = auth()->user()->sorties()->create($request->validated());

        return new SortieResource($sortie);
    }

    public function update(Request $request, int $id)
    {
        $sortie = auth()->user()->sorties()->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date_sortie' => 'sometimes|date',
            'lieu_depart' => 'sometimes|string|max:255',
            'difficulty_level' => 'sometimes|in:facile,moyen,difficile,expert',
            'participants_max' => 'sometimes|integer|min:1|max:100',
        ]);

        $sortie->update($request->validated());

        return new SortieResource($sortie);
    }

    public function destroy(int $id)
    {
        $sortie = auth()->user()->sorties()->findOrFail($id);
        $sortie->delete();

        return response()->json(['message' => 'Sortie deleted successfully']);
    }

    // Méthodes admin
    public function adminIndex(Request $request)
    {
        $query = Sortie::with(['user', 'featuredImage']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sorties = $query->latest()->paginate(20);

        return SortieResource::collection($sorties);
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:published,draft,archived',
        ]);

        $sortie = Sortie::findOrFail($id);
        $sortie->update(['status' => $request->status]);

        return new SortieResource($sortie);
    }
}