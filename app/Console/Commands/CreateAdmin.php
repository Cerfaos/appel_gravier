<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--email=} {--password=} {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un compte administrateur ou réinitialiser les identifiants existants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Création/Réinitialisation d\'un compte administrateur ===');

        // Récupérer les options ou demander à l'utilisateur
        $name = $this->option('name') ?: $this->ask('Nom de l\'administrateur', 'Admin');
        $email = $this->option('email') ?: $this->ask('Email de l\'administrateur', 'admin@cerfaos.com');
        $password = $this->option('password') ?: $this->secret('Mot de passe de l\'administrateur');

        // Validation
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Erreurs de validation :');
            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }
            return 1;
        }

        // Vérifier si un admin existe déjà avec cet email
        $existingAdmin = User::where('email', $email)->first();

        if ($existingAdmin) {
            if ($this->confirm('Un utilisateur avec cet email existe déjà. Voulez-vous le mettre à jour ?')) {
                $existingAdmin->update([
                    'name' => $name,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                    'status' => '1',
                ]);
                $this->info('✅ Administrateur mis à jour avec succès !');
            } else {
                $this->info('❌ Opération annulée.');
                return 1;
            }
        } else {
            // Créer un nouvel administrateur
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'status' => '1',
            ]);
            $this->info('✅ Nouvel administrateur créé avec succès !');
        }

        // Afficher les informations de connexion
        $this->info('');
        $this->info('=== Informations de connexion ===');
        $this->info('Email: ' . $email);
        $this->info('Mot de passe: ' . $password);
        $this->info('Rôle: admin');
        $this->info('');
        $this->info('Vous pouvez maintenant vous connecter à l\'administration.');

        return 0;
    }
}