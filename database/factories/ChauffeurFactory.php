<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chauffeur>
 */
class ChauffeurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'status' => fake()->randomElement(['en repos', 'en mission', 'disponible']),
            'note_moyenne' => fake()->numberBetween(0, 5),
            'total_livraisons' => fake()->numberBetween(0, 500),
        ];
    }
}
