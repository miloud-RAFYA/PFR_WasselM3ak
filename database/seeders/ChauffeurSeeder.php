<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChauffeurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des chauffeurs pour les utilisateurs ayant le rôle chauffeur
        $chauffeurUsers = \App\Models\User::whereHas('role', function($query) {
            $query->where('type', 'chouffeur');
        })->get();

        foreach ($chauffeurUsers as $user) {
            \App\Models\Chauffeur::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
