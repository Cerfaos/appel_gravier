<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Cerfaos API",
 *     version="1.0.0",
 *     description="API complète pour la plateforme Cerfaos - Itinéraires de gravel bike",
 *     termsOfService="https://cerfaos.fr/terms",
 *     @OA\Contact(
 *         email="contact@cerfaos.fr",
 *         name="Équipe Cerfaos"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="https://api.cerfaos.fr",
 *     description="Production API Server"
 * )
 * 
 * @OA\Server(
 *     url="https://staging-api.cerfaos.fr",
 *     description="Staging API Server"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Development API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Laravel Sanctum Bearer Token Authentication"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     in="header",
 *     name="X-API-Key",
 *     description="API Key Authentication"
 * )
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="Authentification et gestion des sessions"
 * )
 * 
 * @OA\Tag(
 *     name="Itineraries",
 *     description="Gestion des itinéraires de gravel"
 * )
 * 
 * @OA\Tag(
 *     name="Sorties",
 *     description="Gestion des sorties de groupe"
 * )
 * 
 * @OA\Tag(
 *     name="Users",
 *     description="Gestion des utilisateurs"
 * )
 * 
 * @OA\Tag(
 *     name="Search",
 *     description="Recherche avancée et géolocalisée"
 * )
 * 
 * @OA\Tag(
 *     name="Favorites",
 *     description="Gestion des favoris utilisateur"
 * )
 * 
 * @OA\Tag(
 *     name="Admin",
 *     description="Administration et monitoring"
 * )
 */
abstract class Controller
{
    //
}
