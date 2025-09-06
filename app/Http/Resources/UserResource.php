<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when(
                $this->shouldShowEmail($request), 
                $this->email
            ),
            
            // Informations publiques
            'profile' => [
                'photo' => $this->photo ? asset($this->photo) : null,
                'role' => $this->when(
                    $this->shouldShowRole($request),
                    $this->role
                ),
                'status' => $this->when(
                    $this->shouldShowStatus($request),
                    $this->status
                ),
            ],
            
            // Statistiques publiques (si disponibles)
            'stats' => $this->when($this->shouldShowStats($request), [
                'itineraries_count' => $this->whenLoaded('itineraries', function () {
                    return $this->itineraries->where('status', 'published')->count();
                }),
                'sorties_count' => $this->whenLoaded('sorties', function () {
                    return $this->sorties->where('status', 'published')->count();
                }),
                'total_distance_km' => $this->whenLoaded('itineraries', function () {
                    return $this->itineraries->where('status', 'published')->sum('distance_km');
                }),
                'member_since' => $this->created_at->toDateString(),
            ]),
            
            // Informations de contact (privées)
            'contact' => $this->when($this->shouldShowContactInfo($request), [
                'phone' => $this->phone,
                'address' => $this->address,
            ]),
            
            // Informations de sécurité (très privées)
            'security' => $this->when($this->shouldShowSecurityInfo($request), [
                'email_verified_at' => $this->email_verified_at?->toISOString(),
                'google2fa_enabled' => $this->google2fa_enabled,
                'google2fa_enabled_at' => $this->google2fa_enabled_at?->toISOString(),
                'failed_login_attempts' => $this->failed_login_attempts,
                'locked_until' => $this->locked_until?->toISOString(),
            ]),
            
            // Timestamps
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->when(
                $this->shouldShowTimestamps($request),
                $this->updated_at->toISOString()
            ),
            
            // Links
            'links' => [
                'self' => route('api.users.show', $this->id),
                'itineraries' => route('api.users.itineraries', $this->id),
                'sorties' => route('api.users.sorties', $this->id),
            ],
        ];
    }

    /**
     * Déterminer si l'email doit être affiché
     */
    private function shouldShowEmail(Request $request): bool
    {
        $currentUser = $request->user();
        
        // Admins peuvent voir tous les emails
        if ($currentUser?->role === 'admin') {
            return true;
        }
        
        // L'utilisateur peut voir son propre email
        if ($currentUser?->id === $this->id) {
            return true;
        }
        
        return false;
    }

    /**
     * Déterminer si le rôle doit être affiché
     */
    private function shouldShowRole(Request $request): bool
    {
        $currentUser = $request->user();
        
        // Admins peuvent voir tous les rôles
        if ($currentUser?->role === 'admin') {
            return true;
        }
        
        // L'utilisateur peut voir son propre rôle
        if ($currentUser?->id === $this->id) {
            return true;
        }
        
        // Afficher les rôles publics (admin, moderator)
        return in_array($this->role, ['admin', 'moderator']);
    }

    /**
     * Déterminer si le statut doit être affiché
     */
    private function shouldShowStatus(Request $request): bool
    {
        $currentUser = $request->user();
        
        // Admins peuvent voir tous les statuts
        if ($currentUser?->role === 'admin') {
            return true;
        }
        
        // L'utilisateur peut voir son propre statut
        return $currentUser?->id === $this->id;
    }

    /**
     * Déterminer si les statistiques doivent être affichées
     */
    private function shouldShowStats(Request $request): bool
    {
        // Les statistiques publiques sont visibles pour tous
        return true;
    }

    /**
     * Déterminer si les informations de contact doivent être affichées
     */
    private function shouldShowContactInfo(Request $request): bool
    {
        $currentUser = $request->user();
        
        // Seuls l'utilisateur lui-même et les admins peuvent voir ces infos
        return $currentUser && ($currentUser->id === $this->id || $currentUser->role === 'admin');
    }

    /**
     * Déterminer si les informations de sécurité doivent être affichées
     */
    private function shouldShowSecurityInfo(Request $request): bool
    {
        $currentUser = $request->user();
        
        // Seul l'utilisateur lui-même peut voir ses infos de sécurité
        return $currentUser && $currentUser->id === $this->id;
    }

    /**
     * Déterminer si les timestamps détaillés doivent être affichés
     */
    private function shouldShowTimestamps(Request $request): bool
    {
        $currentUser = $request->user();
        
        return $currentUser && ($currentUser->id === $this->id || $currentUser->role === 'admin');
    }
}