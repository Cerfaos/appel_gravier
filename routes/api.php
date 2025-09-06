<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItineraryApiController;
use App\Http\Controllers\Api\SortieApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\GpxAnalysisController;
use App\Http\Controllers\Api\HealthCheckController;
use App\Http\Controllers\Api\SearchApiController;
use App\Http\Controllers\Admin\MonitoringController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Health Check - accessible sans préfixe de version pour monitoring externe
Route::get('/health', [HealthCheckController::class, 'index'])->name('api.health');
Route::get('/health/detailed', [HealthCheckController::class, 'detailed'])->name('api.health.detailed');

// Routes publiques (sans authentification)
Route::prefix('v1')->group(function () {
    
    // Itinéraires publics
    Route::prefix('itineraries')->group(function () {
        Route::get('/', [ItineraryApiController::class, 'index'])
            ->name('api.itineraries.index');
        Route::get('/statistics', [ItineraryApiController::class, 'statistics'])
            ->name('api.itineraries.statistics');
        Route::get('/search-nearby', [ItineraryApiController::class, 'searchNearby'])
            ->name('api.itineraries.search-nearby');
        Route::get('/{id}', [ItineraryApiController::class, 'show'])
            ->name('api.itineraries.show')
            ->where('id', '[0-9]+');
        Route::get('/{id}/gpx-points', [ItineraryApiController::class, 'gpxPoints'])
            ->name('api.itineraries.gpx-points')
            ->where('id', '[0-9]+');
        Route::get('/{id}/images', [ItineraryApiController::class, 'images'])
            ->name('api.itineraries.images')
            ->where('id', '[0-9]+');
    });
    
    // Sorties publiques
    Route::prefix('sorties')->group(function () {
        Route::get('/', [SortieApiController::class, 'index'])
            ->name('api.sorties.index');
        Route::get('/statistics', [SortieApiController::class, 'statistics'])
            ->name('api.sorties.statistics');
        Route::get('/{id}', [SortieApiController::class, 'show'])
            ->name('api.sorties.show')
            ->where('id', '[0-9]+');
        Route::get('/{id}/gpx-points', [SortieApiController::class, 'gpxPoints'])
            ->name('api.sorties.gpx-points')
            ->where('id', '[0-9]+');
        Route::get('/{id}/images', [SortieApiController::class, 'images'])
            ->name('api.sorties.images')
            ->where('id', '[0-9]+');
    });
    
    // Utilisateurs publics (données limitées)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserApiController::class, 'index'])
            ->name('api.users.index');
        Route::get('/{id}', [UserApiController::class, 'show'])
            ->name('api.users.show')
            ->where('id', '[0-9]+');
        Route::get('/{id}/itineraries', [UserApiController::class, 'itineraries'])
            ->name('api.users.itineraries')
            ->where('id', '[0-9]+');
        Route::get('/{id}/sorties', [UserApiController::class, 'sorties'])
            ->name('api.users.sorties')
            ->where('id', '[0-9]+');
    });
    
    // Analyse GPX (rate limited)
    Route::post('gpx/analyze', [GpxAnalysisController::class, 'analyze'])
        ->name('api.gpx.analyze')
        ->middleware('rate_limit:api.gpx.analyze');
    
    // Recherche avancée
    Route::prefix('search')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\SearchApiController::class, 'search'])
            ->name('api.search');
        Route::get('/nearby', [\App\Http\Controllers\Api\SearchApiController::class, 'searchNearby'])
            ->name('api.search.nearby');
        Route::get('/suggestions', [\App\Http\Controllers\Api\SearchApiController::class, 'suggestions'])
            ->name('api.search.suggestions');
        Route::get('/advanced', [\App\Http\Controllers\Api\SearchApiController::class, 'advanced'])
            ->name('api.search.advanced');
    });
});

