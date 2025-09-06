<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'subject' => $this->faker->sentence(4),
            'message' => $this->faker->paragraphs(3, true),
            'preferred_contact' => $this->faker->randomElement(['email', 'phone']),
            'status' => $this->faker->randomElement(['nouveau', 'lu', 'traite']),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}