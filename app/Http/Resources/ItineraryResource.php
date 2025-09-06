<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'personal_comment' => $this->personal_comment,
            
            // Données géographiques
            'location' => [
                'departement' => $this->departement,
                'pays' => $this->pays,
                'bounds' => [
                    'min_latitude' => (float) $this->min_latitude,
                    'max_latitude' => (float) $this->max_latitude,
                    'min_longitude' => (float) $this->min_longitude,
                    'max_longitude' => (float) $this->max_longitude,
                ],
            ],
            
            // Statistiques de l'itinéraire
            'stats' => [
                'distance_km' => (float) $this->distance_km,
                'elevation_gain_m' => $this->elevation_gain_m,
                'elevation_loss_m' => $this->elevation_loss_m,
                'difficulty_level' => $this->difficulty_level,
                'estimated_duration_minutes' => $this->estimated_duration_minutes,
            ],
            
            // Médias
            'media' => [
                'featured_image' => $this->whenLoaded('featuredImage', function () {
                    return $this->featuredImage ? [
                        'url' => asset($this->featuredImage->image_path),
                        'caption' => $this->featuredImage->caption,
                    ] : null;
                }),
                'images_count' => $this->whenLoaded('images', function () {
                    return $this->images->count();
                }),
                'images' => ImageResource::collection($this->whenLoaded('images')),
            ],
            
            // Métadonnées
            'meta' => [
                'status' => $this->status,
                'published_at' => $this->published_at?->toISOString(),
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'og_image' => $this->og_image ? asset($this->og_image) : null,
            ],
            
            // Données relationnelles
            'author' => new UserResource($this->whenLoaded('user')),
            'gpx' => [
                'file_path' => $this->gpx_file_path,
                'download_url' => $this->gpx_file_path ? asset($this->gpx_file_path) : null,
                'points_count' => $this->whenLoaded('gpxPoints', function () {
                    return $this->gpxPoints->count();
                }),
            ],
            
            // Timestamps
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            
            // Links (HATEOAS)
            'links' => [
                'self' => route('api.itineraries.show', $this->id),
                'public' => route('itineraries.show', $this->slug),
                'gpx_points' => route('api.itineraries.gpx-points', $this->id),
                'images' => route('api.itineraries.images', $this->id),
                'author' => $this->when($this->relationLoaded('user'), 
                    fn() => route('api.users.show', $this->user_id)
                ),
                'author_itineraries' => $this->when($this->relationLoaded('user'), 
                    fn() => route('api.users.itineraries', $this->user_id)
                ),
                'nearby' => route('api.search.nearby', [
                    'latitude' => ($this->min_latitude + $this->max_latitude) / 2,
                    'longitude' => ($this->min_longitude + $this->max_longitude) / 2,
                    'radius_km' => 10
                ]),
                'similar' => route('api.search', [
                    'type' => 'itineraries',
                    'difficulty' => $this->difficulty_level,
                    'min_distance' => max(0, $this->distance_km - 5),
                    'max_distance' => $this->distance_km + 5
                ]),
            ],
            
            // Actions disponibles selon l'authentification et les permissions
            'actions' => $this->getAvailableActions($request),
        ];
    }

    /**
     * Obtenir les actions disponibles selon l'utilisateur connecté
     */
    protected function getAvailableActions(Request $request): array
    {
        $actions = [];
        $user = $request->user();

        if (!$user) {
            // Utilisateur non connecté - actions limitées
            return [
                'view' => [
                    'method' => 'GET',
                    'href' => route('api.itineraries.show', $this->id),
                    'description' => 'View itinerary details'
                ],
                'download_gpx' => $this->when($this->gpx_file_path, [
                    'method' => 'GET',
                    'href' => asset($this->gpx_file_path),
                    'description' => 'Download GPX file'
                ])
            ];
        }

        // Actions pour utilisateurs connectés
        $actions['view'] = [
            'method' => 'GET',
            'href' => route('api.itineraries.show', $this->id),
            'description' => 'View itinerary details'
        ];

        // Actions selon la propriété
        if ($user->id === $this->user_id) {
            $actions['edit'] = [
                'method' => 'PUT',
                'href' => route('api.my.itineraries.update', $this->id),
                'description' => 'Update this itinerary'
            ];
            $actions['delete'] = [
                'method' => 'DELETE',
                'href' => route('api.my.itineraries.destroy', $this->id),
                'description' => 'Delete this itinerary'
            ];
        }

        // Actions pour favoris
        if ($user && method_exists($user, 'favoriteItineraries')) {
            $isFavorite = $user->favoriteItineraries()->where('itinerary_id', $this->id)->exists();
            
            if ($isFavorite) {
                $actions['remove_favorite'] = [
                    'method' => 'DELETE',
                    'href' => route('api.favorites.remove', $this->id),
                    'description' => 'Remove from favorites'
                ];
            } else {
                $actions['add_favorite'] = [
                    'method' => 'POST',
                    'href' => route('api.favorites.add', $this->id),
                    'description' => 'Add to favorites'
                ];
            }
        }

        // Actions admin
        if ($user && in_array($user->role ?? 'user', ['admin', 'super_admin'])) {
            $actions['admin_edit'] = [
                'method' => 'PUT',
                'href' => route('api.admin.itineraries.update-status', $this->id),
                'description' => 'Update status (admin)'
            ];
        }

        // Actions de téléchargement
        if ($this->gpx_file_path) {
            $actions['download_gpx'] = [
                'method' => 'GET',
                'href' => asset($this->gpx_file_path),
                'description' => 'Download GPX file'
            ];
        }

        return array_filter($actions);
    }

    /**
     * Get additional data that should be returned with the resource array.
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0',
                'generated_at' => now()->toISOString(),
                'api_documentation' => 'https://api.cerfaos.fr/docs',
            ],
        ];
    }
}