// Routes nécessitant une authentification
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    
    // Profil utilisateur
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserApiController::class, 'profile'])
            ->name('api.profile.show');
        Route::put('/', [UserApiController::class, 'updateProfile'])
            ->name('api.profile.update');
        Route::post('/avatar', [UserApiController::class, 'uploadAvatar'])
            ->name('api.profile.avatar');
    });
    
    // Gestion des itinéraires (utilisateur connecté)
    Route::prefix('my')->group(function () {
        Route::get('/itineraries', [ItineraryApiController::class, 'userItineraries'])
            ->name('api.my.itineraries');
        Route::post('/itineraries', [ItineraryApiController::class, 'store'])
            ->name('api.my.itineraries.store')
            ->middleware('rate_limit:itinerary.store');
        Route::put('/itineraries/{id}', [ItineraryApiController::class, 'update'])
            ->name('api.my.itineraries.update')
            ->where('id', '[0-9]+');
        Route::delete('/itineraries/{id}', [ItineraryApiController::class, 'destroy'])
            ->name('api.my.itineraries.destroy')
            ->where('id', '[0-9]+');
        
        Route::get('/sorties', [SortieApiController::class, 'userSorties'])
            ->name('api.my.sorties');
        Route::post('/sorties', [SortieApiController::class, 'store'])
            ->name('api.my.sorties.store')
            ->middleware('rate_limit:sortie.store');
        Route::put('/sorties/{id}', [SortieApiController::class, 'update'])
            ->name('api.my.sorties.update')
            ->where('id', '[0-9]+');
        Route::delete('/sorties/{id}', [SortieApiController::class, 'destroy'])
            ->name('api.my.sorties.destroy')
            ->where('id', '[0-9]+');
    });
    
    // Favoris et collections
    Route::prefix('favorites')->group(function () {
        Route::get('/', [UserApiController::class, 'favorites'])
            ->name('api.favorites.index');
        Route::post('/itineraries/{id}', [UserApiController::class, 'addToFavorites'])
            ->name('api.favorites.add')
            ->where('id', '[0-9]+');
        Route::delete('/itineraries/{id}', [UserApiController::class, 'removeFromFavorites'])
            ->name('api.favorites.remove')
            ->where('id', '[0-9]+');
    });
});

// Routes d'administration
Route::prefix('v1/admin')->middleware(['admin'])->group(function () {
    
    // Monitoring et métriques
    Route::prefix('monitoring')->group(function () {
        Route::get('/dashboard', [MonitoringController::class, 'metricsApi'])
            ->name('api.admin.monitoring.dashboard');
        Route::get('/performance', [MonitoringController::class, 'metricsApi'])
            ->name('api.admin.monitoring.performance');
        Route::get('/security', [MonitoringController::class, 'metricsApi'])
            ->name('api.admin.monitoring.security');
        Route::get('/database', [MonitoringController::class, 'metricsApi'])
            ->name('api.admin.monitoring.database');
        Route::get('/search-analytics', [\App\Http\Controllers\Api\SearchApiController::class, 'analytics'])
            ->name('api.admin.monitoring.search-analytics');
    });
    
    // Gestion des utilisateurs
    Route::prefix('users')->group(function () {
        Route::get('/', [UserApiController::class, 'adminIndex'])
            ->name('api.admin.users.index');
        Route::get('/{id}', [UserApiController::class, 'adminShow'])
            ->name('api.admin.users.show')
            ->where('id', '[0-9]+');
        Route::put('/{id}/status', [UserApiController::class, 'updateStatus'])
            ->name('api.admin.users.update-status')
            ->where('id', '[0-9]+');
        Route::post('/{id}/unlock', [UserApiController::class, 'unlock'])
            ->name('api.admin.users.unlock')
            ->where('id', '[0-9]+');
    });
    
    // Gestion du contenu
    Route::prefix('content')->group(function () {
        Route::get('/itineraries', [ItineraryApiController::class, 'adminIndex'])
            ->name('api.admin.itineraries.index');
        Route::put('/itineraries/{id}/status', [ItineraryApiController::class, 'updateStatus'])
            ->name('api.admin.itineraries.update-status')
            ->where('id', '[0-9]+');
        Route::get('/sorties', [SortieApiController::class, 'adminIndex'])
            ->name('api.admin.sorties.index');
        Route::put('/sorties/{id}/status', [SortieApiController::class, 'updateStatus'])
            ->name('api.admin.sorties.update-status')
            ->where('id', '[0-9]+');
    });
    
    // Actions de maintenance
    Route::prefix('maintenance')->group(function () {
        Route::post('/cache/clear', function () {
            \Artisan::call('cache:clear');
            return response()->json(['message' => 'Cache cleared successfully']);
        })->name('api.admin.maintenance.cache-clear');
        
        Route::post('/optimize', function () {
            \Artisan::call('optimize');
            return response()->json(['message' => 'Application optimized successfully']);
        })->name('api.admin.maintenance.optimize');
        
        Route::post('/queue/restart', function () {
            \Artisan::call('queue:restart');
            return response()->json(['message' => 'Queue workers restarted successfully']);
        })->name('api.admin.maintenance.queue-restart');
    });
});

// Routes de webhook (pour intégrations externes)
Route::prefix('webhooks')->group(function () {
    // Webhook pour notifications Slack
    Route::post('/slack', function () {
        // Traitement des webhooks Slack
        return response()->json(['status' => 'received']);
    })->name('api.webhooks.slack');
    
    // Webhook pour synchronisation externe (Strava, Garmin, etc.)
    Route::post('/sync/{provider}', function ($provider) {
        // Traitement des webhooks de synchronisation
        return response()->json(['provider' => $provider, 'status' => 'received']);
    })->name('api.webhooks.sync');
});

// Route de fallback pour les 404 API
Route::fallback(function () {
    return response()->json([
        'error' => 'Not Found',
        'message' => 'The requested API endpoint does not exist.',
        'documentation' => route('api.documentation') ?? '/api/documentation'
    ], 404);
});