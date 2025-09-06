<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Http\Request;

trait HasHateoasActions
{
    /**
     * Générer les liens de navigation HATEOAS standard
     */
    protected function getNavigationLinks(string $resourceType, $id, array $additionalLinks = []): array
    {
        $links = [
            'self' => route("api.{$resourceType}.show", $id),
            'collection' => route("api.{$resourceType}.index"),
        ];

        return array_merge($links, $additionalLinks);
    }

    /**
     * Générer les actions CRUD de base
     */
    protected function getCrudActions(Request $request, string $resourceType, $id, $ownerId = null): array
    {
        $actions = [];
        $user = $request->user();

        // Action de lecture (toujours disponible)
        $actions['view'] = [
            'method' => 'GET',
            'href' => route("api.{$resourceType}.show", $id),
            'description' => "View {$resourceType} details",
            'requires_auth' => false,
        ];

        if (!$user) {
            return $actions;
        }

        // Actions de propriétaire
        if ($ownerId && $user->id === $ownerId) {
            $actions['edit'] = [
                'method' => 'PUT',
                'href' => route("api.my.{$resourceType}.update", $id),
                'description' => "Update this {$resourceType}",
                'requires_auth' => true,
            ];

            $actions['delete'] = [
                'method' => 'DELETE',
                'href' => route("api.my.{$resourceType}.destroy", $id),
                'description' => "Delete this {$resourceType}",
                'requires_auth' => true,
            ];
        }

        // Actions administrateur
        if ($this->isAdmin($user)) {
            $actions['admin_edit'] = [
                'method' => 'PUT',
                'href' => route("api.admin.{$resourceType}.update-status", $id),
                'description' => "Update status (admin)",
                'requires_auth' => true,
                'requires_role' => 'admin',
            ];
        }

        return $actions;
    }

    /**
     * Générer les actions de favoris
     */
    protected function getFavoriteActions(Request $request, $resourceType, $id): array
    {
        $user = $request->user();
        if (!$user) {
            return [];
        }

        $relationMethod = "favorite" . ucfirst($resourceType);
        if (!method_exists($user, $relationMethod)) {
            return [];
        }

        $isFavorite = $user->{$relationMethod}()->where("{$resourceType}_id", $id)->exists();

        if ($isFavorite) {
            return [
                'remove_favorite' => [
                    'method' => 'DELETE',
                    'href' => route('api.favorites.remove', $id),
                    'description' => 'Remove from favorites',
                    'requires_auth' => true,
                ]
            ];
        } else {
            return [
                'add_favorite' => [
                    'method' => 'POST',
                    'href' => route('api.favorites.add', $id),
                    'description' => 'Add to favorites',
                    'requires_auth' => true,
                ]
            ];
        }
    }

    /**
     * Générer des actions de partage social
     */
    protected function getSocialActions($title, $url): array
    {
        $encodedTitle = urlencode($title);
        $encodedUrl = urlencode($url);

        return [
            'share_facebook' => [
                'method' => 'GET',
                'href' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
                'description' => 'Share on Facebook',
                'external' => true,
            ],
            'share_twitter' => [
                'method' => 'GET',
                'href' => "https://twitter.com/intent/tweet?text={$encodedTitle}&url={$encodedUrl}",
                'description' => 'Share on Twitter',
                'external' => true,
            ],
            'share_email' => [
                'method' => 'GET',
                'href' => "mailto:?subject={$encodedTitle}&body=Check out this itinerary: {$encodedUrl}",
                'description' => 'Share via email',
                'external' => true,
            ],
        ];
    }

    /**
     * Générer les métadonnées enrichies
     */
    protected function getEnrichedMeta(): array
    {
        return [
            'version' => config('app.api_version', '1.0'),
            'generated_at' => now()->toISOString(),
            'api_documentation' => config('app.api_docs_url', 'https://docs.api.cerfaos.fr'),
            'rate_limits' => [
                'remaining' => request()->header('X-RateLimit-Remaining'),
                'limit' => request()->header('X-RateLimit-Limit'),
                'reset' => request()->header('X-RateLimit-Reset'),
            ],
        ];
    }

    /**
     * Générer des suggestions de contenu similaire
     */
    protected function getSimilarContentLinks(string $resourceType, array $filters): array
    {
        return [
            'similar' => [
                'href' => route('api.search', array_merge(['type' => $resourceType], $filters)),
                'description' => "Find similar {$resourceType}",
                'filters_applied' => $filters,
            ],
        ];
    }

    /**
     * Vérifier si l'utilisateur est administrateur
     */
    protected function isAdmin($user): bool
    {
        return $user && in_array($user->role ?? 'user', ['admin', 'super_admin']);
    }

    /**
     * Générer des breadcrumbs pour l'API
     */
    protected function getBreadcrumbs(string $resourceType, $id = null): array
    {
        $breadcrumbs = [
            [
                'name' => 'API Root',
                'href' => route('api.root', [], false),
            ],
            [
                'name' => ucfirst($resourceType),
                'href' => route("api.{$resourceType}.index", [], false),
            ],
        ];

        if ($id) {
            $breadcrumbs[] = [
                'name' => "#{$id}",
                'href' => route("api.{$resourceType}.show", $id, false),
                'current' => true,
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Générer les actions de navigation dans une collection paginée
     */
    protected function getPaginationActions($paginator): array
    {
        $actions = [];

        if ($paginator->hasPages()) {
            $actions['first'] = [
                'href' => $paginator->url(1),
                'description' => 'First page',
            ];

            if ($paginator->previousPageUrl()) {
                $actions['previous'] = [
                    'href' => $paginator->previousPageUrl(),
                    'description' => 'Previous page',
                ];
            }

            if ($paginator->nextPageUrl()) {
                $actions['next'] = [
                    'href' => $paginator->nextPageUrl(),
                    'description' => 'Next page',
                ];
            }

            $actions['last'] = [
                'href' => $paginator->url($paginator->lastPage()),
                'description' => 'Last page',
            ];
        }

        return $actions;
    }

    /**
     * Filtrer les actions selon les permissions
     */
    protected function filterActionsByPermissions(array $actions, Request $request): array
    {
        $user = $request->user();

        return array_filter($actions, function ($action) use ($user) {
            // Si l'action nécessite une authentification
            if (isset($action['requires_auth']) && $action['requires_auth'] && !$user) {
                return false;
            }

            // Si l'action nécessite un rôle spécifique
            if (isset($action['requires_role']) && !$this->hasRole($user, $action['requires_role'])) {
                return false;
            }

            return true;
        });
    }

    /**
     * Vérifier si l'utilisateur a le rôle requis
     */
    protected function hasRole($user, string $role): bool
    {
        if (!$user) {
            return false;
        }

        $userRole = $user->role ?? 'user';
        
        // Hiérarchie des rôles
        $hierarchy = [
            'super_admin' => ['admin', 'moderator', 'user'],
            'admin' => ['moderator', 'user'],
            'moderator' => ['user'],
            'user' => [],
        ];

        return $userRole === $role || 
               (isset($hierarchy[$userRole]) && in_array($role, $hierarchy[$userRole]));
    }
}