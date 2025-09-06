<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sortie>
 */
class SortieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'departement' => $this->faker->randomElement(['Alpes-de-Haute-Provence', 'Hautes-Alpes', 'Isère', 'Savoie']),
            'pays' => 'France',
            'personal_comment' => $this->faker->paragraph(),
            'gpx_file_path' => 'gpx/sortie-test.gpx',
            'distance_km' => $this->faker->randomFloat(2, 5, 100),
            'elevation_gain_m' => $this->faker->numberBetween(100, 3000),
            'elevation_loss_m' => $this->faker->numberBetween(100, 3000),
            'difficulty_level' => $this->faker->randomElement(['facile', 'moyen', 'difficile']),
            'estimated_duration_minutes' => $this->faker->numberBetween(120, 1440), // 2h to 24h
            'min_latitude' => $this->faker->randomFloat(8, 43.0, 44.0),
            'max_latitude' => $this->faker->randomFloat(8, 44.0, 45.0),
            'min_longitude' => $this->faker->randomFloat(8, 5.0, 6.0),
            'max_longitude' => $this->faker->randomFloat(8, 6.0, 7.0),
            'status' => 'draft',
            'published_at' => null,
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->sentence(),
        ];
    }
}