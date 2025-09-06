<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdvancedRateLimitingMiddleware
{
    protected $limits = [
        // Endpoints sensibles avec limites strictes
        'contact' => ['requests' => 5, 'minutes' => 60], // 5 contacts par heure
        'login' => ['requests' => 10, 'minutes' => 15], // 10 tentatives de connexion par 15 min
        'register' => ['requests' => 3, 'minutes' => 60], // 3 inscriptions par heure
        'password.reset' => ['requests' => 5, 'minutes' => 60], // 5 reset mdp par heure
        
        // Endpoints d'upload
        'itinerary.store' => ['requests' => 10, 'minutes' => 60], // 10 itinéraires par heure
        'sortie.store' => ['requests' => 15, 'minutes' => 60], // 15 sorties par heure
        
        // API endpoints
        'api.gpx.analyze' => ['requests' => 20, 'minutes' => 10], // 20 analyses GPX par 10 min
        
        // Global limits par IP
        'global' => ['requests' => 200, 'minutes' => 10], // 200 requêtes par 10 min (global)
    ];

    public function handle(Request $request, Closure $next, string $limitType = 'global')
    {
        $ip = $this->getClientIp($request);
        $key = $this->getRateLimitKey($request, $limitType, $ip);
        
        // Vérifier si l'IP est dans la whitelist (pour les admins)
        if ($this->isWhitelisted($ip, $request)) {
            return $next($request);
        }
        
        // Vérifier si l'IP est bloquée
        if ($this->isBlocked($ip)) {
            return $this->rateLimitResponse('IP temporarily blocked due to excessive requests');
        }
        
        $limit = $this->limits[$limitType] ?? $this->limits['global'];
        
        if ($this->exceedsRateLimit($key, $limit)) {
            // Log tentative de dépassement
            Log::warning('Rate limit exceeded', [
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'endpoint' => $request->path(),
                'limit_type' => $limitType,
                'limit' => $limit
            ]);
            
            // Bloquer temporairement si trop de dépassements
            $this->handleExcessiveRequests($ip, $limitType);
            
            return $this->rateLimitResponse('Too many requests. Please try again later.');
        }
        
        // Enregistrer la requête
        $this->recordRequest($key, $limit);
        
        $response = $next($request);
        
        // Ajouter les headers de rate limit
        $response = $this->addRateLimitHeaders($response, $key, $limit);
        
        return $response;
    }

    /**
     * Obtenir l'IP réelle du client (même derrière un proxy/CDN)
     */
    private function getClientIp(Request $request): string
    {
        // Vérifier les headers de proxy dans l'ordre de priorité
        $headers = [
            'CF-Connecting-IP',     // Cloudflare
            'HTTP_CF_CONNECTING_IP', // Cloudflare alternative
            'HTTP_X_FORWARDED_FOR', // Standard proxy header
            'HTTP_X_FORWARDED',     // Alternative
            'HTTP_X_CLUSTER_CLIENT_IP', // Cluster
            'HTTP_FORWARDED_FOR',   // Alternative
            'HTTP_FORWARDED',       // RFC 7239
            'REMOTE_ADDR'          // Direct connection
        ];

        foreach ($headers as $header) {
            $ip = $request->server($header) ?? $request->header($header);
            if ($ip) {
                // Prendre la première IP si multiple
                $ip = explode(',', $ip)[0];
                $ip = trim($ip);
                
                // Valider que c'est une IP valide
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    /**
     * Générer la clé de rate limiting
     */
    private function getRateLimitKey(Request $request, string $limitType, string $ip): string
    {
        $identifier = $ip;
        
        // Utiliser l'ID utilisateur si connecté (pour des limites personnalisées)
        if ($request->user()) {
            $identifier = 'user:' . $request->user()->id;
        }
        
        return "rate_limit:{$limitType}:{$identifier}";
    }

    /**
     * Vérifier si l'IP est dans la whitelist
     */
    private function isWhitelisted(string $ip, Request $request): bool
    {
        // IPs de développement local
        $whitelist = [
            '127.0.0.1',
            '::1',
            'localhost'
        ];
        
        // Ajouter des IPs admin depuis la config
        $adminIps = config('security.admin_ips', []);
        $whitelist = array_merge($whitelist, $adminIps);
        
        // Utilisateurs admin connectés ont des limites plus souples
        if ($request->user() && $request->user()->role === 'admin') {
            return true;
        }
        
        return in_array($ip, $whitelist);
    }

    /**
     * Vérifier si l'IP est temporairement bloquée
     */
    private function isBlocked(string $ip): bool
    {
        return Cache::has("blocked_ip:{$ip}");
    }

    /**
     * Vérifier si la limite est dépassée
     */
    private function exceedsRateLimit(string $key, array $limit): bool
    {
        $current = Cache::get($key, 0);
        return $current >= $limit['requests'];
    }

    /**
     * Enregistrer une nouvelle requête
     */
    private function recordRequest(string $key, array $limit): void
    {
        $ttl = $limit['minutes'] * 60; // Convertir en secondes
        $current = Cache::get($key, 0);
        
        Cache::put($key, $current + 1, $ttl);
    }

    /**
     * Gérer les requêtes excessives avec blocage temporaire
     */
    private function handleExcessiveRequests(string $ip, string $limitType): void
    {
        $violationKey = "violations:{$limitType}:{$ip}";
        $violations = Cache::get($violationKey, 0);
        $violations++;
        
        // Enregistrer les violations pour 24h
        Cache::put($violationKey, $violations, 86400);
        
        // Blocage progressif basé sur le nombre de violations
        if ($violations >= 5) {
            // 5+ violations = blocage 24h
            Cache::put("blocked_ip:{$ip}", true, 86400);
            Log::alert('IP blocked for 24h due to excessive rate limit violations', [
                'ip' => $ip,
                'violations' => $violations,
                'limit_type' => $limitType
            ]);
        } elseif ($violations >= 3) {
            // 3-4 violations = blocage 1h
            Cache::put("blocked_ip:{$ip}", true, 3600);
            Log::warning('IP blocked for 1h due to repeated rate limit violations', [
                'ip' => $ip,
                'violations' => $violations,
                'limit_type' => $limitType
            ]);
        } elseif ($violations >= 2) {
            // 2 violations = blocage 15 min
            Cache::put("blocked_ip:{$ip}", true, 900);
        }
    }

    /**
     * Générer une réponse d'erreur de rate limit
     */
    private function rateLimitResponse(string $message): Response
    {
        return response()->json([
            'error' => 'Rate Limit Exceeded',
            'message' => $message,
            'retry_after' => 900 // 15 minutes
        ], ResponseAlias::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * Ajouter les headers de rate limit à la réponse
     */
    private function addRateLimitHeaders($response, string $key, array $limit)
    {
        $current = Cache::get($key, 0);
        $remaining = max(0, $limit['requests'] - $current);
        $resetTime = time() + ($limit['minutes'] * 60);
        
        $response->headers->set('X-RateLimit-Limit', $limit['requests']);
        $response->headers->set('X-RateLimit-Remaining', $remaining);
        $response->headers->set('X-RateLimit-Reset', $resetTime);
        
        return $response;
    }
}