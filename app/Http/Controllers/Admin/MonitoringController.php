<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CacheService;
use App\Services\SecurityService;
use App\Services\DatabaseOptimizationService;
use App\Services\TwoFactorAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MonitoringController extends Controller
{
    protected $cacheService;
    protected $securityService;
    protected $dbOptimizationService;
    protected $twoFactorService;

    public function __construct(
        CacheService $cacheService,
        SecurityService $securityService,
        DatabaseOptimizationService $dbOptimizationService,
        TwoFactorAuthService $twoFactorService
    ) {
        $this->middleware(['auth', 'role:admin']);
        $this->cacheService = $cacheService;
        $this->securityService = $securityService;
        $this->dbOptimizationService = $dbOptimizationService;
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Dashboard principal de monitoring
     */
    public function index()
    {
        $data = [
            'system_health' => $this->getSystemHealth(),
            'performance_metrics' => $this->getPerformanceMetrics(),
            'security_overview' => $this->getSecurityOverview(),
            'database_health' => $this->getDatabaseHealth(),
            'user_analytics' => $this->getUserAnalytics(),
            'content_metrics' => $this->getContentMetrics(),
            'recent_activities' => $this->getRecentActivities(),
        ];

        return view('admin.monitoring.dashboard', compact('data'));
    }

    /**
     * Détails des performances système
     */
    public function performance()
    {
        $data = [
            'cache_stats' => $this->cacheService->getCacheStats(),
            'slow_queries' => $this->dbOptimizationService->analyzeSlowQueries(),
            'table_stats' => $this->dbOptimizationService->getTableStats(),
            'optimization_suggestions' => $this->dbOptimizationService->suggestOptimizations(),
            'server_resources' => $this->getServerResources(),
        ];

        return view('admin.monitoring.performance', compact('data'));
    }

    /**
     * Détails de sécurité
     */
    public function security()
    {
        $data = [
            'security_stats' => $this->securityService->getSecurityStats(),
            'recent_threats' => $this->getRecentThreats(),
            'blocked_ips' => $this->getBlockedIPs(),
            'failed_login_attempts' => $this->getFailedLoginAttempts(),
            'twofa_stats' => $this->twoFactorService->getStats(),
        ];

        return view('admin.monitoring.security', compact('data'));
    }

    /**
     * Monitoring de la base de données
     */
    public function database()
    {
        $data = [
            'optimization_report' => $this->dbOptimizationService->generateOptimizationReport(),
            'recent_queries' => $this->getRecentQueries(),
            'connection_stats' => $this->getConnectionStats(),
        ];

        return view('admin.monitoring.database', compact('data'));
    }

    /**
     * API endpoint pour les métriques temps réel
     */
    public function metricsApi(Request $request)
    {
        $type = $request->get('type', 'overview');
        
        $data = match($type) {
            'performance' => $this->getPerformanceMetrics(),
            'security' => $this->getSecurityOverview(),
            'database' => $this->getDatabaseHealth(),
            'users' => $this->getUserAnalytics(),
            default => $this->getSystemHealth()
        };

        return response()->json([
            'data' => $data,
            'timestamp' => now()->toISOString(),
            'type' => $type
        ]);
    }

    /**
     * Obtenir l'état de santé du système
     */
    protected function getSystemHealth(): array
    {
        try {
            return [
                'status' => 'healthy',
                'uptime' => $this->getSystemUptime(),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'environment' => config('app.env'),
                'debug_mode' => config('app.debug'),
                'cache_driver' => config('cache.default'),
                'session_driver' => config('session.driver'),
                'queue_driver' => config('queue.default'),
                'memory_usage' => $this->getMemoryUsage(),
                'disk_usage' => $this->getDiskUsage(),
                'services_status' => $this->checkServicesStatus(),
            ];
        } catch (\Exception $e) {
            Log::error('System health check failed', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Obtenir les métriques de performance
     */
    protected function getPerformanceMetrics(): array
    {
        return [
            'response_time' => $this->getAverageResponseTime(),
            'requests_per_minute' => $this->getRequestsPerMinute(),
            'cache_hit_rate' => $this->cacheService->getCacheStats()['hit_rate'] ?? 'N/A',
            'database_queries' => $this->getDatabaseQueriesCount(),
            'memory_peak' => memory_get_peak_usage(true),
            'execution_time' => microtime(true) - LARAVEL_START,
        ];
    }

    /**
     * Obtenir l'aperçu de sécurité
     */
    protected function getSecurityOverview(): array
    {
        $securityStats = $this->securityService->getSecurityStats();
        
        return [
            'security_level' => $securityStats['security_level'],
            'blocked_ips' => $securityStats['blocked_ips'],
            'suspicious_activities' => $securityStats['suspicious_activities'],
            'failed_logins_today' => $this->getFailedLoginsToday(),
            'admin_sessions_active' => $this->getActiveAdminSessions(),
            'twofa_adoption_rate' => $this->twoFactorService->getStats()['adoption_rate'] ?? 0,
        ];
    }

    /**
     * Obtenir l'état de santé de la base de données
     */
    protected function getDatabaseHealth(): array
    {
        return [
            'connections' => DB::select('SHOW STATUS WHERE Variable_name = "Threads_connected"')[0]->Value ?? 0,
            'max_connections' => DB::select('SHOW VARIABLES WHERE Variable_name = "max_connections"')[0]->Value ?? 0,
            'slow_queries' => DB::select('SHOW STATUS WHERE Variable_name = "Slow_queries"')[0]->Value ?? 0,
            'uptime' => DB::select('SHOW STATUS WHERE Variable_name = "Uptime"')[0]->Value ?? 0,
            'total_size_mb' => $this->dbOptimizationService->getDatabaseSize()['total_size_mb'] ?? 0,
        ];
    }

    /**
     * Obtenir les analytics utilisateurs
     */
    protected function getUserAnalytics(): array
    {
        return [
            'total_users' => \App\Models\User::count(),
            'active_today' => \App\Models\User::whereDate('updated_at', today())->count(),
            'new_this_week' => \App\Models\User::where('created_at', '>=', now()->subWeek())->count(),
            'admins_count' => \App\Models\User::where('role', 'admin')->count(),
            'verified_users' => \App\Models\User::whereNotNull('email_verified_at')->count(),
            'twofa_enabled' => \App\Models\User::where('google2fa_enabled', true)->count(),
        ];
    }

    /**
     * Obtenir les métriques de contenu
     */
    protected function getContentMetrics(): array
    {
        return [
            'itineraries' => [
                'total' => \App\Models\Itinerary::count(),
                'published' => \App\Models\Itinerary::where('status', 'published')->count(),
                'new_today' => \App\Models\Itinerary::whereDate('created_at', today())->count(),
            ],
            'sorties' => [
                'total' => \App\Models\Sortie::count(),
                'published' => \App\Models\Sortie::where('status', 'published')->count(),
                'new_today' => \App\Models\Sortie::whereDate('created_at', today())->count(),
            ],
            'contacts' => [
                'total' => \App\Models\Contact::count(),
                'pending' => \App\Models\Contact::where('status', 'pending')->count(),
                'new_today' => \App\Models\Contact::whereDate('created_at', today())->count(),
            ],
        ];
    }

    /**
     * Obtenir les activités récentes
     */
    protected function getRecentActivities(): array
    {
        return [
            'recent_users' => \App\Models\User::latest()->limit(5)->get(['id', 'name', 'email', 'created_at']),
            'recent_itineraries' => \App\Models\Itinerary::with('user')->latest()->limit(5)->get(['id', 'title', 'user_id', 'status', 'created_at']),
            'recent_contacts' => \App\Models\Contact::latest()->limit(5)->get(['id', 'name', 'email', 'subject', 'status', 'created_at']),
        ];
    }

    /**
     * Obtenir l'uptime du système
     */
    protected function getSystemUptime(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return 'N/A (Windows)';
        }
        
        $uptime = shell_exec('uptime -p');
        return trim($uptime) ?: 'N/A';
    }

    /**
     * Obtenir l'utilisation mémoire
     */
    protected function getMemoryUsage(): array
    {
        return [
            'current_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'limit' => ini_get('memory_limit'),
        ];
    }

    /**
     * Obtenir l'utilisation du disque
     */
    protected function getDiskUsage(): array
    {
        $path = base_path();
        $bytes = disk_free_space($path);
        $total = disk_total_space($path);
        
        return [
            'free_gb' => round($bytes / 1024 / 1024 / 1024, 2),
            'total_gb' => round($total / 1024 / 1024 / 1024, 2),
            'used_percent' => round((($total - $bytes) / $total) * 100, 2),
        ];
    }

    /**
     * Vérifier le statut des services
     */
    protected function checkServicesStatus(): array
    {
        $services = [];
        
        // Vérifier Redis
        try {
            Cache::store('redis')->put('health_check', true, 1);
            $services['redis'] = Cache::store('redis')->get('health_check') ? 'online' : 'offline';
        } catch (\Exception $e) {
            $services['redis'] = 'offline';
        }
        
        // Vérifier la base de données
        try {
            DB::select('SELECT 1');
            $services['database'] = 'online';
        } catch (\Exception $e) {
            $services['database'] = 'offline';
        }
        
        return $services;
    }

    /**
     * Obtenir le temps de réponse moyen
     */
    protected function getAverageResponseTime(): float
    {
        // Simulation - dans un vrai projet, utiliser des métriques de monitoring
        return round(microtime(true) - LARAVEL_START, 3);
    }

    /**
     * Obtenir le nombre de requêtes par minute
     */
    protected function getRequestsPerMinute(): int
    {
        // Utiliser le cache pour compter les requêtes
        $key = 'requests_count_' . now()->format('Y-m-d H:i');
        return Cache::get($key, 0);
    }

    /**
     * Obtenir le nombre de requêtes DB
     */
    protected function getDatabaseQueriesCount(): int
    {
        return DB::getQueryLog() ? count(DB::getQueryLog()) : 0;
    }

    /**
     * Obtenir les tentatives de connexion échouées aujourd'hui
     */
    protected function getFailedLoginsToday(): int
    {
        return \App\Models\User::where('failed_login_attempts', '>', 0)
            ->whereDate('updated_at', today())
            ->sum('failed_login_attempts');
    }

    /**
     * Obtenir le nombre de sessions admin actives
     */
    protected function getActiveAdminSessions(): int
    {
        return DB::table('sessions')
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->where('users.role', 'admin')
            ->where('sessions.last_activity', '>', now()->subMinutes(30)->timestamp)
            ->count();
    }

    /**
     * Obtenir les menaces récentes
     */
    protected function getRecentThreats(): array
    {
        // Cette méthode devrait récupérer les logs de sécurité récents
        // Pour l'instant, retourner des données simulées
        return [];
    }

    /**
     * Obtenir les IPs bloquées
     */
    protected function getBlockedIPs(): array
    {
        $redis = app('redis');
        $blockedIps = [];
        
        foreach ($redis->keys('blocked_ip:*') as $key) {
            $ip = str_replace('blocked_ip:', '', $key);
            $data = $redis->get($key);
            $blockedIps[] = [
                'ip' => $ip,
                'data' => is_string($data) ? $data : json_decode($data, true),
                'ttl' => $redis->ttl($key),
            ];
        }
        
        return $blockedIps;
    }

    /**
     * Obtenir les tentatives de connexion échouées
     */
    protected function getFailedLoginAttempts(): array
    {
        return \App\Models\User::where('failed_login_attempts', '>', 0)
            ->orderByDesc('failed_login_attempts')
            ->limit(10)
            ->get(['id', 'name', 'email', 'failed_login_attempts', 'locked_until'])
            ->toArray();
    }

    /**
     * Obtenir les requêtes récentes
     */
    protected function getRecentQueries(): array
    {
        // Cette méthode devrait analyser les logs de requêtes récents
        return DB::getQueryLog() ?: [];
    }

    /**
     * Obtenir les statistiques de connexion DB
     */
    protected function getConnectionStats(): array
    {
        try {
            $stats = DB::select('SHOW STATUS WHERE Variable_name IN ("Threads_connected", "Threads_running", "Max_used_connections")');
            
            $result = [];
            foreach ($stats as $stat) {
                $result[$stat->Variable_name] = $stat->Value;
            }
            
            return $result;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}