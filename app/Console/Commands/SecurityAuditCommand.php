<?php

namespace App\Console\Commands;

use App\Services\SecurityService;
use App\Services\TwoFactorAuthService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class SecurityAuditCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'security:audit 
                           {--users : Audit user accounts and permissions}
                           {--access : Audit access logs and patterns}
                           {--vulnerabilities : Scan for common vulnerabilities}
                           {--passwords : Check password strength and policies}
                           {--permissions : Audit file and directory permissions}
                           {--fix : Automatically fix detected issues}';

    /**
     * The console command description.
     */
    protected $description = 'Comprehensive security audit and vulnerability assessment';

    protected $securityService;
    protected $twoFactorService;

    public function __construct(SecurityService $securityService, TwoFactorAuthService $twoFactorService)
    {
        parent::__construct();
        $this->securityService = $securityService;
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔒 Security Audit & Vulnerability Assessment');
        $startTime = microtime(true);

        try {
            $users = $this->option('users');
            $access = $this->option('access');
            $vulnerabilities = $this->option('vulnerabilities');
            $passwords = $this->option('passwords');
            $permissions = $this->option('permissions');
            $fix = $this->option('fix');

            // Si aucune option spécifique, tout auditer
            if (!$users && !$access && !$vulnerabilities && !$passwords && !$permissions) {
                $users = $access = $vulnerabilities = $passwords = $permissions = true;
            }

            $issues = [];

            // 1. Audit des comptes utilisateur
            if ($users) {
                $userIssues = $this->auditUserAccounts($fix);
                $issues = array_merge($issues, $userIssues);
            }

            // 2. Audit des logs d'accès
            if ($access) {
                $accessIssues = $this->auditAccessPatterns();
                $issues = array_merge($issues, $accessIssues);
            }

            // 3. Scan des vulnérabilités
            if ($vulnerabilities) {
                $vulnIssues = $this->scanVulnerabilities($fix);
                $issues = array_merge($issues, $vulnIssues);
            }

            // 4. Audit des mots de passe
            if ($passwords) {
                $passwordIssues = $this->auditPasswords();
                $issues = array_merge($issues, $passwordIssues);
            }

            // 5. Audit des permissions
            if ($permissions) {
                $permIssues = $this->auditFilePermissions($fix);
                $issues = array_merge($issues, $permIssues);
            }

            // Rapport final
            $this->generateSecurityReport($issues);

            $executionTime = round(microtime(true) - $startTime, 2);
            $this->info("✅ Security audit completed in {$executionTime}s");

            return empty($issues) ? self::SUCCESS : self::FAILURE;

        } catch (\Exception $e) {
            $this->error("❌ Security audit failed: " . $e->getMessage());
            Log::error('Security audit command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return self::FAILURE;
        }
    }

    /**
     * Auditer les comptes utilisateur
     */
    private function auditUserAccounts(bool $fix): array
    {
        $this->info('👤 Auditing user accounts...');
        $issues = [];

        try {
            // Utilisateurs avec des privilèges élevés
            $adminUsers = DB::table('users')->where('role', 'admin')->get();
            $this->line("Found {$adminUsers->count()} admin users");

            // Comptes inactifs avec privilèges
            $inactiveAdmins = DB::table('users')
                ->where('role', 'admin')
                ->where('updated_at', '<', now()->subMonths(3))
                ->get();

            if ($inactiveAdmins->count() > 0) {
                $issues[] = [
                    'severity' => 'medium',
                    'type' => 'inactive_admin',
                    'description' => "Found {$inactiveAdmins->count()} inactive admin accounts",
                    'details' => $inactiveAdmins->pluck('email')->toArray()
                ];
            }

            // Utilisateurs sans 2FA
            $usersWithout2FA = DB::table('users')
                ->where('role', 'admin')
                ->where('google2fa_enabled', false)
                ->get();

            if ($usersWithout2FA->count() > 0) {
                $issues[] = [
                    'severity' => 'high',
                    'type' => 'no_2fa',
                    'description' => "Found {$usersWithout2FA->count()} admin users without 2FA",
                    'details' => $usersWithout2FA->pluck('email')->toArray()
                ];
            }

            // Comptes avec échecs de connexion répétés
            $suspiciousUsers = DB::table('users')
                ->where('failed_login_attempts', '>', 5)
                ->get();

            if ($suspiciousUsers->count() > 0) {
                $issues[] = [
                    'severity' => 'medium',
                    'type' => 'failed_logins',
                    'description' => "Found {$suspiciousUsers->count()} users with high failed login attempts",
                    'details' => $suspiciousUsers->pluck('email')->toArray()
                ];

                if ($fix) {
                    DB::table('users')->where('failed_login_attempts', '>', 10)
                        ->update(['locked_until' => now()->addHour()]);
                    $this->line('  ✅ Locked accounts with excessive failed attempts');
                }
            }

        } catch (\Exception $e) {
            $this->warn("User account audit failed: " . $e->getMessage());
        }

        return $issues;
    }

    /**
     * Auditer les patterns d'accès
     */
    private function auditAccessPatterns(): array
    {
        $this->info('🔍 Auditing access patterns...');
        $issues = [];

        try {
            // Récupérer les statistiques de sécurité
            $securityStats = $this->securityService->getSecurityStats();

            // IPs bloquées
            if ($securityStats['blocked_ips'] > 10) {
                $issues[] = [
                    'severity' => 'medium',
                    'type' => 'blocked_ips',
                    'description' => "High number of blocked IPs: {$securityStats['blocked_ips']}",
                    'details' => []
                ];
            }

            // Activités suspectes
            if ($securityStats['suspicious_activities'] > 50) {
                $issues[] = [
                    'severity' => 'high',
                    'type' => 'suspicious_activity',
                    'description' => "High suspicious activity count: {$securityStats['suspicious_activities']}",
                    'details' => []
                ];
            }

            // Connexions admin en dehors des heures ouvrables
            $afterHoursLogins = DB::table('sessions')
                ->join('users', 'sessions.user_id', '=', 'users.id')
                ->where('users.role', 'admin')
                ->whereRaw('HOUR(FROM_UNIXTIME(last_activity)) NOT BETWEEN 8 AND 18')
                ->where('last_activity', '>', now()->subWeek()->timestamp)
                ->count();

            if ($afterHoursLogins > 0) {
                $issues[] = [
                    'severity' => 'low',
                    'type' => 'after_hours_admin',
                    'description' => "Admin logins outside business hours: {$afterHoursLogins}",
                    'details' => []
                ];
            }

        } catch (\Exception $e) {
            $this->warn("Access pattern audit failed: " . $e->getMessage());
        }

        return $issues;
    }

    /**
     * Scanner les vulnérabilités communes
     */
    private function scanVulnerabilities(bool $fix): array
    {
        $this->info('🛡️ Scanning for vulnerabilities...');
        $issues = [];

        try {
            // Vérifier la configuration de sécurité
            if (config('app.debug') && config('app.env') === 'production') {
                $issues[] = [
                    'severity' => 'critical',
                    'type' => 'debug_enabled',
                    'description' => 'Debug mode enabled in production',
                    'details' => []
                ];
            }

            // Vérifier les clés de chiffrement
            if (config('app.key') === 'base64:' . base64_encode(str_repeat('a', 32))) {
                $issues[] = [
                    'severity' => 'critical',
                    'type' => 'default_key',
                    'description' => 'Using default application key',
                    'details' => []
                ];
            }

            // Vérifier les variables d'environnement sensibles
            $sensitiveVars = ['APP_KEY', 'DB_PASSWORD', 'REDIS_PASSWORD'];
            foreach ($sensitiveVars as $var) {
                if (empty(env($var))) {
                    $issues[] = [
                        'severity' => 'medium',
                        'type' => 'missing_env_var',
                        'description' => "Sensitive environment variable not set: {$var}",
                        'details' => []
                    ];
                }
            }

            // Vérifier les en-têtes de sécurité
            $requiredHeaders = [
                'X-Content-Type-Options',
                'X-Frame-Options',
                'X-XSS-Protection'
            ];

            // Cette vérification nécessiterait un appel HTTP, simplifié ici
            $this->line('  • Security headers check would require HTTP testing');

        } catch (\Exception $e) {
            $this->warn("Vulnerability scan failed: " . $e->getMessage());
        }

        return $issues;
    }

    /**
     * Auditer la politique des mots de passe
     */
    private function auditPasswords(): array
    {
        $this->info('🔐 Auditing password policies...');
        $issues = [];

        try {
            // Utilisateurs avec des mots de passe faibles (simulation)
            $weakPasswords = 0;
            
            // Dans un vrai audit, on vérifierait contre des dictionnaires
            // ou des patterns communs
            $this->line('  • Password strength analysis would require hash comparison');

            // Vérifier les mots de passe non changés depuis longtemps
            $oldPasswords = DB::table('users')
                ->whereNull('password_changed_at')
                ->orWhere('password_changed_at', '<', now()->subMonths(6))
                ->count();

            if ($oldPasswords > 0) {
                $issues[] = [
                    'severity' => 'medium',
                    'type' => 'old_passwords',
                    'description' => "Users with passwords older than 6 months: {$oldPasswords}",
                    'details' => []
                ];
            }

        } catch (\Exception $e) {
            $this->warn("Password audit failed: " . $e->getMessage());
        }

        return $issues;
    }

    /**
     * Auditer les permissions de fichiers
     */
    private function auditFilePermissions(bool $fix): array
    {
        $this->info('📁 Auditing file permissions...');
        $issues = [];

        try {
            $criticalPaths = [
                '.env' => 0600,
                'storage/' => 0755,
                'bootstrap/cache/' => 0755,
                'config/' => 0644,
            ];

            foreach ($criticalPaths as $path => $expectedPerm) {
                $fullPath = base_path($path);
                
                if (file_exists($fullPath)) {
                    $currentPerm = fileperms($fullPath) & 0777;
                    
                    if ($currentPerm !== $expectedPerm) {
                        $issues[] = [
                            'severity' => 'medium',
                            'type' => 'file_permissions',
                            'description' => "Incorrect permissions on {$path}",
                            'details' => [
                                'path' => $path,
                                'current' => decoct($currentPerm),
                                'expected' => decoct($expectedPerm)
                            ]
                        ];

                        if ($fix) {
                            chmod($fullPath, $expectedPerm);
                            $this->line("  ✅ Fixed permissions for {$path}");
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            $this->warn("File permissions audit failed: " . $e->getMessage());
        }

        return $issues;
    }

    /**
     * Générer le rapport de sécurité final
     */
    private function generateSecurityReport(array $issues): void
    {
        $this->info('📋 Security Audit Report');

        if (empty($issues)) {
            $this->info('✅ No security issues detected!');
            return;
        }

        $critical = collect($issues)->where('severity', 'critical');
        $high = collect($issues)->where('severity', 'high');
        $medium = collect($issues)->where('severity', 'medium');
        $low = collect($issues)->where('severity', 'low');

        $this->table(
            ['Severity', 'Count'],
            [
                ['Critical', $critical->count()],
                ['High', $high->count()],
                ['Medium', $medium->count()],
                ['Low', $low->count()],
                ['Total', count($issues)],
            ]
        );

        // Détail des problèmes critiques et élevés
        foreach ($critical->merge($high) as $issue) {
            $severity = strtoupper($issue['severity']);
            $this->warn("⚠️ [{$severity}] {$issue['description']}");
            
            if (!empty($issue['details'])) {
                foreach ((array) $issue['details'] as $detail) {
                    $this->line("    • " . (is_array($detail) ? json_encode($detail) : $detail));
                }
            }
        }

        // Log du rapport complet
        Log::warning('Security audit completed', [
            'total_issues' => count($issues),
            'critical' => $critical->count(),
            'high' => $high->count(),
            'medium' => $medium->count(),
            'low' => $low->count(),
            'issues' => $issues
        ]);
    }
}