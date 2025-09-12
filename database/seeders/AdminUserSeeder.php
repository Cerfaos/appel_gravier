<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mettre à jour l'utilisateur existant cerfaos@gmail.com
        $user = User::where('email', 'cerfaos@gmail.com')->first();
        
        if ($user) {
            $user->update([
                'name' => 'Admin Cerfaos',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            echo "✅ Utilisateur mis à jour avec succès !\n";
        } else {
            // Si l'utilisateur n'existe pas, le créer
            User::create([
                'name' => 'Admin Cerfaos',
                'email' => 'cerfaos@gmail.com',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            echo "✅ Utilisateur admin créé avec succès !\n";
        }

        echo "📧 Email: cerfaos@gmail.com\n";
        echo "🔑 Mot de passe: admin123456\n";
        echo "🌐 Connectez-vous sur: localhost:8000/dashboard\n";
    }
}
