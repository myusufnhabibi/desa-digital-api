<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Development>
 */
class DevelopmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(640, 480, 'development', true),
            'name' => $this->faker->randomElement([
                'Pembangunan Jalan Desa',
                'Renovasi Balai Desa',
                'Pembangunan Jembatan Gantung',
                'Perbaikan Sistem Irigasi',
                'Pembangunan Taman Bermain Anak',
                'Renovasi Masjid Desa',
                'Pembangunan Pasar Tradisional',
                'Perbaikan Drainase Desa',
                'Pembangunan Gedung Serbaguna',
                'Renovasi Sekolah Dasar'
            ]),
            'description' => $this->faker->paragraph(),
            'person_in_charge' => $this->faker->name(),
            'start_date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years')->format('Y-m-d'),
            'amount' => $this->faker->randomFloat(2, 10000, 1000000), // Amount between 10 million and 1 billion
            'status' => $this->faker->randomElement(['on_progress', 'completed']),
        ];
    }
}
