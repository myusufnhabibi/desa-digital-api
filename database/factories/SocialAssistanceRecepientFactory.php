<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistanceRecepient>
 */
class SocialAssistanceRecepientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 100000, 1000000),
            'reason' => $this->faker->sentence(),
            'bank' => $this->faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI']),
            'account_number' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'proof' => $this->faker->url(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
