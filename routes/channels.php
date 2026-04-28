<?php
use App\Models\Demande;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tracking.demande.{id}', function ($user, $id) {

    $demande = Demande::with('offres')->find($id);

    if (!$demande) return false;

    // Client
    if ($user->role->type === 'expediteur') {
        return $demande->expediteur_id === $user->expediteur->id;
    }

    // Chauffeur
    if ($user->role->type === 'chauffeur') {
        return $demande->offres->contains(function ($offre) use ($user) {
            return $offre->status === 'acceptee' &&
                   $offre->chauffeur_id === $user->chauffeur->id;
        });
    }

    // Admin
    if ($user->role->type === 'admin') {
        return true;
    }

    return false;
});