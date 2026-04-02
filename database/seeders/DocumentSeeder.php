<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 2-4 documents par chauffeur
        $chauffeurs = \App\Models\Chauffeur::all();

        foreach ($chauffeurs as $chauffeur) {
            $nombreDocuments = fake()->numberBetween(2, 4);
            \App\Models\Document::factory($nombreDocuments)->create([
                'chauffeur_id' => $chauffeur->id,
            ]);
        }
    }
}
