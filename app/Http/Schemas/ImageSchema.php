<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     schema="Image",
 *     type="object",
 *     title="Image",
 *     description="Image associée à un contenu",
 *     required={"id", "url"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Identifiant unique de l'image",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         format="uri",
 *         description="URL de l'image",
 *         example="https://example.com/images/photo.jpg"
 *     ),
 *     @OA\Property(
 *         property="caption",
 *         type="string",
 *         nullable=true,
 *         description="Légende de l'image",
 *         example="Vue panoramique du Mont Ventoux"
 *     ),
 *     @OA\Property(
 *         property="alt_text",
 *         type="string",
 *         nullable=true,
 *         description="Texte alternatif pour l'accessibilité",
 *         example="Cycliste sur chemin de gravel avec Mont Ventoux en arrière-plan"
 *     )
 * )
 */
class ImageSchema
{
    // Cette classe sert uniquement à héberger les annotations OpenAPI
}