<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware globaux
        $middleware->web(append: [
            \App\Http\Middleware\CacheInvalidationMiddleware::class,
        ]);

        // Middleware API
        $middleware->api(prepend: [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'api.metrics',
        ]);

        // Alias de middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'security' => \App\Http\Middleware\SecurityMiddleware::class,
            'rate_limit' => \App\Http\Middleware\AdvancedRateLimitingMiddleware::class,
            '2fa' => \App\Http\Middleware\TwoFactorMiddleware::class,
            'api.metrics' => \App\Http\Middleware\ApiResponseTimeMiddleware::class,
        ]);

        // Groupes de middleware
        $middleware->group('admin', [
            'auth',
            'verified',
            'role:admin',
        ]);

        $middleware->group('api-auth', [
            'auth:sanctum',
            'throttle:api',
        ]);

        // Configuration du rate limiting via les services
        // Les limites personnalisées seront définies dans le RateLimitServiceProvider
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configuration des exceptions personnalisées
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e) {
            if (request()->is('api/*')) {
                return response()->json([
                    'error' => 'Unauthenticated',
                    'message' => 'Authentication required',
                ], 401);
            }
        });

        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e) {
            if (request()->is('api/*')) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Insufficient permissions',
                ], 403);
            }
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e) {
            if (request()->is('api/*')) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => 'The given data was invalid',
                    'errors' => $e->errors(),
                ], 422);
            }
        });
    })->create();
