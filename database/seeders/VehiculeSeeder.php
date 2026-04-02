<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 1-2 véhicules par chauffeur
        $chauffeurs = \App\Models\Chauffeur::all();

        foreach ($chauffeurs as $chauffeur) {
            $nombreVehicules = fake()->numberBetween(1, 2);
            \App\Models\Vehicule::factory($nombreVehicules)->create([
                'chauffeur_id' => $chauffeur->id,
            ]);
        }
    }
}
