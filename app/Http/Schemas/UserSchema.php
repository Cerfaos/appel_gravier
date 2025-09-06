<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Utilisateur",
 *     description="Utilisateur de la plateforme Cerfaos",
 *     required={"id", "name", "email", "created_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Identifiant unique de l'utilisateur",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nom complet de l'utilisateur",
 *         maxLength=255,
 *         example="Jean Dupont"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Adresse email",
 *         example="jean.dupont@example.com"
 *     ),
 *     @OA\Property(
 *         property="bio",
 *         type="string",
 *         nullable=true,
 *         description="Biographie de l'utilisateur",
 *         example="Passionné de gravel depuis 10 ans, j'explore les chemins de France"
 *     ),
 *     @OA\Property(
 *         property="avatar_url",
 *         type="string",
 *         format="uri",
 *         nullable=true,
 *         description="URL de l'avatar",
 *         example="https://example.com/avatars/jean.jpg"
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="city", type="string", example="Lyon"),
 *         @OA\Property(property="country", type="string", example="France")
 *     ),
 *     @OA\Property(
 *         property="stats",
 *         type="object",
 *         description="Statistiques de l'utilisateur",
 *         @OA\Property(property="itineraries_count", type="integer", example=24),
 *         @OA\Property(property="sorties_count", type="integer", example=8),
 *         @OA\Property(property="total_distance_km", type="number", format="float", example=1248.5)
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         enum={"user", "moderator", "admin", "super_admin"},
 *         default="user",
 *         example="user"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Date de vérification de l'email"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de création du compte"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière modification"
 *     )
 * )
 */
class UserSchema
{
    // Cette classe sert uniquement à héberger les annotations OpenAPI
}