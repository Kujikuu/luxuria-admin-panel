<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(3),
            'availability' => $this->faker->randomElement(['rent', 'sale']),
            'description' => $this->faker->paragraph(3),
            'images' => $this->faker->imageUrl(640, 480),
            'price' => $this->faker->randomFloat(2, 1000, 1000000),
            'living_space' => $this->faker->randomFloat(2, 50, 500),
            'address' => $this->faker->address(),
            'completion_year' => $this->faker->numberBetween(1900, date('Y')),
            'floors' => $this->faker->numberBetween(1, 10),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 5),
        ];
    }
}
