<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paiement>
 */
class PaiementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $montantTotal = fake()->numberBetween(100, 5000);
        $commission = $montantTotal * 0.1; // 10% commission

        return [
            'demande_id' => \App\Models\Demande::factory(),
            'montant_total' => $montantTotal,
            'commission' => $commission,
            'mode_paiement' => fake()->randomElement(['carte_bancaire', 'virement', 'paypal', 'especes']),
            'status' => fake()->randomElement(['unpaid', 'paid', 'confirmed']),
        ];
    }
}
