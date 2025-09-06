<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class DatabaseOptimizationService
{
    /**
     * Analyser les requêtes lentes
     */
    public function analyzeSlowQueries(): Collection
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return collect([]);
        }

        try {
            // Activer le log des requêtes lentes si nécessaire
            DB::statement("SET GLOBAL slow_query_log = 'ON'");
            DB::statement("SET GLOBAL long_query_time = 1"); // 1 seconde

            // Analyser les requêtes récentes du processlist
            $processes = DB::select("
                SELECT 
                    id,
                    user,
                    host,
                    db,
                    command,
                    time,
                    state,
                    info,
                    time as duration
                FROM information_schema.processlist 
                WHERE command != 'Sleep' 
                AND time > 1
                ORDER BY time DESC
                LIMIT 20
            ");

            return collect($processes)->map(function ($process) {
                return [
                    'id' => $process->id,
                    'duration' => $process->duration,
                    'query' => $this->sanitizeQuery($process->info),
                    'status' => $process->state,
                    'user' => $process->user,
                    'host' => $process->host
                ];
            });

        } catch (\Exception $e) {
            Log::error('Failed to analyze slow queries', ['error' => $e->getMessage()]);
            return collect([]);
        }
    }

    /**
     * Analyser l'utilisation des index
     */
    public function analyzeIndexUsage(): Collection
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return collect([]);
        }

        try {
            $database = config('database.connections.mysql.database');
            
            $indexes = DB::select("
                SELECT 
                    t.table_name,
                    t.index_name,
                    t.column_name,
                    t.cardinality,
                    s.rows_examined,
                    s.rows_read,
                    ROUND(s.avg_timer_wait/1000000000000, 6) as avg_time_ms
                FROM information_schema.statistics t
                LEFT JOIN performance_schema.table_io_waits_summary_by_index_usage s 
                    ON t.table_schema = s.object_schema 
                    AND t.table_name = s.object_name 
                    AND t.index_name = s.index_name
                WHERE t.table_schema = ?
                AND t.table_name IN (
                    'itineraries', 'sorties', 'gpx_points', 'sortie_gpx_points',
                    'itinerary_images', 'sortie_images', 'users', 'contacts'
                )
                ORDER BY t.table_name, t.index_name, t.seq_in_index
            ", [$database]);

            return collect($indexes)->groupBy('table_name')->map(function ($tableIndexes, $tableName) {
                return $tableIndexes->groupBy('index_name')->map(function ($indexColumns, $indexName) {
                    $first = $indexColumns->first();
                    return [
                        'index_name' => $indexName,
                        'columns' => $indexColumns->pluck('column_name')->toArray(),
                        'cardinality' => $first->cardinality,
                        'usage_stats' => [
                            'rows_examined' => $first->rows_examined,
                            'rows_read' => $first->rows_read,
                            'avg_time_ms' => $first->avg_time_ms
                        ]
                    ];
                });
            });

        } catch (\Exception $e) {
            Log::error('Failed to analyze index usage', ['error' => $e->getMessage()]);
            return collect([]);
        }
    }

    /**
     * Obtenir les statistiques des tables
     */
    public function getTableStats(): Collection
    {
        try {
            $database = config('database.connections.mysql.database');
            
            $stats = DB::select("
                SELECT 
                    table_name,
                    table_rows,
                    ROUND(data_length / 1024 / 1024, 2) as data_size_mb,
                    ROUND(index_length / 1024 / 1024, 2) as index_size_mb,
                    ROUND((data_length + index_length) / 1024 / 1024, 2) as total_size_mb,
                    auto_increment,
                    table_collation,
                    create_time,
                    update_time
                FROM information_schema.tables 
                WHERE table_schema = ?
                AND table_name IN (
                    'itineraries', 'sorties', 'gpx_points', 'sortie_gpx_points',
                    'itinerary_images', 'sortie_images', 'users', 'contacts',
                    'blog_posts', 'ppg_exercises', 'ppg_programs'
                )
                ORDER BY (data_length + index_length) DESC
            ", [$database]);

            return collect($stats)->map(function ($stat) {
                return [
                    'table_name' => $stat->table_name,
                    'row_count' => number_format($stat->table_rows),
                    'data_size_mb' => $stat->data_size_mb,
                    'index_size_mb' => $stat->index_size_mb,
                    'total_size_mb' => $stat->total_size_mb,
                    'auto_increment' => $stat->auto_increment,
                    'collation' => $stat->table_collation,
                    'last_update' => $stat->update_time
                ];
            });

        } catch (\Exception $e) {
            Log::error('Failed to get table stats', ['error' => $e->getMessage()]);
            return collect([]);
        }
    }

    /**
     * Suggérer des optimisations
     */
    public function suggestOptimizations(): array
    {
        $suggestions = [];
        
        try {
            $tableStats = $this->getTableStats();
            $slowQueries = $this->analyzeSlowQueries();
            
            // Vérifier les tables trop volumineuses
            $largeTables = $tableStats->where('total_size_mb', '>', 100);
            if ($largeTables->isNotEmpty()) {
                $suggestions[] = [
                    'type' => 'large_tables',
                    'severity' => 'medium',
                    'title' => 'Tables volumineuses détectées',
                    'description' => 'Certaines tables sont très volumineuses et pourraient bénéficier d\'un partitionnement.',
                    'tables' => $largeTables->pluck('table_name')->toArray(),
                    'action' => 'Considérer le partitionnement ou l\'archivage des anciennes données'
                ];
            }
            
            // Vérifier les requêtes lentes
            if ($slowQueries->isNotEmpty()) {
                $suggestions[] = [
                    'type' => 'slow_queries',
                    'severity' => 'high',
                    'title' => 'Requêtes lentes détectées',
                    'description' => 'Des requêtes prennent plus d\'1 seconde à s\'exécuter.',
                    'count' => $slowQueries->count(),
                    'action' => 'Analyser et optimiser les requêtes, ajouter des index si nécessaire'
                ];
            }
            
            // Vérifier la fragmentation
            $fragmentedTables = $this->checkFragmentation();
            if ($fragmentedTables->isNotEmpty()) {
                $suggestions[] = [
                    'type' => 'fragmentation',
                    'severity' => 'low',
                    'title' => 'Fragmentation des tables',
                    'description' => 'Certaines tables sont fragmentées.',
                    'tables' => $fragmentedTables->toArray(),
                    'action' => 'Exécuter OPTIMIZE TABLE pour défragmenter'
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to generate optimization suggestions', ['error' => $e->getMessage()]);
        }

        return $suggestions;
    }

    /**
     * Vérifier la fragmentation des tables
     */
    protected function checkFragmentation(): Collection
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return collect([]);
        }

        try {
            $database = config('database.connections.mysql.database');
            
            $fragmented = DB::select("
                SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = ?
                AND data_free > 0
                AND (data_free / data_length) > 0.1
            ", [$database]);

            return collect($fragmented)->pluck('table_name');

        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Optimiser une table spécifique
     */
    public function optimizeTable(string $tableName): bool
    {
        try {
            // Vérifier que la table existe et est autorisée
            $allowedTables = [
                'itineraries', 'sorties', 'gpx_points', 'sortie_gpx_points',
                'itinerary_images', 'sortie_images', 'users', 'contacts',
                'blog_posts', 'ppg_exercises', 'ppg_programs'
            ];
            
            if (!in_array($tableName, $allowedTables)) {
                throw new \InvalidArgumentException("Table {$tableName} is not allowed for optimization");
            }

            DB::statement("OPTIMIZE TABLE {$tableName}");
            
            Log::info("Table {$tableName} optimized successfully");
            return true;

        } catch (\Exception $e) {
            Log::error("Failed to optimize table {$tableName}", ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Nettoyer les anciennes données
     */
    public function cleanupOldData(): array
    {
        $results = [];
        
        try {
            // Nettoyer les anciennes sessions (plus de 30 jours)
            $deletedSessions = DB::table('sessions')
                ->where('last_activity', '<', time() - (30 * 24 * 60 * 60))
                ->delete();
            
            if ($deletedSessions > 0) {
                $results[] = "Supprimé {$deletedSessions} anciennes sessions";
            }

            // Nettoyer les contacts traités très anciens (plus de 6 mois)
            $deletedContacts = DB::table('contacts')
                ->where('status', 'resolved')
                ->where('created_at', '<', now()->subMonths(6))
                ->delete();
            
            if ($deletedContacts > 0) {
                $results[] = "Supprimé {$deletedContacts} anciens contacts";
            }

            // Nettoyer les failed_jobs très anciens (plus de 3 mois)
            $deletedJobs = DB::table('failed_jobs')
                ->where('failed_at', '<', now()->subMonths(3))
                ->delete();
            
            if ($deletedJobs > 0) {
                $results[] = "Supprimé {$deletedJobs} anciens jobs échoués";
            }

            Log::info('Data cleanup completed', ['results' => $results]);

        } catch (\Exception $e) {
            Log::error('Data cleanup failed', ['error' => $e->getMessage()]);
            $results[] = 'Erreur lors du nettoyage: ' . $e->getMessage();
        }

        return $results;
    }

    /**
     * Nettoyer et anonymiser une requête pour les logs
     */
    protected function sanitizeQuery(?string $query): ?string
    {
        if (!$query) {
            return null;
        }

        // Remplacer les valeurs sensibles
        $patterns = [
            '/password\s*=\s*[\'"][^\'"]*[\'"]/i' => 'password = [HIDDEN]',
            '/token\s*=\s*[\'"][^\'"]*[\'"]/i' => 'token = [HIDDEN]',
            '/email\s*=\s*[\'"][^\'"]*[\'"]/i' => 'email = [HIDDEN]',
        ];

        foreach ($patterns as $pattern => $replacement) {
            $query = preg_replace($pattern, $replacement, $query);
        }

        // Tronquer si trop long
        return strlen($query) > 200 ? substr($query, 0, 200) . '...' : $query;
    }

    /**
     * Générer un rapport complet d'optimisation
     */
    public function generateOptimizationReport(): array
    {
        return [
            'generated_at' => now()->toISOString(),
            'table_stats' => $this->getTableStats(),
            'slow_queries' => $this->analyzeSlowQueries(),
            'index_analysis' => $this->analyzeIndexUsage(),
            'optimization_suggestions' => $this->suggestOptimizations(),
            'database_size' => $this->getDatabaseSize()
        ];
    }

    /**
     * Obtenir la taille totale de la base de données
     */
    protected function getDatabaseSize(): array
    {
        try {
            $database = config('database.connections.mysql.database');
            
            $size = DB::selectOne("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as total_size_mb,
                    ROUND(SUM(data_length) / 1024 / 1024, 2) as data_size_mb,
                    ROUND(SUM(index_length) / 1024 / 1024, 2) as index_size_mb
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [$database]);

            return [
                'total_size_mb' => $size->total_size_mb ?? 0,
                'data_size_mb' => $size->data_size_mb ?? 0,
                'index_size_mb' => $size->index_size_mb ?? 0
            ];

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}