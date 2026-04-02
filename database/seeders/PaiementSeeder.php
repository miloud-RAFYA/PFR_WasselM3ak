<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des paiements pour toutes les demandes
        $demandes = \App\Models\Demande::all();

        foreach ($demandes as $demande) {
            \App\Models\Paiement::factory()->create([
                'demande_id' => $demande->id,
                'montant_total' => $demande->prix_final,
            ]);
        }
    }
}
