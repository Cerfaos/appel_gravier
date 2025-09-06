<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\HasHateoasActions;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItineraryCollection extends ResourceCollection
{
    use HasHateoasActions;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => $this->getCollectionLinks($request),
            'meta' => $this->getCollectionMeta($request),
            'actions' => $this->getCollectionActions($request),
            'filters' => $this->getAvailableFilters($request),
        ];
    }

    /**
     * Obtenir les liens de navigation pour la collection
     */
    protected function getCollectionLinks(Request $request): array
    {
        $links = [
            'self' => $request->url(),
            'first' => $this->url(1),
            'last' => $this->url($this->lastPage()),
        ];

        if ($this->previousPageUrl()) {
            $links['prev'] = $this->previousPageUrl();
        }

        if ($this->nextPageUrl()) {
            $links['next'] = $this->nextPageUrl();
        }

        // Liens vers d'autres ressources liées
        $links['search'] = route('api.search');
        $links['nearby'] = route('api.search.nearby');
        $links['statistics'] = route('api.itineraries.statistics');

        return $links;
    }

    /**
     * Obtenir les métadonnées enrichies de la collection
     */
    protected function getCollectionMeta(Request $request): array
    {
        $baseMeta = [
            'current_page' => $this->currentPage(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];

        $enrichedMeta = $this->getEnrichedMeta();

        return array_merge($baseMeta, $enrichedMeta, [
            'filters_applied' => $request->only([
                'difficulty', 'departement', 'pays', 
                'min_distance', 'max_distance', 'search'
            ]),
            'sort' => [
                'field' => $request->get('sort', 'created_at'),
                'direction' => $request->get('direction', 'desc'),
            ],
            'include' => $request->get('include', ''),
            'collection_stats' => $this->getCollectionStats(),
        ]);
    }

    /**
     * Actions disponibles sur la collection
     */
    protected function getCollectionActions(Request $request): array
    {
        $actions = [
            'search' => [
                'method' => 'GET',
                'href' => route('api.search'),
                'description' => 'Search across all content',
                'parameters' => [
                    'q' => 'Search query',
                    'type' => 'Content type (itineraries, sorties, users, all)',
                    'difficulty' => 'Difficulty levels array',
                    'min_distance' => 'Minimum distance in km',
                    'max_distance' => 'Maximum distance in km',
                ],
            ],
            'search_nearby' => [
                'method' => 'GET',
                'href' => route('api.search.nearby'),
                'description' => 'Search by geographic location',
                'parameters' => [
                    'latitude' => 'Latitude coordinate',
                    'longitude' => 'Longitude coordinate',
                    'radius_km' => 'Search radius in kilometers',
                ],
            ],
        ];

        // Actions pour utilisateurs authentifiés
        $user = $request->user();
        if ($user) {
            $actions['create'] = [
                'method' => 'POST',
                'href' => route('api.my.itineraries.store'),
                'description' => 'Create a new itinerary',
                'requires_auth' => true,
            ];

            $actions['my_itineraries'] = [
                'method' => 'GET',
                'href' => route('api.my.itineraries'),
                'description' => 'Get my itineraries',
                'requires_auth' => true,
            ];

            $actions['favorites'] = [
                'method' => 'GET',
                'href' => route('api.favorites.index'),
                'description' => 'Get my favorite itineraries',
                'requires_auth' => true,
            ];
        }

        return $this->filterActionsByPermissions($actions, $request);
    }

    /**
     * Filtres disponibles pour la collection
     */
    protected function getAvailableFilters(Request $request): array
    {
        return [
            'difficulty_levels' => [
                'type' => 'array',
                'options' => ['facile', 'moyen', 'difficile', 'expert'],
                'description' => 'Filter by difficulty level',
            ],
            'distance' => [
                'type' => 'range',
                'min' => 0,
                'max' => 500,
                'unit' => 'km',
                'description' => 'Filter by distance range',
            ],
            'location' => [
                'type' => 'text',
                'fields' => ['departement', 'pays'],
                'description' => 'Filter by location (department or country)',
            ],
            'search' => [
                'type' => 'text',
                'fields' => ['title', 'description', 'departement', 'pays'],
                'description' => 'Full-text search across multiple fields',
            ],
            'date_range' => [
                'type' => 'date_range',
                'description' => 'Filter by creation date range',
            ],
            'has_gpx' => [
                'type' => 'boolean',
                'description' => 'Filter items that have GPX files',
            ],
            'has_images' => [
                'type' => 'boolean',
                'description' => 'Filter items that have images',
            ],
        ];
    }

    /**
     * Statistiques de la collection courante
     */
    protected function getCollectionStats(): array
    {
        if ($this->collection->isEmpty()) {
            return [];
        }

        return [
            'difficulty_distribution' => $this->collection->groupBy('difficulty_level')
                ->map(fn($group) => $group->count())
                ->toArray(),
            'average_distance' => round($this->collection->avg('distance_km'), 2),
            'total_distance' => round($this->collection->sum('distance_km'), 2),
            'distance_range' => [
                'min' => $this->collection->min('distance_km'),
                'max' => $this->collection->max('distance_km'),
            ],
            'departments_count' => $this->collection->pluck('departement')
                ->filter()
                ->unique()
                ->count(),
            'countries_count' => $this->collection->pluck('pays')
                ->filter()
                ->unique()
                ->count(),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     */
    public function with(Request $request): array
    {
        return [
            'jsonapi' => [
                'version' => '1.0',
                'meta' => [
                    'copyright' => 'Cerfaos ' . date('Y'),
                    'authors' => ['Cerfaos Development Team'],
                ],
            ],
            'included' => $this->getIncludedResources($request),
        ];
    }

    /**
     * Ressources incluses selon les paramètres de la requête
     */
    protected function getIncludedResources(Request $request): array
    {
        $included = [];
        $includes = explode(',', $request->get('include', ''));

        // Inclure les auteurs si demandé
        if (in_array('user', $includes)) {
            $users = $this->collection->pluck('user')->filter()->unique('id');
            $included['users'] = UserResource::collection($users);
        }

        // Inclure les images featured si demandées
        if (in_array('featuredImage', $includes)) {
            $images = $this->collection->pluck('featuredImage')->filter()->unique('id');
            $included['featured_images'] = ImageResource::collection($images);
        }

        return $included;
    }
}