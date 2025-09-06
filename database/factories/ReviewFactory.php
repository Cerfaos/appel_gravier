<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = ['Randonneur', 'Campeur', 'Alpiniste', 'Photographe', 'Guide', 'Aventurier', 'Explorateur', 'Sportif'];
        
        return [
            'name' => fake()->name(),
            'position' => fake()->randomElement($positions),
            'message' => fake()->paragraph(3),
            'image' => 'upload/no_image.jpg',
        ];
    }
}
