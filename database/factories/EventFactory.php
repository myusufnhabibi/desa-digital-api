<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(640, 480, 'event', true),
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(0, 10000, 100000),
            'date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'time' => $this->faker->time(),
            'is_active' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}
