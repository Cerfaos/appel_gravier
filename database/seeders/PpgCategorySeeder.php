<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PpgCategory;

class PpgCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fondation',
                'slug' => 'fondation',
                'title' => 'PPG Fondation',
                'description' => 'Construisez une base solide avec des exercices de renforcement fondamentaux pour développer votre stabilité et votre équilibre global.',
                'icon' => 'fas fa-cube',
                'color' => '#606c38',
                'order_position' => 1,
                'status' => 'published'
            ],
            [
                'name' => 'Préparation',
                'slug' => 'prepa',
                'title' => 'PPG Préparation',
                'description' => 'Optimisez vos performances avec des exercices ciblés de préparation physique pour améliorer votre puissance et votre endurance.',
                'icon' => 'fas fa-rocket',
                'color' => '#bc6c25',
                'order_position' => 2,
                'status' => 'published'
            ],
            [
                'name' => 'Récupération',
                'slug' => 'recup',
                'title' => 'PPG Récupération',
                'description' => 'Accélérez votre récupération avec des techniques de relâchement, étirements et mobilité pour maintenir votre corps en parfait état.',
                'icon' => 'fas fa-leaf',
                'color' => '#dda15e',
                'order_position' => 3,
                'status' => 'published'
            ]
        ];

        foreach ($categories as $category) {
            PpgCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('PPG Categories seeded successfully!');
    }
}