<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(rand(2, 4), true);

        return [
            'category_id' => \App\Models\Category::factory(),
            'name' => $name,
            'slug' => \Str::slug($name),
            'description' => fake()->paragraphs(rand(2, 4), true),
            'stock' => fake()->numberBetween(0, 100),
            'price' => fake()->numberBetween(1000, 50000), // 10-500 MVR in laari
            'compare_at_price' => fake()->optional(0.3)->numberBetween(1200, 60000),
            'is_active' => fake()->boolean(80),
        ];
    }
}
