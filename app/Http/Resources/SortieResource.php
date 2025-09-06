<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SortieResource extends JsonResource
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
            
            // Informations de la sortie
            'sortie_info' => [
                'date' => $this->sortie_date?->toDateString(),
                'actual_duration_minutes' => $this->actual_duration_minutes,
                'weather_conditions' => $this->weather_conditions,
            ],
            
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
            
            // Statistiques
            'stats' => [
                'distance_km' => (float) $this->distance_km,
                'elevation_gain_m' => $this->elevation_gain_m,
                'elevation_loss_m' => $this->elevation_loss_m,
                'difficulty_level' => $this->difficulty_level,
                'estimated_duration_minutes' => $this->estimated_duration_minutes,
            ],
            
            // Comparaison estimé vs réel
            'performance' => [
                'duration_difference_minutes' => $this->actual_duration_minutes && $this->estimated_duration_minutes 
                    ? $this->actual_duration_minutes - $this->estimated_duration_minutes 
                    : null,
                'duration_efficiency' => $this->actual_duration_minutes && $this->estimated_duration_minutes
                    ? round(($this->estimated_duration_minutes / $this->actual_duration_minutes) * 100, 1)
                    : null,
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
                'self' => route('api.sorties.show', $this->id),
                'public' => route('sorties.show', $this->slug),
                'gpx_points' => route('api.sorties.gpx-points', $this->id),
                'images' => route('api.sorties.images', $this->id),
            ],
        ];
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
            ],
        ];
    }
}