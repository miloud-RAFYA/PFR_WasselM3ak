<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suive>
 */
class SuiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'demande_id' => \App\Models\Demande::factory(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'horodatage' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
        ];
    }
}
