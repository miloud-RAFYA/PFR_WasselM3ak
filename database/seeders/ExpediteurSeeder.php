<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpediteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des expéditeurs pour les utilisateurs ayant le rôle expediteur
        $expediteurUsers = \App\Models\User::whereHas('role', function($query) {
            $query->where('type', 'expediteur');
        })->get();

        foreach ($expediteurUsers as $user) {
            \App\Models\Expediteur::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
