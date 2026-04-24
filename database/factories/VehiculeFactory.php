<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicule>
 */
class VehiculeFactory extends Factory
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
            'type' => fake()->randomElement(['camion', 'fourgon', 'voiture', 'moto']),
            'immatriculation' => strtoupper(fake()->bothify('??-###-??')),
            'capacite_charge_kg' => fake()->numberBetween(500, 5000),
            'capacite_volume_m3' => fake()->numberBetween(5, 50),
        ];
    }
}
