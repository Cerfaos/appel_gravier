<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseTimeMiddleware
{
    /**
     * Middleware pour mesurer le temps de réponse des API
     * et ajouter des headers de performance
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        // Traiter la requête
        $response = $next($request);

        // Calculer les métriques
        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);
        
        $responseTime = round(($endTime - $startTime) * 1000, 2); // en millisecondes
        $memoryUsed = $endMemory - $startMemory;
        $peakMemory = memory_get_peak_usage(true);

        // Ajouter les headers de performance
        $response->headers->set('X-Response-Time', $responseTime . 'ms');
        $response->headers->set('X-Memory-Usage', $this->formatBytes($memoryUsed));
        $response->headers->set('X-Memory-Peak', $this->formatBytes($peakMemory));
        $response->headers->set('X-Server-Time', now()->toISOString());

        // Logger les requêtes lentes (> 1000ms)
        if ($responseTime > 1000) {
            Log::warning('Slow API Response', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'response_time_ms' => $responseTime,
                'memory_used_mb' => round($memoryUsed / 1024 / 1024, 2),
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        // Logger les métriques pour analytics (seulement pour les routes API)
        if ($request->is('api/*')) {
            $this->logApiMetrics($request, $response, $responseTime, $memoryUsed);
        }

        return $response;
    }

    /**
     * Logger les métriques API pour analytics
     */
    private function logApiMetrics(Request $request, Response $response, float $responseTime, int $memoryUsed): void
    {
        $metrics = [
            'timestamp' => now()->toISOString(),
            'method' => $request->method(),
            'endpoint' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'response_time_ms' => $responseTime,
            'memory_used_bytes' => $memoryUsed,
            'user_id' => $request->user()?->id,
            'ip_hash' => hash('sha256', $request->ip()), // Pour la confidentialité
            'user_agent_hash' => hash('sha256', $request->userAgent() ?? ''),
        ];

        // En production, vous pourriez envoyer ces métriques vers un service d'analytics
        // Ici on utilise le log pour l'exemple
        Log::channel('api-metrics')->info('API_CALL', $metrics);
    }

    /**
     * Formater les bytes en format lisible
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}