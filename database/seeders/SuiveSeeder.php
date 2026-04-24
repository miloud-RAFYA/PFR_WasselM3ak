<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des suivis pour les demandes en cours ou livrées
        $demandesActives = \App\Models\Demande::whereIn('status', ['in_progress', 'delivered'])->get();

        foreach ($demandesActives as $demande) {
            // Créer 3-10 points de suivi par demande
            $nombreSuivis = fake()->numberBetween(3, 10);
            \App\Models\Suive::factory($nombreSuivis)->create([
                'demande_id' => $demande->id,
            ]);
        }
    }
}
