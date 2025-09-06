<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // API général - 200 requêtes par minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(200)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        // API liste - 60 requêtes par minute pour les listes
        RateLimiter::for('api-list', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        // API détail - 120 requêtes par minute pour les détails
        RateLimiter::for('api-detail', function (Request $request) {
            return Limit::perMinute(120)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        // Formulaire de contact - 5 par heure
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        // Tentatives de connexion - 10 par 15 minutes
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinutes(15, 10)->by(
                $request->email . $request->ip()
            );
        });

        // Création d'itinéraires - 10 par jour pour les utilisateurs connectés
        RateLimiter::for('itinerary.store', function (Request $request) {
            return $request->user() 
                ? Limit::perDay(10)->by($request->user()->id)
                : Limit::none();
        });

        // Création de sorties - 20 par jour pour les utilisateurs connectés
        RateLimiter::for('sortie.store', function (Request $request) {
            return $request->user() 
                ? Limit::perDay(20)->by($request->user()->id)
                : Limit::none();
        });

        // Analyse GPX - 50 par jour par IP
        RateLimiter::for('api.gpx.analyze', function (Request $request) {
            return Limit::perDay(50)->by($request->ip());
        });

        // Upload d'avatar - 5 par jour par utilisateur
        RateLimiter::for('avatar.upload', function (Request $request) {
            return $request->user() 
                ? Limit::perDay(5)->by($request->user()->id)
                : Limit::none();
        });

        // Requêtes de récupération de mot de passe - 3 par heure par email
        RateLimiter::for('password.reset', function (Request $request) {
            return Limit::perHour(3)->by($request->email);
        });

        // 2FA - 5 tentatives par minute
        RateLimiter::for('2fa', function (Request $request) {
            return Limit::perMinute(5)->by(
                ($request->user()?->id ?: 'guest') . ':' . $request->ip()
            );
        });

        // Recherche avancée - 100 requêtes par minute
        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(100)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        // Administration - 300 requêtes par minute pour les admins
        RateLimiter::for('admin', function (Request $request) {
            if ($request->user() && in_array($request->user()->role, ['admin', 'super_admin'])) {
                return Limit::perMinute(300)->by($request->user()->id);
            }
            return Limit::none();
        });

        // Webhooks - 1000 requêtes par minute (pour les intégrations externes)
        RateLimiter::for('webhook', function (Request $request) {
            return Limit::perMinute(1000)->by($request->ip());
        });

        // Monitoring API - 60 requêtes par minute
        RateLimiter::for('monitoring', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }
}