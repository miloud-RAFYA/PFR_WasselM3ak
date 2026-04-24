<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des offres pour les demandes
        $demandes = \App\Models\Demande::all();
        $chauffeurs = \App\Models\Chauffeur::all();

        foreach ($demandes as $demande) {
            // Chaque demande reçoit 2-5 offres de chauffeurs différents
            $nombreOffres = fake()->numberBetween(2, 5);
            $chauffeursAleatoires = $chauffeurs->random(min($nombreOffres, $chauffeurs->count()));

            foreach ($chauffeursAleatoires as $chauffeur) {
                \App\Models\Offre::factory()->create([
                    'chauffeur_id' => $chauffeur->id,
                    // Le demande_id sera automatiquement assigné par la factory
                ]);
            }
        }
    }
}
