<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Broker>
 */
class BrokerFactory extends Factory
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
            'slug' => $this->faker->slug(3),
            'image' => $this->faker->imageUrl(640, 480),
            'role' => $this->faker->randomElement(['broker', 'agent']),
            'about' => $this->faker->paragraph(3),
            'experience' => $this->faker->paragraph(1),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'residence' => $this->faker->address(),
            'x' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
        ];
    }
}
