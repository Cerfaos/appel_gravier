<?php

namespace Database\Seeders;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de test s'il n'existe pas
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Créer quelques sorties de test
        $rides = [
            [
                'title' => 'Tour du Lac Léman',
                'ride_date' => now()->subDays(5),
                'distance_km' => 45.2,
                'elevation_gain_m' => 320,
                'moving_time_sec' => 7200, // 2h
                'total_time_sec' => 9000, // 2h30
                'weather' => ['ensoleille', 'vent'],
                'experience' => 'Magnifique sortie autour du lac avec une vue imprenable sur les Alpes. Le vent était présent mais gérable.',
                'cover_image_path' => 'upload/ride/sample-cover.jpg',
                'media_count' => 3,
            ],
            [
                'title' => 'Ascension du Mont Ventoux',
                'ride_date' => now()->subDays(10),
                'distance_km' => 28.5,
                'elevation_gain_m' => 1617,
                'moving_time_sec' => 10800, // 3h
                'total_time_sec' => 14400, // 4h
                'weather' => ['ensoleille', 'nuageux'],
                'experience' => 'Challenge épique ! L\'ascension était difficile mais la récompense au sommet vaut tous les efforts.',
                'cover_image_path' => 'upload/ride/sample-cover.jpg',
                'media_count' => 5,
            ],
            [
                'title' => 'Balade en Forêt de Fontainebleau',
                'ride_date' => now()->subDays(15),
                'distance_km' => 32.1,
                'elevation_gain_m' => 180,
                'moving_time_sec' => 5400, // 1h30
                'total_time_sec' => 7200, // 2h
                'weather' => ['nuageux'],
                'experience' => 'Sortie tranquille dans la forêt, parfaite pour se détendre et profiter de la nature.',
                'cover_image_path' => 'upload/ride/sample-cover.jpg',
                'media_count' => 2,
            ],
        ];

        foreach ($rides as $rideData) {
            Ride::firstOrCreate(
                [
                    'title' => $rideData['title'],
                    'ride_date' => $rideData['ride_date'],
                ],
                array_merge($rideData, [
                    'slug' => Str::slug($rideData['title']) . '-' . Str::random(6),
                    'user_id' => $user->id,
                ])
            );
        }
    }
}
