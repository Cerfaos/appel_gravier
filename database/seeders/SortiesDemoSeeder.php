<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sortie;
use App\Models\User;

class SortiesDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'utilisateur admin
        $admin = User::where('email', 'cerfaos@gmail.com')->first();
        
        if (!$admin) {
            echo "❌ Utilisateur admin non trouvé. Exécutez d'abord AdminUserSeeder.\n";
            return;
        }

        // Créer des sorties de démonstration
        $sorties = [
            [
                'title' => 'Tour du Lac Blanc - Première sortie gravel',
                'slug' => 'tour-lac-blanc-premiere-sortie-gravel',
                'description' => 'Ma première vraie sortie gravel dans les Vosges. 45km autour du Lac Blanc avec quelques montées qui piquent mais des paysages à couper le souffle.',
                'departement' => 'Haut-Rhin',
                'pays' => 'France',
                'personal_comment' => 'Première fois que je teste mon nouveau gravel sur du relief. Les jambes ont chauffé mais quel plaisir !',
                'distance_km' => 45.2,
                'elevation_gain_m' => 850,
                'elevation_loss_m' => 850,
                'difficulty_level' => 'moyen',
                'estimated_duration_minutes' => 180,
                'actual_duration_minutes' => 210,
                'sortie_date' => now()->subDays(15),
                'status' => 'published',
                'published_at' => now()->subDays(14),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Balade familiale - Canal de Colmar',
                'slug' => 'balade-familiale-canal-colmar',
                'description' => 'Sortie tranquille le long du canal de Colmar. Parfait pour débuter en gravel sans se prendre la tête.',
                'departement' => 'Haut-Rhin',
                'pays' => 'France',
                'personal_comment' => 'Idéal pour une sortie digestive du dimanche. Plat, facile, et on peut s\'arrêter prendre un café.',
                'distance_km' => 25.8,
                'elevation_gain_m' => 120,
                'elevation_loss_m' => 120,
                'difficulty_level' => 'facile',
                'estimated_duration_minutes' => 90,
                'actual_duration_minutes' => 120,
                'sortie_date' => now()->subDays(7),
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Défi Ballon d\'Alsace - Test des limites',
                'slug' => 'defi-ballon-alsace-test-limites',
                'description' => 'Sortie ambitieuse vers le Ballon d\'Alsace. 60km avec du dénivelé sérieux. Pas pour les débutants !',
                'departement' => 'Territoire de Belfort',
                'pays' => 'France',
                'personal_comment' => 'Dur, très dur. Mais arrivé au sommet, la vue vaut tous les efforts. À refaire quand les jambes auront récupéré.',
                'distance_km' => 62.4,
                'elevation_gain_m' => 1250,
                'elevation_loss_m' => 1250,
                'difficulty_level' => 'difficile',
                'estimated_duration_minutes' => 240,
                'actual_duration_minutes' => 285,
                'sortie_date' => now()->subDays(2),
                'status' => 'published',
                'published_at' => now()->subDay(),
                'user_id' => $admin->id,
            ],
        ];

        foreach ($sorties as $sortieData) {
            Sortie::create($sortieData);
        }

        echo "✅ 3 sorties de démonstration créées avec succès !\n";
        echo "📍 Les sorties apparaîtront maintenant sur la page d'accueil\n";
    }
}