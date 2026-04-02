<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les rôles
        $this->call(RoleSeeder::class);

        // Créer les utilisateurs avec leurs rôles
        $this->call(UserSeeder::class);

        // Créer les chauffeurs et expéditeurs
        $this->call(ChauffeurSeeder::class);
        $this->call(ExpediteurSeeder::class);

        // Créer les données dépendantes
        $this->call(VehiculeSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(DemandeSeeder::class);
        $this->call(OffreSeeder::class);
        $this->call(EvaluationSeeder::class);
        $this->call(PaiementSeeder::class);
        $this->call(SuiveSeeder::class);
    }
}
