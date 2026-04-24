<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demande>
 */
class DemandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prixEstime = fake()->numberBetween(100, 5000);

        return [
            'reference' => 'DEM-' . fake()->unique()->numberBetween(100000, 999999),
            'ville_depart' => fake()->city(),
            'ville_arrive' => fake()->city(),
            'type_marchendise' => fake()->randomElement(['colis', 'meubles', 'electronique', 'alimentaire', 'vetements', 'documents']),
            'poids_kg' => fake()->numberBetween(1, 1000),
            'prix_estime' => $prixEstime,
            'prix_final' => fake()->numberBetween($prixEstime * 0.8, $prixEstime * 1.2),
            'status' => fake()->randomElement(['pending', 'in_progress', 'delivered']),
        ];
    }
}
