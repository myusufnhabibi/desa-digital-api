<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventParticipant>
 */
class EventParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 'event_id',
        // 'head_of_family_id',
        // 'quantity',
        // 'total_price',
        // 'payment_status',
        return [
            'quantity' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->numberBetween( 10000, 500000),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
