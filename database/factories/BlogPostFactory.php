<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        
        return [
            'category_id' => BlogCategory::factory(),
            'post_title' => $title,
            'post_slug' => Str::slug($title),
            'post_short_description' => $this->faker->text(150),
            'post_content' => $this->faker->paragraphs(5, true),
            'post_image' => 'blog/placeholder.jpg',
            'post_tags' => implode(', ', $this->faker->words(3)),
            'meta_title' => $title,
            'meta_description' => $this->faker->text(160),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}