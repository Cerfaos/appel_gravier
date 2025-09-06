<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Gérer une requête entrante pour vérifier les rôles utilisateur
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthenticated',
                    'message' => 'Authentication required'
                ], 401);
            }
            
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Vérifier si l'utilisateur a l'un des rôles requis
        if (!$this->userHasRole($user, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Forbidden',
                    'message' => 'Insufficient privileges for this action'
                ], 403);
            }
            
            abort(403, 'Access denied. Insufficient privileges.');
        }

        return $next($request);
    }

    /**
     * Vérifier si l'utilisateur a l'un des rôles spécifiés
     */
    private function userHasRole($user, array $roles): bool
    {
        if (empty($roles)) {
            return true;
        }

        $userRole = $user->role ?? 'user';
        
        // Gestion des rôles hiérarchiques
        $roleHierarchy = [
            'super_admin' => ['admin', 'moderator', 'user'],
            'admin' => ['moderator', 'user'],
            'moderator' => ['user'],
            'user' => []
        ];

        foreach ($roles as $requiredRole) {
            // Vérification directe du rôle
            if ($userRole === $requiredRole) {
                return true;
            }
            
            // Vérification hiérarchique
            if (isset($roleHierarchy[$userRole]) && 
                in_array($requiredRole, $roleHierarchy[$userRole])) {
                return true;
            }
        }

        return false;
    }
}