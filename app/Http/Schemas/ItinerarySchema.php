<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     schema="Itinerary",
 *     type="object",
 *     title="Itinéraire",
 *     description="Un itinéraire de gravel bike avec toutes ses informations",
 *     required={"id", "title", "slug", "status", "created_at", "updated_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Identifiant unique de l'itinéraire",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Titre de l'itinéraire",
 *         maxLength=255,
 *         example="Tour du Mont Ventoux - Gravel Epic"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Slug URL-friendly",
 *         maxLength=255,
 *         example="tour-mont-ventoux-gravel-epic"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description détaillée de l'itinéraire",
 *         example="Un parcours gravel exceptionnel autour du mythique Mont Ventoux..."
 *     ),
 *     @OA\Property(
 *         property="personal_comment",
 *         type="string",
 *         nullable=true,
 *         description="Commentaire personnel de l'auteur",
 *         example="Parcours très technique, à réserver aux gravélistes expérimentés"
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="object",
 *         description="Informations de localisation",
 *         @OA\Property(property="departement", type="string", nullable=true, example="Vaucluse"),
 *         @OA\Property(property="pays", type="string", nullable=true, example="France"),
 *         @OA\Property(
 *             property="bounds",
 *             type="object",
 *             description="Coordonnées de délimitation",
 *             @OA\Property(property="min_latitude", type="number", format="float", example=44.1234),
 *             @OA\Property(property="max_latitude", type="number", format="float", example=44.2567),
 *             @OA\Property(property="min_longitude", type="number", format="float", example=5.1234),
 *             @OA\Property(property="max_longitude", type="number", format="float", example=5.2567)
 *         )
 *     ),
 *     @OA\Property(
 *         property="stats",
 *         type="object",
 *         description="Statistiques de l'itinéraire",
 *         @OA\Property(property="distance_km", type="number", format="float", example=85.5),
 *         @OA\Property(property="elevation_gain_m", type="integer", nullable=true, example=1650),
 *         @OA\Property(property="elevation_loss_m", type="integer", nullable=true, example=1650),
 *         @OA\Property(
 *             property="difficulty_level",
 *             type="string",
 *             enum={"facile", "moyen", "difficile", "expert"},
 *             example="difficile"
 *         ),
 *         @OA\Property(property="estimated_duration_minutes", type="integer", nullable=true, example=360)
 *     ),
 *     @OA\Property(
 *         property="media",
 *         type="object",
 *         description="Médias associés",
 *         @OA\Property(
 *             property="featured_image",
 *             type="object",
 *             nullable=true,
 *             @OA\Property(property="url", type="string", format="uri"),
 *             @OA\Property(property="caption", type="string", nullable=true)
 *         ),
 *         @OA\Property(property="images_count", type="integer", example=12),
 *         @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/Image"))
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         description="Métadonnées",
 *         @OA\Property(
 *             property="status",
 *             type="string",
 *             enum={"draft", "published", "archived"},
 *             example="published"
 *         ),
 *         @OA\Property(property="published_at", type="string", format="date-time", nullable=true),
 *         @OA\Property(property="meta_title", type="string", nullable=true),
 *         @OA\Property(property="meta_description", type="string", nullable=true),
 *         @OA\Property(property="og_image", type="string", format="uri", nullable=true)
 *     ),
 *     @OA\Property(
 *         property="author",
 *         ref="#/components/schemas/User",
 *         description="Auteur de l'itinéraire"
 *     ),
 *     @OA\Property(
 *         property="gpx",
 *         type="object",
 *         description="Informations GPX",
 *         @OA\Property(property="file_path", type="string", nullable=true),
 *         @OA\Property(property="download_url", type="string", format="uri", nullable=true),
 *         @OA\Property(property="points_count", type="integer", example=1247)
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de création",
 *         example="2024-01-15T10:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière modification",
 *         example="2024-01-20T14:45:00Z"
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         description="Liens HATEOAS",
 *         @OA\Property(property="self", type="string", format="uri"),
 *         @OA\Property(property="public", type="string", format="uri"),
 *         @OA\Property(property="gpx_points", type="string", format="uri"),
 *         @OA\Property(property="images", type="string", format="uri"),
 *         @OA\Property(property="author", type="string", format="uri", nullable=true),
 *         @OA\Property(property="nearby", type="string", format="uri"),
 *         @OA\Property(property="similar", type="string", format="uri")
 *     ),
 *     @OA\Property(
 *         property="actions",
 *         type="object",
 *         description="Actions disponibles selon l'utilisateur",
 *         @OA\Property(
 *             property="view",
 *             type="object",
 *             @OA\Property(property="method", type="string", example="GET"),
 *             @OA\Property(property="href", type="string", format="uri"),
 *             @OA\Property(property="description", type="string")
 *         ),
 *         @OA\Property(
 *             property="edit",
 *             type="object",
 *             nullable=true,
 *             @OA\Property(property="method", type="string", example="PUT"),
 *             @OA\Property(property="href", type="string", format="uri"),
 *             @OA\Property(property="description", type="string")
 *         ),
 *         @OA\Property(
 *             property="delete",
 *             type="object",
 *             nullable=true,
 *             @OA\Property(property="method", type="string", example="DELETE"),
 *             @OA\Property(property="href", type="string", format="uri"),
 *             @OA\Property(property="description", type="string")
 *         ),
 *         @OA\Property(
 *             property="add_favorite",
 *             type="object",
 *             nullable=true,
 *             @OA\Property(property="method", type="string", example="POST"),
 *             @OA\Property(property="href", type="string", format="uri"),
 *             @OA\Property(property="description", type="string")
 *         ),
 *         @OA\Property(
 *             property="download_gpx",
 *             type="object",
 *             nullable=true,
 *             @OA\Property(property="method", type="string", example="GET"),
 *             @OA\Property(property="href", type="string", format="uri"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     )
 * )
 */
class ItinerarySchema
{
    // Cette classe sert uniquement à héberger les annotations OpenAPI
}