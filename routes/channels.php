<?php

use App\Models\Demande;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tracking.demande.{demandeId}', function ($user, $demandeId) {
    $demande = Demande::with('offres')->find($demandeId);

    if (! $demande) {
        return false;
    }

    if ($user->isAdmin()) {
        return true;
    }

    if ($user->isClient() && $user->expediteur && $demande->expediteur_id === $user->expediteur->id) {
        return ['id' => $user->id, 'name' => $user->nom];
    }

    if ($user->isDriver() && $user->chauffeur) {
        return $demande->offres->contains(fn($offre) => $offre->status === 'acceptee' && $offre->chauffeur_id === $user->chauffeur->id);
    }

    return false;
});
