<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Health Check",
 *     description="Endpoints pour vérifier la santé de l'API et des services"
 * )
 */
class HealthCheckController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/health",
     *     summary="Vérification de santé globale",
     *     description="Retourne le statut de santé de tous les services critiques",
     *     tags={"Health Check"},
     *     @OA\Response(
     *         response=200,
     *         description="Services en bonne santé",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="healthy"),
     *             @OA\Property(property="timestamp", type="string", format="date-time"),
     *             @OA\Property(property="services", type="object"),
     *             @OA\Property(property="response_time_ms", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=503,
     *         description="Un ou plusieurs services sont défaillants",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="unhealthy"),
     *             @OA\Property(property="services", type="object"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $startTime = microtime(true);
        
        $services = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
            'queue' => $this->checkQueue(),
        ];

        $allHealthy = collect($services)->every(fn($service) => $service['status'] === 'healthy');
        
        $response = [
            'status' => $allHealthy ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toISOString(),
            'services' => $services,
            'response_time_ms' => round((microtime(true) - $startTime) * 1000, 2),
            'version' => config('app.version', '1.0.0'),
            'environment' => app()->environment(),
        ];

        if (!$allHealthy) {
            $response['errors'] = collect($services)
                ->filter(fn($service) => $service['status'] !== 'healthy')
                ->keys()
                ->toArray();
        }

        return response()->json($response, $allHealthy ? 200 : 503);
    }

    /**
     * @OA\Get(
     *     path="/api/health/detailed",
     *     summary="Vérification de santé détaillée",
     *     description="Retourne des informations détaillées sur chaque service",
     *     tags={"Health Check"},
     *     security={{"sanctum": {}}, {"api_key": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Statut détaillé des services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="system", type="object"),
     *             @OA\Property(property="database", type="object"),
     *             @OA\Property(property="cache", type="object"),
     *             @OA\Property(property="performance", type="object")
     *         )
     *     )
     * )
     */
    public function detailed(Request $request)
    {
        // Endpoint protégé pour éviter l'exposition d'informations sensibles
        if (!$request->user() && !$request->hasHeader('X-API-Key')) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        return response()->json([
            'system' => $this->getSystemInfo(),
            'database' => $this->getDatabaseInfo(),
            'cache' => $this->getCacheInfo(),
            'storage' => $this->getStorageInfo(),
            'performance' => $this->getPerformanceMetrics(),
            'generated_at' => now()->toISOString(),
        ]);
    }

    /**
     * Vérification de la base de données
     */
    private function checkDatabase(): array
    {
        try {
            $start = microtime(true);
            
            // Test de connexion simple
            DB::select('SELECT 1');
            
            // Test sur table principale
            $itinerariesCount = DB::table('itineraries')->count();
            
            $responseTime = round((microtime(true) - $start) * 1000, 2);
            
            return [
                'status' => 'healthy',
                'response_time_ms' => $responseTime,
                'records_count' => $itinerariesCount,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => 'Database connection failed',
                'details' => app()->environment('local') ? $e->getMessage() : 'Connection error',
            ];
        }
    }

    /**
     * Vérification du cache
     */
    private function checkCache(): array
    {
        try {
            $start = microtime(true);
            $testKey = 'health_check_' . uniqid();
            $testValue = 'test_' . time();
            
            // Test écriture
            Cache::put($testKey, $testValue, 60);
            
            // Test lecture
            $retrieved = Cache::get($testKey);
            
            // Nettoyage
            Cache::forget($testKey);
            
            $responseTime = round((microtime(true) - $start) * 1000, 2);
            
            if ($retrieved !== $testValue) {
                throw new \Exception('Cache read/write mismatch');
            }
            
            return [
                'status' => 'healthy',
                'response_time_ms' => $responseTime,
                'driver' => config('cache.default'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => 'Cache operation failed',
                'details' => app()->environment('local') ? $e->getMessage() : 'Cache error',
            ];
        }
    }

    /**
     * Vérification du stockage
     */
    private function checkStorage(): array
    {
        try {
            $start = microtime(true);
            $testFile = 'health_check_' . uniqid() . '.txt';
            $testContent = 'Health check test - ' . now()->toISOString();
            
            // Test écriture
            Storage::disk('local')->put($testFile, $testContent);
            
            // Test lecture
            $retrieved = Storage::disk('local')->get($testFile);
            
            // Nettoyage
            Storage::disk('local')->delete($testFile);
            
            $responseTime = round((microtime(true) - $start) * 1000, 2);
            
            if ($retrieved !== $testContent) {
                throw new \Exception('Storage read/write mismatch');
            }
            
            return [
                'status' => 'healthy',
                'response_time_ms' => $responseTime,
                'disk_space_available' => $this->getAvailableDiskSpace(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => 'Storage operation failed',
                'details' => app()->environment('local') ? $e->getMessage() : 'Storage error',
            ];
        }
    }

    /**
     * Vérification des queues
     */
    private function checkQueue(): array
    {
        try {
            // Pour une vérification simple, on regarde si la configuration queue existe
            $driver = config('queue.default');
            $connection = config("queue.connections.{$driver}");
            
            if (!$connection) {
                throw new \Exception('Queue configuration not found');
            }
            
            return [
                'status' => 'healthy',
                'driver' => $driver,
                'configured' => true,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => 'Queue check failed',
                'details' => app()->environment('local') ? $e->getMessage() : 'Queue error',
            ];
        }
    }

    /**
     * Informations système
     */
    private function getSystemInfo(): array
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_time' => now()->toISOString(),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
            'debug_mode' => config('app.debug'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
        ];
    }

    /**
     * Informations base de données
     */
    private function getDatabaseInfo(): array
    {
        try {
            $pdo = DB::connection()->getPdo();
            
            return [
                'driver' => DB::connection()->getDriverName(),
                'version' => $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION),
                'database' => DB::connection()->getDatabaseName(),
                'tables_count' => count(DB::select("SHOW TABLES")),
                'charset' => DB::select("SELECT @@character_set_database as charset")[0]->charset ?? 'unknown',
            ];
        } catch (\Exception $e) {
            return [
                'error' => 'Could not retrieve database info',
                'details' => app()->environment('local') ? $e->getMessage() : null,
            ];
        }
    }

    /**
     * Informations cache
     */
    private function getCacheInfo(): array
    {
        $driver = config('cache.default');
        $config = config("cache.stores.{$driver}");
        
        return [
            'default_driver' => $driver,
            'prefix' => $config['prefix'] ?? null,
            'connection' => $config['connection'] ?? null,
        ];
    }

    /**
     * Informations stockage
     */
    private function getStorageInfo(): array
    {
        return [
            'default_disk' => config('filesystems.default'),
            'available_disks' => array_keys(config('filesystems.disks')),
            'temp_directory' => sys_get_temp_dir(),
            'disk_space' => $this->getAvailableDiskSpace(),
        ];
    }

    /**
     * Métriques de performance
     */
    private function getPerformanceMetrics(): array
    {
        return [
            'memory_usage' => [
                'current' => memory_get_usage(true),
                'peak' => memory_get_peak_usage(true),
                'limit' => $this->parseMemoryLimit(ini_get('memory_limit')),
            ],
            'opcache' => function_exists('opcache_get_status') ? opcache_get_status() : 'not available',
            'uptime' => $this->getSystemUptime(),
        ];
    }

    /**
     * Espace disque disponible
     */
    private function getAvailableDiskSpace(): string
    {
        $bytes = disk_free_space(storage_path());
        if ($bytes === false) {
            return 'unknown';
        }
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Parser la limite mémoire
     */
    private function parseMemoryLimit(string $limit): int
    {
        if ($limit === '-1') {
            return -1;
        }
        
        $value = (int) $limit;
        $unit = strtolower(substr($limit, -1));
        
        switch ($unit) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }
        
        return $value;
    }

    /**
     * Uptime système (approximatif)
     */
    private function getSystemUptime(): string
    {
        if (function_exists('sys_getloadavg') && is_readable('/proc/uptime')) {
            $uptime = file_get_contents('/proc/uptime');
            $uptimeSeconds = (float) explode(' ', $uptime)[0];
            
            $days = floor($uptimeSeconds / 86400);
            $hours = floor(($uptimeSeconds % 86400) / 3600);
            $minutes = floor(($uptimeSeconds % 3600) / 60);
            
            return "{$days}d {$hours}h {$minutes}m";
        }
        
        return 'unknown';
    }
}