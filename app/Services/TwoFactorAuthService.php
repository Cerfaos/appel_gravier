<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorAuthService
{
    protected $google2fa;
    
    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Générer un secret 2FA pour un utilisateur
     */
    public function generateSecretKey(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Activer le 2FA pour un utilisateur
     */
    public function enable(User $user, string $code): bool
    {
        if (!$user->google2fa_secret) {
            throw new \Exception('No 2FA secret found for user');
        }

        // Vérifier le code fourni
        if (!$this->verifyCode($user, $code)) {
            return false;
        }

        // Générer les codes de récupération
        $recoveryCodes = $this->generateRecoveryCodes();

        // Activer le 2FA
        $user->update([
            'google2fa_enabled' => true,
            'google2fa_enabled_at' => now(),
            'recovery_codes' => $recoveryCodes->map(fn($code) => Crypt::encryptString($code))
        ]);

        return true;
    }

    /**
     * Désactiver le 2FA pour un utilisateur
     */
    public function disable(User $user, string $password): bool
    {
        if (!\Hash::check($password, $user->password)) {
            return false;
        }

        $user->update([
            'google2fa_enabled' => false,
            'google2fa_secret' => null,
            'google2fa_enabled_at' => null,
            'recovery_codes' => null,
        ]);

        return true;
    }

    /**
     * Vérifier un code 2FA
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (!$user->google2fa_enabled || !$user->google2fa_secret) {
            return false;
        }

        $secret = Crypt::decryptString($user->google2fa_secret);
        
        // Vérifier le code avec une fenêtre de tolérance de ±1 période (30 secondes)
        return $this->google2fa->verifyKey($secret, $code, 1);
    }

    /**
     * Vérifier un code de récupération
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        if (!$user->recovery_codes) {
            return false;
        }

        $recoveryCodes = collect($user->recovery_codes)->map(fn($encrypted) => Crypt::decryptString($encrypted));
        
        if (!$recoveryCodes->contains($code)) {
            return false;
        }

        // Retirer le code de récupération utilisé
        $remainingCodes = $recoveryCodes->reject(fn($recoveryCode) => $recoveryCode === $code)
            ->map(fn($recoveryCode) => Crypt::encryptString($recoveryCode));

        $user->update(['recovery_codes' => $remainingCodes]);

        return true;
    }

    /**
     * Générer des codes de récupération
     */
    public function generateRecoveryCodes(): Collection
    {
        return collect(range(1, 8))->map(function () {
            return strtoupper(substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(6))), 0, 8));
        });
    }

    /**
     * Régénérer les codes de récupération
     */
    public function regenerateRecoveryCodes(User $user, string $password): Collection|false
    {
        if (!\Hash::check($password, $user->password)) {
            return false;
        }

        $recoveryCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'recovery_codes' => $recoveryCodes->map(fn($code) => Crypt::encryptString($code))
        ]);

        return $recoveryCodes;
    }

    /**
     * Obtenir l'URL du QR Code pour l'application d'authentification
     */
    public function getQrCodeUrl(User $user, string $secret): string
    {
        $companyName = config('app.name', 'Cerfaos');
        $email = $user->email;
        
        return $this->google2fa->getQRCodeUrl(
            $companyName,
            $email,
            $secret
        );
    }

    /**
     * Générer l'image du QR Code en SVG
     */
    public function getQrCodeSvg(User $user, string $secret): string
    {
        $url = $this->getQrCodeUrl($user, $secret);
        
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        );
        
        $writer = new Writer($renderer);
        
        return $writer->writeString($url);
    }

    /**
     * Préparer l'activation du 2FA (générer le secret mais ne pas l'activer)
     */
    public function prepareActivation(User $user): array
    {
        $secret = $this->generateSecretKey();
        
        // Sauvegarder le secret temporairement (non activé)
        $user->update(['google2fa_secret' => Crypt::encryptString($secret)]);
        
        return [
            'secret' => $secret,
            'qr_code_url' => $this->getQrCodeUrl($user, $secret),
            'backup_codes' => null // Seront générés à l'activation
        ];
    }

    /**
     * Vérifier si le 2FA est requis pour l'utilisateur
     */
    public function isRequired(User $user): bool
    {
        // Admin et utilisateurs avec rôle élevé devraient avoir le 2FA obligatoire
        return in_array($user->role, ['admin', 'moderator']);
    }

    /**
     * Marquer une session comme vérifiée avec 2FA
     */
    public function markSessionAs2FAVerified(User $user): void
    {
        session(['2fa_verified' => true, '2fa_verified_at' => now()->timestamp]);
        
        // Log de sécurité
        \Log::info('2FA verification successful', [
            'user_id' => $user->id,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * Vérifier si la session actuelle est vérifiée avec 2FA
     */
    public function isSessionVerified(): bool
    {
        if (!session('2fa_verified')) {
            return false;
        }

        // La vérification 2FA expire après 12 heures
        $verifiedAt = session('2fa_verified_at', 0);
        $maxAge = 12 * 60 * 60; // 12 heures en secondes
        
        return (now()->timestamp - $verifiedAt) < $maxAge;
    }

    /**
     * Obtenir les statistiques 2FA
     */
    public function getStats(): array
    {
        return [
            'total_users_with_2fa' => User::where('google2fa_enabled', true)->count(),
            'users_enabled_today' => User::where('google2fa_enabled', true)
                ->whereDate('google2fa_enabled_at', today())
                ->count(),
            'users_enabled_week' => User::where('google2fa_enabled', true)
                ->where('google2fa_enabled_at', '>=', now()->subWeek())
                ->count(),
            'adoption_rate' => $this->calculate2FAAdoptionRate()
        ];
    }

    /**
     * Calculer le taux d'adoption du 2FA
     */
    private function calculate2FAAdoptionRate(): float
    {
        $totalUsers = User::count();
        $users2FA = User::where('google2fa_enabled', true)->count();
        
        if ($totalUsers === 0) {
            return 0;
        }
        
        return round(($users2FA / $totalUsers) * 100, 2);
    }

    /**
     * Nettoyer les anciens secrets non activés
     */
    public function cleanupUnusedSecrets(): int
    {
        // Supprimer les secrets générés mais non activés depuis plus de 24h
        $affected = User::where('google2fa_enabled', false)
            ->whereNotNull('google2fa_secret')
            ->where('updated_at', '<', now()->subDay())
            ->update(['google2fa_secret' => null]);

        \Log::info("Cleaned up {$affected} unused 2FA secrets");

        return $affected;
    }

    /**
     * Envoyer un code 2FA par SMS (backup)
     */
    public function sendSMSCode(User $user): bool
    {
        if (!$user->phone) {
            return false;
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Stocker le code temporairement (5 minutes)
        Cache::put("sms_2fa:{$user->id}", $code, 300);
        
        // TODO: Intégrer avec un service SMS (Twilio, AWS SNS, etc.)
        // Pour l'instant, juste logger le code
        \Log::info("SMS 2FA code for user {$user->id}: {$code}");
        
        return true;
    }

    /**
     * Vérifier un code SMS 2FA
     */
    public function verifySMSCode(User $user, string $code): bool
    {
        $storedCode = Cache::get("sms_2fa:{$user->id}");
        
        if (!$storedCode || $storedCode !== $code) {
            return false;
        }

        // Supprimer le code utilisé
        Cache::forget("sms_2fa:{$user->id}");
        
        return true;
    }
}