<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Découvrez l\'Aventure qui vous attend',
            'description' => 'Explorez les sentiers de montagne, campez sous les étoiles et reconnectez-vous avec la nature. Des aventures outdoor inoubliables vous attendent avec Cerfaos.',
            'image' => 'upload/no_image.jpg',
            'link' => '#',
        ];
    }
}
