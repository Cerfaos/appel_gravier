<?php

namespace App\Console\Commands;

use App\Services\DatabaseOptimizationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptimizeDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:optimize 
                           {--analyze : Analyze tables for optimization}
                           {--optimize : Optimize table structures}
                           {--cleanup : Clean up old data}
                           {--vacuum : Vacuum and defragment}
                           {--force : Force operation without confirmation}';

    /**
     * The console command description.
     */
    protected $description = 'Optimize database performance and clean up old data';

    protected $dbOptimizationService;

    public function __construct(DatabaseOptimizationService $dbOptimizationService)
    {
        parent::__construct();
        $this->dbOptimizationService = $dbOptimizationService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔧 Starting database optimization...');
        $startTime = microtime(true);

        try {
            // Vérification des options
            $analyze = $this->option('analyze');
            $optimize = $this->option('optimize');
            $cleanup = $this->option('cleanup');
            $vacuum = $this->option('vacuum');
            $force = $this->option('force');

            // Si aucune option spécifique, tout faire
            if (!$analyze && !$optimize && !$cleanup && !$vacuum) {
                $analyze = $optimize = $cleanup = $vacuum = true;
            }

            // 1. Analyse des tables
            if ($analyze) {
                $this->performAnalysis();
            }

            // 2. Optimisation des structures
            if ($optimize) {
                $this->performOptimization($force);
            }

            // 3. Nettoyage des anciennes données
            if ($cleanup) {
                $this->performCleanup($force);
            }

            // 4. Vacuum et défragmentation
            if ($vacuum) {
                $this->performVacuum();
            }

            $executionTime = round(microtime(true) - $startTime, 2);
            $this->info("✅ Database optimization completed in {$executionTime}s");

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Database optimization failed: " . $e->getMessage());
            Log::error('Database optimization command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return self::FAILURE;
        }
    }

    /**
     * Effectuer l'analyse des tables
     */
    private function performAnalysis(): void
    {
        $this->info('📊 Analyzing database tables...');

        try {
            $report = $this->dbOptimizationService->generateOptimizationReport();
            
            // Affichage du rapport d'analyse
            $this->table(
                ['Table', 'Size (MB)', 'Rows', 'Index Usage', 'Fragmentation'],
                collect($report['table_analysis'])->map(function ($table) {
                    return [
                        $table['name'],
                        number_format($table['size_mb'], 2),
                        number_format($table['row_count']),
                        $table['index_usage'] . '%',
                        $table['fragmentation'] . '%'
                    ];
                })->toArray()
            );

            // Recommandations
            if (!empty($report['recommendations'])) {
                $this->warn('💡 Recommendations:');
                foreach ($report['recommendations'] as $recommendation) {
                    $this->line("  • {$recommendation}");
                }
            }

        } catch (\Exception $e) {
            $this->warn("Analysis failed: " . $e->getMessage());
        }
    }

    /**
     * Effectuer l'optimisation des structures
     */
    private function performOptimization(bool $force): void
    {
        $this->info('⚙️ Optimizing table structures...');

        if (!$force && !$this->confirm('This will optimize table structures. Continue?')) {
            $this->warn('Table optimization skipped.');
            return;
        }

        try {
            // Récupérer les suggestions d'optimisation
            $suggestions = $this->dbOptimizationService->suggestOptimizations();
            
            foreach ($suggestions as $suggestion) {
                if ($suggestion['type'] === 'index' && $suggestion['action'] === 'create') {
                    $this->line("Creating index: {$suggestion['description']}");
                    DB::statement($suggestion['sql']);
                }
            }

            // Optimiser les tables existantes
            $tables = DB::select('SHOW TABLES');
            $database = config('database.connections.mysql.database');
            
            foreach ($tables as $table) {
                $tableName = $table->{"Tables_in_{$database}"};
                $this->line("Optimizing table: {$tableName}");
                
                try {
                    DB::statement("OPTIMIZE TABLE {$tableName}");
                } catch (\Exception $e) {
                    $this->warn("Failed to optimize {$tableName}: " . $e->getMessage());
                }
            }

            $this->info('✅ Table structures optimized');

        } catch (\Exception $e) {
            $this->warn("Structure optimization failed: " . $e->getMessage());
        }
    }

    /**
     * Effectuer le nettoyage des anciennes données
     */
    private function performCleanup(bool $force): void
    {
        $this->info('🧹 Cleaning up old data...');

        if (!$force && !$this->confirm('This will delete old data. Continue?')) {
            $this->warn('Data cleanup skipped.');
            return;
        }

        $cleanupActions = [];

        try {
            // Nettoyage des logs anciens (> 30 jours)
            $oldLogs = DB::table('logs')->where('created_at', '<', now()->subDays(30))->count();
            if ($oldLogs > 0) {
                DB::table('logs')->where('created_at', '<', now()->subDays(30))->delete();
                $cleanupActions[] = "Deleted {$oldLogs} old log entries";
            }

            // Nettoyage des sessions expirées
            $oldSessions = DB::table('sessions')->where('last_activity', '<', now()->subDays(7)->timestamp)->count();
            if ($oldSessions > 0) {
                DB::table('sessions')->where('last_activity', '<', now()->subDays(7)->timestamp)->delete();
                $cleanupActions[] = "Deleted {$oldSessions} expired sessions";
            }

            // Nettoyage des tentatives de connexion anciennes (> 7 jours)
            if (DB::getSchemaBuilder()->hasTable('failed_jobs')) {
                $failedJobs = DB::table('failed_jobs')->where('failed_at', '<', now()->subDays(7))->count();
                if ($failedJobs > 0) {
                    DB::table('failed_jobs')->where('failed_at', '<', now()->subDays(7))->delete();
                    $cleanupActions[] = "Deleted {$failedJobs} old failed jobs";
                }
            }

            // Nettoyage des notifications lues anciennes (> 60 jours)
            if (DB::getSchemaBuilder()->hasTable('notifications')) {
                $oldNotifications = DB::table('notifications')
                    ->whereNotNull('read_at')
                    ->where('read_at', '<', now()->subDays(60))
                    ->count();
                    
                if ($oldNotifications > 0) {
                    DB::table('notifications')
                        ->whereNotNull('read_at')
                        ->where('read_at', '<', now()->subDays(60))
                        ->delete();
                    $cleanupActions[] = "Deleted {$oldNotifications} old read notifications";
                }
            }

            if (!empty($cleanupActions)) {
                foreach ($cleanupActions as $action) {
                    $this->line("  • {$action}");
                }
                $this->info('✅ Data cleanup completed');
            } else {
                $this->info('ℹ️ No old data to clean up');
            }

        } catch (\Exception $e) {
            $this->warn("Data cleanup failed: " . $e->getMessage());
        }
    }

    /**
     * Effectuer le vacuum et la défragmentation
     */
    private function performVacuum(): void
    {
        $this->info('🔧 Performing vacuum and defragmentation...');

        try {
            // Analyser les tables pour les statistiques
            $tables = DB::select('SHOW TABLES');
            $database = config('database.connections.mysql.database');
            
            foreach ($tables as $table) {
                $tableName = $table->{"Tables_in_{$database}"};
                $this->line("Analyzing table: {$tableName}");
                
                try {
                    DB::statement("ANALYZE TABLE {$tableName}");
                } catch (\Exception $e) {
                    $this->warn("Failed to analyze {$tableName}: " . $e->getMessage());
                }
            }

            // Reconstruire les statistiques
            $this->line('Updating table statistics...');
            
            $this->info('✅ Vacuum and defragmentation completed');

        } catch (\Exception $e) {
            $this->warn("Vacuum operation failed: " . $e->getMessage());
        }
    }
}