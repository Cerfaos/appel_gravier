<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feature;
use App\Models\Review;
use App\Models\Slider;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@cerfaos.com',
            'password' => bcrypt('password'),
        ]);

        // Créer des utilisateurs supplémentaires
        User::factory(5)->create();

        // Créer des features (activités)
        Feature::factory(8)->create();

        // Créer des avis
        Review::factory(6)->create();

        // Créer un slider par défaut
        Slider::factory()->create();
    }
}
