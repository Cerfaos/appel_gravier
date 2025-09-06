<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\SortieResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserApiController extends Controller
{
    public function __construct()
    {
        // Rate limiting pour l'API
        $this->middleware('throttle:api')->except(['index', 'show']);
        $this->middleware('throttle:api-list')->only(['index']);
        $this->middleware('throttle:api-detail')->only(['show']);
    }

    /**
     * Liste publique des utilisateurs (données limitées)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
            'search' => 'string|max:255',
        ]);

        $perPage = min($request->get('per_page', 15), 50);
        $query = User::query();

        // Seulement les utilisateurs actifs et vérifiés
        $query->whereNotNull('email_verified_at')
              ->whereNull('banned_at');

        // Recherche textuelle (nom uniquement pour la vie privée)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $users = $query->orderBy('name')
                      ->paginate($perPage);

        return UserResource::collection($users)
            ->additional([
                'meta' => [
                    'search_applied' => $request->get('search'),
                ],
            ]);
    }

    /**
     * Profil public d'un utilisateur
     */
    public function show(int $id): UserResource
    {
        $user = User::whereNotNull('email_verified_at')
                   ->whereNull('banned_at')
                   ->findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Itinéraires publics d'un utilisateur
     */
    public function itineraries(Request $request, int $id): AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:20',
        ]);

        $user = User::findOrFail($id);
        $perPage = min($request->get('per_page', 10), 20);

        $itineraries = $user->itineraries()
            ->where('status', 'published')
            ->with(['featuredImage'])
            ->latest()
            ->paginate($perPage);

        return ItineraryResource::collection($itineraries);
    }

    /**
     * Sorties publiques d'un utilisateur
     */
    public function sorties(Request $request, int $id): AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:20',
        ]);

        $user = User::findOrFail($id);
        $perPage = min($request->get('per_page', 10), 20);

        $sorties = $user->sorties()
            ->where('status', 'published')
            ->with(['featuredImage'])
            ->latest()
            ->paginate($perPage);

        return SortieResource::collection($sorties);
    }

    // --- Méthodes pour utilisateurs authentifiés ---

    /**
     * Profil de l'utilisateur connecté
     */
    public function profile(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Mettre à jour le profil
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'bio' => 'sometimes|string|max:1000',
            'ville' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
            'date_naissance' => 'sometimes|date|before:today',
        ]);

        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Upload d'avatar
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
                unlink(public_path($user->avatar_path));
            }

            // Sauvegarder le nouvel avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar_path' => 'storage/' . $avatarPath]);
        }

        return new UserResource($user);
    }

    /**
     * Gestion des favoris
     */
    public function favorites(): AnonymousResourceCollection
    {
        $user = auth()->user();
        $favorites = $user->favoriteItineraries()
            ->with(['featuredImage', 'user'])
            ->latest('pivot.created_at')
            ->paginate(15);

        return ItineraryResource::collection($favorites);
    }

    public function addToFavorites(int $id)
    {
        $user = auth()->user();
        
        if (!$user->favoriteItineraries()->where('itinerary_id', $id)->exists()) {
            $user->favoriteItineraries()->attach($id);
        }

        return response()->json(['message' => 'Added to favorites']);
    }

    public function removeFromFavorites(int $id)
    {
        $user = auth()->user();
        $user->favoriteItineraries()->detach($id);

        return response()->json(['message' => 'Removed from favorites']);
    }

    // --- Méthodes admin ---

    /**
     * Liste complète pour admin
     */
    public function adminIndex(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'role' => 'string|in:user,admin',
            'status' => 'string|in:active,banned,unverified',
            'search' => 'string|max:255',
        ]);

        $perPage = min($request->get('per_page', 20), 100);
        $query = User::query();

        // Filtres admin
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'banned':
                    $query->whereNotNull('banned_at');
                    break;
                case 'unverified':
                    $query->whereNull('email_verified_at');
                    break;
                case 'active':
                    $query->whereNotNull('email_verified_at')
                          ->whereNull('banned_at');
                    break;
            }
        }

        // Recherche étendue pour admin
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate($perPage);

        return UserResource::collection($users);
    }

    /**
     * Détails complets pour admin
     */
    public function adminShow(int $id): UserResource
    {
        $user = User::with(['itineraries', 'sorties'])->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Mettre à jour le statut d'un utilisateur
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:active,banned',
            'reason' => 'sometimes|string|max:255',
        ]);

        $user = User::findOrFail($id);

        if ($request->status === 'banned') {
            $user->update([
                'banned_at' => now(),
                'ban_reason' => $request->get('reason', 'Administrative action'),
            ]);
        } else {
            $user->update([
                'banned_at' => null,
                'ban_reason' => null,
            ]);
        }

        return new UserResource($user);
    }

    /**
     * Débloquer un utilisateur
     */
    public function unlock(int $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);

        return response()->json(['message' => 'User unlocked successfully']);
    }
}