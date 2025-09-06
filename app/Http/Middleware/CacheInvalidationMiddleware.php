<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\Log;

class CacheInvalidationMiddleware
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Invalider le cache après les opérations de modification
        $this->handleCacheInvalidation($request, $response);

        return $response;
    }

    /**
     * Gérer l'invalidation du cache basée sur la route et l'action
     */
    private function handleCacheInvalidation(Request $request, $response): void
    {
        // Invalider uniquement sur les requêtes de modification réussies
        if (!$this->shouldInvalidateCache($request, $response)) {
            return;
        }

        $route = $request->route();
        if (!$route) {
            return;
        }

        $routeName = $route->getName();
        $method = $request->method();

        try {
            // Invalidation spécifique par route
            switch (true) {
                case str_contains($routeName, 'itinerary') && in_array($method, ['POST', 'PUT', 'DELETE']):
                    $this->handleItineraryInvalidation($request);
                    break;

                case str_contains($routeName, 'sortie') && in_array($method, ['POST', 'PUT', 'DELETE']):
                    $this->handleSortieInvalidation($request);
                    break;

                case str_contains($routeName, 'contact') && $method === 'POST':
                    $this->cacheService->invalidateTag(CacheService::CACHE_TAGS['stats']);
                    break;

                case str_contains($routeName, 'admin') && in_array($method, ['POST', 'PUT', 'DELETE']):
                    // Invalidation générale pour les actions admin
                    $this->cacheService->invalidateTag(CacheService::CACHE_TAGS['stats']);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Cache invalidation failed', [
                'route' => $routeName,
                'method' => $method,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Déterminer si le cache doit être invalidé
     */
    private function shouldInvalidateCache(Request $request, $response): bool
    {
        // Invalider uniquement pour les requêtes de modification réussies
        if (!in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            return false;
        }

        // Vérifier le statut de la réponse
        $statusCode = $response->getStatusCode();
        return $statusCode >= 200 && $statusCode < 400;
    }

    /**
     * Gérer l'invalidation du cache pour les itinéraires
     */
    private function handleItineraryInvalidation(Request $request): void
    {
        $itineraryId = $request->route('id') ?? $request->input('id');
        
        if ($itineraryId) {
            $this->cacheService->invalidateItineraryCache($itineraryId);
        } else {
            // Invalidation générale si pas d'ID spécifique
            $this->cacheService->invalidateTag(CacheService::CACHE_TAGS['itineraries']);
            $this->cacheService->invalidateTag(CacheService::CACHE_TAGS['stats']);
        }
    }

    /**
     * Gérer l'invalidation du cache pour les sorties
     */
    private function handleSortieInvalidation(Request $request): void
    {
        $sortieId = $request->route('id') ?? $request->input('id');
        
        if ($sortieId) {
            $this->cacheService->invalidateSortieCache($sortieId);
        } else {
            // Invalidation générale si pas d'ID spécifique
            $this->cacheService->invalidateTag(CacheService::CACHE_TAGS['sorties']);
            $this->cacheService->invalidateTag(CacheService::CACHE_TAGS['stats']);
        }
    }
}