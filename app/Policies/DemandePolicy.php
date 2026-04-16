<?php

namespace App\Policies;

use App\Models\Demande;
use App\Models\User;

class DemandePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isClient();
    }

    public function view(User $user, Demande $demande): bool
    {
        // Admin peut tout voir
        if ($user->isAdmin()) {
            return true;
        }

        // Client (expéditeur) peut voir ses demandes
        if ($user->isClient()) {
            return $user->expediteur &&
                   $demande->expediteur_id === $user->expediteur->id;
        }

        // Chauffeur peut voir uniquement les demandes auxquelles il a postulé
        if ($user->isDriver()) {
            return $demande->offres()
                ->where('chauffeur_id', $user->chauffeur->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isClient();
    }

    public function update(User $user, Demande $demande): bool
    {
        // Admin full access
        if ($user->isAdmin()) {
            return true;
        }

        // Client peut modifier seulement si pending
        return $user->isClient()
            && $user->expediteur
            && $demande->expediteur_id === $user->expediteur->id
            && $demande->status === 'pending';
    }

    public function delete(User $user, Demande $demande): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isClient()
            && $user->expediteur
            && $demande->expediteur_id === $user->expediteur->id
            && $demande->status === 'pending';
    }

    public function restore(User $user, Demande $demande): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Demande $demande): bool
    {
        return $user->isAdmin();
    }
}