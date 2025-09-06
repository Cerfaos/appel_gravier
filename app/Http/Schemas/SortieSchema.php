<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     schema="Sortie",
 *     type="object",
 *     title="Sortie de groupe",
 *     description="Une sortie de groupe organisée",
 *     required={"id", "title", "date_sortie", "organizer_id", "created_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Identifiant unique de la sortie",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Titre de la sortie",
 *         maxLength=255,
 *         example="Gravel Matinal - Luberon"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description de la sortie",
 *         example="Une belle sortie matinale dans le Luberon avec petit déjeuner au sommet"
 *     ),
 *     @OA\Property(
 *         property="date_sortie",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la sortie",
 *         example="2024-02-15T08:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="duration_minutes",
 *         type="integer",
 *         nullable=true,
 *         description="Durée estimée en minutes",
 *         example=180
 *     ),
 *     @OA\Property(
 *         property="meeting_point",
 *         type="string",
 *         nullable=true,
 *         description="Point de rendez-vous",
 *         example="Parking de la Mairie de Bonnieux"
 *     ),
 *     @OA\Property(
 *         property="max_participants",
 *         type="integer",
 *         nullable=true,
 *         description="Nombre maximum de participants",
 *         example=12
 *     ),
 *     @OA\Property(
 *         property="difficulty_level",
 *         type="string",
 *         enum={"facile", "moyen", "difficile", "expert"},
 *         example="moyen"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"planned", "confirmed", "cancelled", "completed"},
 *         example="confirmed"
 *     ),
 *     @OA\Property(
 *         property="distance_km",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Distance approximative en kilomètres",
 *         example=45.5
 *     ),
 *     @OA\Property(
 *         property="elevation_gain_m",
 *         type="integer",
 *         nullable=true,
 *         description="Dénivelé positif en mètres",
 *         example=850
 *     ),
 *     @OA\Property(
 *         property="organizer",
 *         ref="#/components/schemas/User",
 *         description="Organisateur de la sortie"
 *     ),
 *     @OA\Property(
 *         property="itinerary",
 *         ref="#/components/schemas/Itinerary",
 *         nullable=true,
 *         description="Itinéraire associé si disponible"
 *     ),
 *     @OA\Property(
 *         property="participants",
 *         type="array",
 *         description="Liste des participants",
 *         @OA\Items(ref="#/components/schemas/User")
 *     ),
 *     @OA\Property(
 *         property="participants_count",
 *         type="integer",
 *         description="Nombre de participants inscrits",
 *         example=8
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de création"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière modification"
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         description="Liens HATEOAS",
 *         @OA\Property(property="self", type="string", format="uri"),
 *         @OA\Property(property="join", type="string", format="uri", nullable=true),
 *         @OA\Property(property="leave", type="string", format="uri", nullable=true),
 *         @OA\Property(property="participants", type="string", format="uri")
 *     )
 * )
 */
class SortieSchema
{
    // Cette classe sert uniquement à héberger les annotations OpenAPI
}