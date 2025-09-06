<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ride>
 */
class RideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3, false),
            'slug' => Str::slug(fake()->sentence(3, false)) . '-' . Str::random(6),
            'ride_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'distance_km' => fake()->randomFloat(1, 5, 150),
            'moving_time_sec' => fake()->numberBetween(1800, 28800), // 30 min à 8h
            'total_time_sec' => fake()->numberBetween(1800, 32400), // 30 min à 9h
            'elevation_gain_m' => fake()->numberBetween(0, 2000),
            'gpx_path' => null,
            'weather' => fake()->randomElements(['ensoleille', 'nuageux', 'vent', 'pluie'], fake()->numberBetween(1, 3)),
            'experience' => fake()->paragraphs(2, true),
            'cover_image_path' => 'upload/ride/sample-cover.jpg',
            'media_count' => fake()->numberBetween(0, 10),
            'user_id' => User::factory(),
        ];
    }
}
