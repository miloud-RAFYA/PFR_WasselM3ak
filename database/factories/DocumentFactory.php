<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'type' => fake()->randomElement(['permis_conduire', 'carte_grise', 'assurance', 'certificat_medical']),
            'chemin' => fake()->filePath(),
            'commentaire_admin' => fake()->optional(0.3)->sentence(), // 30% de chance d'avoir un commentaire
        ];
    }
}
