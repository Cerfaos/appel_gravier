<?php

namespace App\Http\Middleware;

use App\Services\SecurityService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    protected $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * Gérer une requête entrante avec vérifications de sécurité avancées
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $this->getClientIP($request);
        
        // 1. Vérifier si l'IP est bloquée
        if ($this->securityService->isIPBlocked($clientIp)) {
            Log::warning('Blocked IP attempted access', [
                'ip' => $clientIp,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent()
            ]);
            
            return $this->blockResponse($request, 'IP address blocked due to suspicious activity');
        }

        // 2. Analyser la requête pour des menaces de sécurité
        $threats = $this->securityService->analyzeRequest($request);
        
        if (!empty($threats)) {
            Log::warning('Security threats detected', [
                'ip' => $clientIp,
                'threats' => $threats,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'payload' => $request->except(['password', 'token'])
            ]);
            
            // Bloquer l'IP pour des menaces graves
            $severityLevel = $this->calculateThreatSeverity($threats);
            if ($severityLevel >= 3) {
                $this->securityService->blockIP($clientIp, 3600, 'High severity threats detected');
                return $this->blockResponse($request, 'Request blocked due to security concerns');
            }
        }

        // 3. Vérifications spécifiques pour les routes administratives
        if ($request->is('admin*') || $request->is('api/v1/admin*')) {
            if (!$this->validateAdminAccess($request)) {
                return $this->blockResponse($request, 'Invalid admin access attempt');
            }
        }

        // 4. Validation des en-têtes de sécurité
        $this->validateSecurityHeaders($request);

        $response = $next($request);

        // 5. Ajouter des en-têtes de sécurité à la réponse
        return $this->addSecurityHeaders($response);
    }

    /**
     * Obtenir l'adresse IP réelle du client
     */
    private function getClientIP(Request $request): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    /**
     * Calculer le niveau de sévérité des menaces
     */
    private function calculateThreatSeverity(array $threats): int
    {
        $severity = 0;
        $severityMap = [
            'sql_injection' => 5,
            'xss' => 4,
            'path_traversal' => 3,
            'command_injection' => 5,
            'suspicious_patterns' => 2,
            'malicious_file_upload' => 4,
            'csrf_attempt' => 3
        ];

        foreach ($threats as $threat) {
            $severity += $severityMap[$threat['type']] ?? 1;
        }

        return $severity;
    }

    /**
     * Valider l'accès administratif
     */
    private function validateAdminAccess(Request $request): bool
    {
        // Vérification de base de l'authentification
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        // Vérification du rôle admin
        if (!in_array($user->role ?? 'user', ['admin', 'super_admin'])) {
            return false;
        }

        // Vérification 2FA pour les accès admin
        if ($user->google2fa_enabled && !session('2fa_verified')) {
            return false;
        }

        return true;
    }

    /**
     * Valider les en-têtes de sécurité de la requête
     */
    private function validateSecurityHeaders(Request $request): void
    {
        // Validation des en-têtes potentiellement dangereux
        $dangerousHeaders = [
            'X-Forwarded-Host',
            'X-Original-URL',
            'X-Rewrite-URL'
        ];

        foreach ($dangerousHeaders as $header) {
            if ($request->hasHeader($header)) {
                Log::warning('Suspicious header detected', [
                    'header' => $header,
                    'value' => $request->header($header),
                    'ip' => $this->getClientIP($request)
                ]);
            }
        }
    }

    /**
     * Ajouter des en-têtes de sécurité à la réponse
     */
    private function addSecurityHeaders(Response $response): Response
    {
        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' fonts.googleapis.com; font-src 'self' fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self'",
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(self)'
        ];

        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }

    /**
     * Générer une réponse de blocage
     */
    private function blockResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Security Violation',
                'message' => $message,
                'timestamp' => now()->toISOString()
            ], 403);
        }

        return response()->view('errors.403', [
            'message' => $message
        ], 403);
    }
}