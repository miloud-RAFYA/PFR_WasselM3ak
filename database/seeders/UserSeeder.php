<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un admin
        \App\Models\User::factory()->create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@wasselmak.ma',
            'role_id' => 1, // admin
            'est_actif' => true,
            'est_verifie' => true,
        ]);

        // Créer des chauffeurs
        \App\Models\User::factory(10)->create([
            'role_id' => 2, // chouffeur
        ]);

        // Créer des expéditeurs
        \App\Models\User::factory(15)->create([
            'role_id' => 3, // expediteur
        ]);
    }
}