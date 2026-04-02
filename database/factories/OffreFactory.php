<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chauffeur_id' => \App\Models\Chauffeur::factory(),
            'status' => fake()->randomElement(['en attente', 'acceptee', 'refusee', 'expiree']),
            'montant_propose' => fake()->numberBetween(50, 2000),
        ];
    }
}
