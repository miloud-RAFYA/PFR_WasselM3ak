<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des évaluations pour les demandes livrées
        $demandesLivrees = \App\Models\Demande::where('status', 'delivered')->get();

        foreach ($demandesLivrees as $demande) {
            // 80% de chance d'avoir une évaluation
            if (fake()->boolean(80)) {
                \App\Models\Evaluation::factory()->create([
                    'demande_id' => $demande->id,
                ]);
            }
        }
    }
}
