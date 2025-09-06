<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class SecurityService
{
    /**
     * Patterns suspects à détecter dans les requêtes
     */
    protected $suspiciousPatterns = [
        'sql_injection' => [
            '/union\s+select/i',
            '/drop\s+table/i',
            '/insert\s+into/i',
            '/update\s+set/i',
            '/delete\s+from/i',
            '/script\s*>/i',
            '/<\s*script/i',
        ],
        'xss' => [
            '/<script[^>]*>.*?<\/script>/is',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe/i',
            '/<object/i',
            '/<embed/i',
        ],
        'path_traversal' => [
            '/\.\.\//',
            '/\.\.\\\\/',
            '/etc\/passwd/i',
            '/windows\/system32/i',
        ],
        'command_injection' => [
            '/;\s*(ls|cat|wget|curl|nc|netcat)/i',
            '/\|\s*(ls|cat|wget|curl|nc|netcat)/i',
            '/&&\s*(ls|cat|wget|curl|nc|netcat)/i',
        ]
    ];

    /**
     * User agents suspects
     */
    protected $suspiciousUserAgents = [
        'sqlmap',
        'nikto',
        'nmap',
        'masscan',
        'gobuster',
        'dirb',
        'wfuzz',
        'burpsuite',
        'nessus',
        'acunetix'
    ];

    /**
     * Analyser une requête pour des activités suspectes
     */
    public function analyzeSuspiciousActivity(Request $request): array
    {
        $threats = [];
        $ip = $this->getClientIp($request);

        // Vérifier les patterns suspects dans tous les paramètres
        $allInput = array_merge(
            $request->all(),
            $request->headers->all(),
            [$request->getRequestUri()]
        );

        foreach ($this->suspiciousPatterns as $threatType => $patterns) {
            if ($this->detectPatternsInInput($allInput, $patterns)) {
                $threats[] = $threatType;
                
                Log::warning("Suspicious activity detected: {$threatType}", [
                    'ip' => $ip,
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'input' => $this->sanitizeLogInput($request->all())
                ]);
            }
        }

        // Vérifier l'user agent suspect
        if ($this->isSuspiciousUserAgent($request->userAgent())) {
            $threats[] = 'suspicious_user_agent';
            
            Log::warning('Suspicious user agent detected', [
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl()
            ]);
        }

        // Vérifier les tentatives de brute force
        if ($this->detectBruteForceAttempt($request)) {
            $threats[] = 'brute_force_attempt';
        }

        // Enregistrer l'activité suspecte si détectée
        if (!empty($threats)) {
            $this->recordSuspiciousActivity($ip, $threats);
        }

        return $threats;
    }

    /**
     * Détecter les patterns suspects dans l'input
     */
    protected function detectPatternsInInput(array $input, array $patterns): bool
    {
        $inputString = json_encode($input);
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $inputString)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Vérifier si l'user agent est suspect
     */
    protected function isSuspiciousUserAgent(?string $userAgent): bool
    {
        if (!$userAgent) {
            return true; // User agent vide est suspect
        }

        $userAgent = strtolower($userAgent);
        
        foreach ($this->suspiciousUserAgents as $suspicious) {
            if (str_contains($userAgent, $suspicious)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Détecter les tentatives de brute force
     */
    protected function detectBruteForceAttempt(Request $request): bool
    {
        $ip = $this->getClientIp($request);
        
        // Vérifier si c'est une tentative de login
        if (!str_contains($request->path(), 'login') && !str_contains($request->path(), 'password')) {
            return false;
        }

        $key = "login_attempts:{$ip}";
        $attempts = Cache::get($key, 0);
        
        // Plus de 10 tentatives en 15 minutes = brute force
        if ($attempts > 10) {
            Log::alert('Brute force attempt detected', [
                'ip' => $ip,
                'attempts' => $attempts,
                'user_agent' => $request->userAgent()
            ]);
            return true;
        }
        
        return false;
    }

    /**
     * Enregistrer l'activité suspecte
     */
    protected function recordSuspiciousActivity(string $ip, array $threats): void
    {
        $key = "suspicious_activity:{$ip}";
        $activity = Cache::get($key, []);
        
        $activity[] = [
            'threats' => $threats,
            'timestamp' => time(),
            'severity' => $this->calculateThreatSeverity($threats)
        ];
        
        // Garder seulement les 50 dernières activités
        $activity = array_slice($activity, -50);
        
        Cache::put($key, $activity, 86400 * 7); // 7 jours
        
        // Auto-blocage si activité très suspecte
        if ($this->shouldAutoBlock($activity)) {
            $this->autoBlockIp($ip, $threats);
        }
    }

    /**
     * Calculer la sévérité des menaces
     */
    protected function calculateThreatSeverity(array $threats): int
    {
        $severity = 0;
        $weights = [
            'sql_injection' => 10,
            'xss' => 8,
            'command_injection' => 10,
            'path_traversal' => 9,
            'brute_force_attempt' => 7,
            'suspicious_user_agent' => 5
        ];

        foreach ($threats as $threat) {
            $severity += $weights[$threat] ?? 1;
        }

        return $severity;
    }

    /**
     * Déterminer si une IP doit être auto-bloquée
     */
    protected function shouldAutoBlock(array $activity): bool
    {
        $recentActivity = array_filter($activity, function($item) {
            return $item['timestamp'] > (time() - 3600); // Dernière heure
        });

        // Bloquer si plus de 5 activités suspectes en 1h
        if (count($recentActivity) > 5) {
            return true;
        }

        // Bloquer si sévérité totale > 50 en 1h
        $totalSeverity = array_sum(array_column($recentActivity, 'severity'));
        if ($totalSeverity > 50) {
            return true;
        }

        return false;
    }

    /**
     * Bloquer automatiquement une IP
     */
    protected function autoBlockIp(string $ip, array $threats): void
    {
        // Bloquer pour 24h
        Cache::put("blocked_ip:{$ip}", [
            'reason' => 'Automatic block due to suspicious activity',
            'threats' => $threats,
            'blocked_at' => time()
        ], 86400);

        Log::alert('IP automatically blocked due to suspicious activity', [
            'ip' => $ip,
            'threats' => $threats,
            'duration' => '24h'
        ]);

        // Notifier l'admin (optionnel)
        $this->notifyAdminOfBlock($ip, $threats);
    }

    /**
     * Notifier l'admin d'un blocage automatique
     */
    protected function notifyAdminOfBlock(string $ip, array $threats): void
    {
        // Implémenter notification Slack, email, etc.
        // Pour l'instant, juste un log critique
        Log::critical('SECURITY ALERT: IP auto-blocked', [
            'ip' => $ip,
            'threats' => $threats,
            'action_required' => 'Review security logs and consider permanent block'
        ]);
    }

    /**
     * Obtenir l'IP réelle du client
     */
    protected function getClientIp(Request $request): string
    {
        $headers = [
            'CF-Connecting-IP',
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            $ip = $request->server($header) ?? $request->header($header);
            if ($ip) {
                $ip = explode(',', $ip)[0];
                $ip = trim($ip);
                
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    /**
     * Nettoyer l'input pour les logs (éviter de logger des données sensibles)
     */
    protected function sanitizeLogInput(array $input): array
    {
        $sensitive = ['password', 'password_confirmation', 'token', 'secret', '_token'];
        
        foreach ($sensitive as $field) {
            if (isset($input[$field])) {
                $input[$field] = '[REDACTED]';
            }
        }
        
        return $input;
    }

    /**
     * Obtenir les statistiques de sécurité
     */
    public function getSecurityStats(): array
    {
        $redis = app('redis');
        
        $blockedIps = collect($redis->keys('blocked_ip:*'))->count();
        $suspiciousActivities = collect($redis->keys('suspicious_activity:*'))->count();
        $recentViolations = collect($redis->keys('violations:*:*'))->count();
        
        return [
            'blocked_ips' => $blockedIps,
            'suspicious_activities' => $suspiciousActivities,
            'recent_violations' => $recentViolations,
            'security_level' => $this->calculateSecurityLevel($blockedIps, $suspiciousActivities)
        ];
    }

    /**
     * Calculer le niveau de sécurité global
     */
    protected function calculateSecurityLevel(int $blockedIps, int $suspiciousActivities): string
    {
        $score = $blockedIps + ($suspiciousActivities * 2);
        
        if ($score > 50) return 'HIGH_RISK';
        if ($score > 20) return 'MEDIUM_RISK';
        if ($score > 5) return 'LOW_RISK';
        
        return 'SECURE';
    }
}