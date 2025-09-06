<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icons = ['🌲', '🏔️', '🏕️', '🥾', '🧭', '🔦', '🎒', '⛺', '🚣', '🚴', '🎣', '📸'];
        
        return [
            'title' => fake()->sentence(3),
            'icon' => fake()->randomElement($icons),
            'description' => fake()->paragraph(2),
        ];
    }
}
