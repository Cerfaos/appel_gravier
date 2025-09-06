<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class CacheManagementCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cache:manage 
                           {--clear : Clear all caches}
                           {--warm : Warm up caches with fresh data}
                           {--stats : Show cache statistics}
                           {--cleanup : Clean up expired cache entries}
                           {--tag=* : Specific cache tags to target}
                           {--force : Force operation without confirmation}';

    /**
     * The console command description.
     */
    protected $description = 'Advanced cache management with warming, statistics, and cleanup';

    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🗄️ Cache Management Tool');
        $startTime = microtime(true);

        try {
            $clear = $this->option('clear');
            $warm = $this->option('warm');
            $stats = $this->option('stats');
            $cleanup = $this->option('cleanup');
            $tags = $this->option('tag');
            $force = $this->option('force');

            // Si aucune option spécifique, afficher les statistiques
            if (!$clear && !$warm && !$cleanup && empty($tags)) {
                $stats = true;
            }

            // 1. Statistiques du cache
            if ($stats) {
                $this->showCacheStatistics();
            }

            // 2. Nettoyage du cache
            if ($clear) {
                $this->clearCache($tags, $force);
            }

            // 3. Nettoyage des entrées expirées
            if ($cleanup) {
                $this->cleanupExpiredCache();
            }

            // 4. Réchauffage du cache
            if ($warm) {
                $this->warmUpCache($force);
            }

            $executionTime = round(microtime(true) - $startTime, 2);
            $this->info("✅ Cache management completed in {$executionTime}s");

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Cache management failed: " . $e->getMessage());
            Log::error('Cache management command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return self::FAILURE;
        }
    }

    /**
     * Afficher les statistiques du cache
     */
    private function showCacheStatistics(): void
    {
        $this->info('📊 Cache Statistics');
        
        try {
            $stats = $this->cacheService->getCacheStats();
            
            // Statistiques générales
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Hit Rate', $stats['hit_rate'] . '%'],
                    ['Miss Rate', $stats['miss_rate'] . '%'],
                    ['Total Keys', number_format($stats['total_keys'])],
                    ['Total Size (MB)', number_format($stats['total_size_mb'], 2)],
                    ['Average TTL', $stats['avg_ttl'] . 's'],
                ]
            );

            // Top clés par utilisation
            if (!empty($stats['top_keys'])) {
                $this->info('🔥 Most Accessed Keys:');
                $this->table(
                    ['Key', 'Hits', 'Size (KB)', 'TTL'],
                    collect($stats['top_keys'])->map(function ($key) {
                        return [
                            $key['name'],
                            number_format($key['hits']),
                            number_format($key['size_kb'], 2),
                            $key['ttl'] . 's'
                        ];
                    })->toArray()
                );
            }

            // Statistiques par tag
            if (!empty($stats['by_tag'])) {
                $this->info('🏷️ Cache Usage by Tag:');
                $this->table(
                    ['Tag', 'Keys', 'Size (MB)', 'Hit Rate'],
                    collect($stats['by_tag'])->map(function ($tag, $name) {
                        return [
                            $name,
                            number_format($tag['keys']),
                            number_format($tag['size_mb'], 2),
                            $tag['hit_rate'] . '%'
                        ];
                    })->toArray()
                );
            }

        } catch (\Exception $e) {
            $this->warn("Failed to retrieve cache statistics: " . $e->getMessage());
        }
    }

    /**
     * Vider le cache
     */
    private function clearCache(array $tags, bool $force): void
    {
        if (!empty($tags)) {
            $this->info("🧹 Clearing cache for tags: " . implode(', ', $tags));
            
            foreach ($tags as $tag) {
                try {
                    $this->cacheService->invalidateTag($tag);
                    $this->line("  ✅ Cleared cache for tag: {$tag}");
                } catch (\Exception $e) {
                    $this->warn("  ❌ Failed to clear tag {$tag}: " . $e->getMessage());
                }
            }
        } else {
            $this->info('🧹 Clearing all caches...');
            
            if (!$force && !$this->confirm('This will clear ALL cache data. Continue?')) {
                $this->warn('Cache clearing cancelled.');
                return;
            }

            try {
                // Vider tous les caches Laravel
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                
                // Vider le cache applicatif
                $this->cacheService->invalidateTags(['itineraries', 'sorties', 'users', 'stats']);
                
                $this->info('✅ All caches cleared');
                
            } catch (\Exception $e) {
                $this->error("Failed to clear caches: " . $e->getMessage());
            }
        }
    }

    /**
     * Nettoyer les entrées de cache expirées
     */
    private function cleanupExpiredCache(): void
    {
        $this->info('🧹 Cleaning up expired cache entries...');
        
        try {
            $redis = app('redis');
            $cleanedKeys = 0;
            
            // Scanner toutes les clés avec préfixe Laravel
            $prefix = config('database.redis.options.prefix', '');
            $pattern = $prefix . 'laravel_database_*';
            
            $keys = $redis->keys($pattern);
            
            foreach ($keys as $key) {
                $ttl = $redis->ttl($key);
                
                // Si la clé est expirée (TTL = -2) ou n'a pas de TTL (TTL = -1) et est ancienne
                if ($ttl === -2) {
                    $redis->del($key);
                    $cleanedKeys++;
                }
            }
            
            // Nettoyer aussi les clés de session expirées
            $sessionPattern = $prefix . 'laravel_session:*';
            $sessionKeys = $redis->keys($sessionPattern);
            
            foreach ($sessionKeys as $key) {
                $ttl = $redis->ttl($key);
                if ($ttl === -2) {
                    $redis->del($key);
                    $cleanedKeys++;
                }
            }
            
            if ($cleanedKeys > 0) {
                $this->info("✅ Cleaned up {$cleanedKeys} expired cache entries");
            } else {
                $this->info('ℹ️ No expired cache entries to clean up');
            }
            
        } catch (\Exception $e) {
            $this->warn("Cache cleanup failed: " . $e->getMessage());
        }
    }

    /**
     * Réchauffer le cache avec des données fraîches
     */
    private function warmUpCache(bool $force): void
    {
        $this->info('🔥 Warming up cache...');
        
        if (!$force && !$this->confirm('This will pre-load cache with fresh data. Continue?')) {
            $this->warn('Cache warming cancelled.');
            return;
        }

        $warmedItems = 0;
        
        try {
            // Réchauffer les itinéraires populaires
            $this->line('Warming itineraries cache...');
            $this->cacheService->getPopularItineraries(20);
            $warmedItems++;
            
            // Réchauffer les statistiques globales
            $this->line('Warming statistics cache...');
            $this->cacheService->warmUpStatistics();
            $warmedItems++;
            
            // Réchauffer les sorties populaires
            $this->line('Warming sorties cache...');
            $this->cacheService->getPopularSorties(20);
            $warmedItems++;
            
            // Réchauffer le cache de recherche
            $this->line('Warming search cache...');
            $this->cacheService->warmUpSearchCache();
            $warmedItems++;
            
            $this->info("✅ Cache warmed up with {$warmedItems} data sets");
            
        } catch (\Exception $e) {
            $this->warn("Cache warming failed: " . $e->getMessage());
        }
    }
}