<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TwoFactorAuthService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    protected $twoFactorService;

    public function __construct(TwoFactorAuthService $twoFactorService)
    {
        $this->middleware('auth');
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Afficher la page de configuration 2FA
     */
    public function show(): View
    {
        $user = auth()->user();
        
        return view('auth.two-factor', [
            'user' => $user,
            'is_enabled' => $user->google2fa_enabled,
            'recovery_codes_count' => $user->recovery_codes ? count($user->recovery_codes) : 0
        ]);
    }

    /**
     * Préparer l'activation du 2FA (génération QR Code)
     */
    public function prepare(): RedirectResponse|View
    {
        $user = auth()->user();
        
        if ($user->google2fa_enabled) {
            return redirect()->route('two-factor.show')
                ->with('error', 'L\'authentification à deux facteurs est déjà activée.');
        }

        $setup = $this->twoFactorService->prepareActivation($user);
        
        return view('auth.two-factor-setup', [
            'secret' => $setup['secret'],
            'qr_code_url' => $setup['qr_code_url']
        ]);
    }

    /**
     * Activer le 2FA
     */
    public function enable(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ], [
            'code.required' => 'Le code de vérification est obligatoire.',
            'code.size' => 'Le code doit contenir exactement 6 chiffres.',
        ]);

        $user = auth()->user();
        
        if ($user->google2fa_enabled) {
            return redirect()->route('two-factor.show')
                ->with('error', 'L\'authentification à deux facteurs est déjà activée.');
        }

        if ($this->twoFactorService->enable($user, $request->code)) {
            $recoveryCodes = collect($user->fresh()->recovery_codes)
                ->map(fn($encrypted) => \Crypt::decryptString($encrypted));
            
            return redirect()->route('two-factor.show')
                ->with('success', 'Authentification à deux facteurs activée avec succès !')
                ->with('recovery_codes', $recoveryCodes);
        }

        return back()
            ->withErrors(['code' => 'Code de vérification invalide.'])
            ->withInput();
    }

    /**
     * Désactiver le 2FA
     */
    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Votre mot de passe est requis pour désactiver le 2FA.',
        ]);

        $user = auth()->user();
        
        if (!$user->google2fa_enabled) {
            return redirect()->route('two-factor.show')
                ->with('error', 'L\'authentification à deux facteurs n\'est pas activée.');
        }

        if ($this->twoFactorService->disable($user, $request->password)) {
            return redirect()->route('two-factor.show')
                ->with('success', 'Authentification à deux facteurs désactivée.');
        }

        return back()
            ->withErrors(['password' => 'Mot de passe incorrect.']);
    }

    /**
     * Régénérer les codes de récupération
     */
    public function regenerateRecoveryCodes(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = auth()->user();
        
        if (!$user->google2fa_enabled) {
            return redirect()->route('two-factor.show')
                ->with('error', 'L\'authentification à deux facteurs n\'est pas activée.');
        }

        $recoveryCodes = $this->twoFactorService->regenerateRecoveryCodes($user, $request->password);
        
        if ($recoveryCodes === false) {
            return back()
                ->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        return redirect()->route('two-factor.show')
            ->with('success', 'Codes de récupération régénérés avec succès.')
            ->with('recovery_codes', $recoveryCodes);
    }

    /**
     * Afficher le challenge 2FA lors de la connexion
     */
    public function challenge(): View
    {
        if (!session('login.id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Vérifier le code 2FA lors du challenge
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $userId = session('login.id');
        $remember = session('login.remember', false);
        
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Utilisateur non trouvé.');
        }

        $isValid = false;
        
        // Vérifier si c'est un code d'authentification ou de récupération
        if (strlen($request->code) === 6 && ctype_digit($request->code)) {
            // Code d'authentification
            $isValid = $this->twoFactorService->verifyCode($user, $request->code);
        } elseif (strlen($request->code) === 8) {
            // Code de récupération
            $isValid = $this->twoFactorService->verifyRecoveryCode($user, $request->code);
        }

        if ($isValid) {
            // Connexion réussie
            auth()->login($user, $remember);
            $this->twoFactorService->markSessionAs2FAVerified($user);
            
            // Nettoyer les données de session temporaires
            session()->forget(['login.id', 'login.remember']);
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Connexion réussie !');
        }

        return back()
            ->withErrors(['code' => 'Code de vérification invalide.'])
            ->withInput();
    }

    /**
     * Envoyer un code SMS de secours
     */
    public function sendSMS(): RedirectResponse
    {
        $userId = session('login.id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);
        
        if (!$user || !$user->phone) {
            return back()
                ->with('error', 'Aucun numéro de téléphone configuré.');
        }

        if ($this->twoFactorService->sendSMSCode($user)) {
            return back()
                ->with('success', 'Code de vérification envoyé par SMS.');
        }

        return back()
            ->with('error', 'Impossible d\'envoyer le code SMS. Veuillez réessayer.');
    }
}