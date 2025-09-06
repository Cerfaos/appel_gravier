<?php

namespace App\Http\Middleware;

use App\Services\TwoFactorAuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    protected $twoFactorService;

    public function __construct(TwoFactorAuthService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Gérer une requête entrante nécessitant la 2FA
     */
    public function handle(Request $request, Closure $next, string ...$options): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            return $this->redirectToLogin($request);
        }

        $user = auth()->user();
        
        // Analyser les options du middleware
        $enforce2FA = in_array('enforce', $options);
        $adminOnly = in_array('admin', $options);
        
        // Si admin_only est spécifié, appliquer seulement aux admins
        if ($adminOnly && !in_array($user->role ?? 'user', ['admin', 'super_admin'])) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a 2FA activé
        $has2FA = $user->google2fa_enabled ?? false;
        
        // Si enforce est spécifié et que 2FA n'est pas configuré
        if ($enforce2FA && !$has2FA) {
            return $this->redirectToSetup2FA($request, 'Two-factor authentication is required for this action');
        }

        // Si l'utilisateur a 2FA activé mais n'est pas vérifié dans cette session
        if ($has2FA && !$this->is2FAVerified($request)) {
            return $this->redirectTo2FAChallenge($request);
        }

        // Vérifier les tentatives de contournement
        $this->logAccessAttempt($request, $user);

        return $next($request);
    }

    /**
     * Vérifier si l'utilisateur a passé la vérification 2FA dans cette session
     */
    private function is2FAVerified(Request $request): bool
    {
        $sessionKey = '2fa_verified_' . auth()->id();
        $verified = session($sessionKey, false);
        
        // Vérifier l'expiration de la session 2FA (par défaut 30 minutes)
        $verifiedAt = session('2fa_verified_at');
        if ($verified && $verifiedAt) {
            $expiryMinutes = config('auth.2fa_session_timeout', 30);
            if (now()->diffInMinutes($verifiedAt) > $expiryMinutes) {
                $this->clear2FASession();
                return false;
            }
        }

        return $verified;
    }

    /**
     * Nettoyer la session 2FA
     */
    private function clear2FASession(): void
    {
        session()->forget([
            '2fa_verified_' . auth()->id(),
            '2fa_verified_at',
            '2fa_attempts'
        ]);
    }

    /**
     * Rediriger vers la page de connexion
     */
    private function redirectToLogin(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Unauthenticated',
                'message' => 'Authentication required',
                'redirect' => route('login')
            ], 401);
        }
        
        return redirect()->guest(route('login'));
    }

    /**
     * Rediriger vers la configuration 2FA
     */
    private function redirectToSetup2FA(Request $request, string $message = null): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Two-Factor Authentication Required',
                'message' => $message ?? 'Two-factor authentication must be configured',
                'redirect' => route('2fa.setup')
            ], 403);
        }
        
        return redirect()->route('2fa.setup')
            ->with('message', $message ?? 'Two-factor authentication is required for this action');
    }

    /**
     * Rediriger vers le challenge 2FA
     */
    private function redirectTo2FAChallenge(Request $request): Response
    {
        $user = auth()->user();
        
        // Vérifier les tentatives échouées récentes
        $attempts = session('2fa_attempts', 0);
        $maxAttempts = config('auth.2fa_max_attempts', 3);
        
        if ($attempts >= $maxAttempts) {
            Log::warning('2FA max attempts exceeded', [
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            // Bloquer temporairement l'utilisateur
            session(['2fa_blocked_until' => now()->addMinutes(15)]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Too Many Attempts',
                    'message' => 'Too many failed 2FA attempts. Try again in 15 minutes.',
                    'blocked_until' => now()->addMinutes(15)->toISOString()
                ], 429);
            }
            
            return redirect()->route('login')
                ->with('error', 'Too many failed 2FA attempts. Try again in 15 minutes.');
        }
        
        // Vérifier si l'utilisateur est temporairement bloqué
        $blockedUntil = session('2fa_blocked_until');
        if ($blockedUntil && now()->lt($blockedUntil)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Temporarily Blocked',
                    'message' => 'Account temporarily blocked due to failed 2FA attempts',
                    'blocked_until' => $blockedUntil->toISOString()
                ], 429);
            }
            
            return redirect()->route('login')
                ->with('error', 'Account temporarily blocked due to failed 2FA attempts');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Two-Factor Authentication Required',
                'message' => 'Please provide your 2FA code to continue',
                'redirect' => route('2fa.challenge')
            ], 403);
        }
        
        // Stocker l'URL intentionnelle pour redirection après 2FA
        session(['url.intended' => $request->fullUrl()]);
        
        return redirect()->route('2fa.challenge');
    }

    /**
     * Logger les tentatives d'accès pour audit
     */
    private function logAccessAttempt(Request $request, $user): void
    {
        // Logger seulement les accès aux routes sensibles
        $sensitiveRoutes = [
            'admin*',
            'api/v1/admin*',
            'profile/security*',
            '2fa*'
        ];
        
        $isSensitive = false;
        foreach ($sensitiveRoutes as $pattern) {
            if ($request->is($pattern)) {
                $isSensitive = true;
                break;
            }
        }
        
        if ($isSensitive) {
            Log::info('2FA protected route accessed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'route' => $request->route()?->getName(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                '2fa_verified' => $this->is2FAVerified($request)
            ]);
        }
    }
}