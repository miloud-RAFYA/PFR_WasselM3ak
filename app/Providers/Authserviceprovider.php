<?php

namespace App\Providers;

use App\Models\Demande;
use App\Policies\DemandePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // ✅ AJOUTER CETTE LIGNE pour enregistrer la Policy
        Demande::class => DemandePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // ✅ OPTIONNEL: Gates personnalisées si besoin
        // Gate::define('updateTracking', function ($user, $demande) {
        //     return $user->chauffeur && $demande->isAssignedToDriver($user->chauffeur);
        // });
    }
}