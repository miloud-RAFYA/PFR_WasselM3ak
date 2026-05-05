<?php

namespace App\Policies;

use App\Models\Demande;
use App\Models\User;

class DemandePolicy
{
    /**
     * Déterminer si l'utilisateur peut visualiser le suivi GPS
     * - Client (expéditeur) peut voir les positions de ses propres demandes
     * - Chauffeur peut voir le suivi de ses courses acceptées
     * - Admin peut voir toutes les positions
     */
    public function viewTracking(User $user, Demande $demande): bool
    {
        // Admin: accès à tout
        if ($user->role->type === 'admin') {
            return true;
        }

        // Client/Expéditeur: voir ses propres demandes
        if ($user->role->type === 'expediteur') {
            return $user->expediteur && $demande->expediteur_id === $user->expediteur->id;
        }

        // Chauffeur: voir le suivi de ses courses acceptées
        if ($user->role->type === 'chauffeur') {
            return $user->chauffeur && $demande->isAssignedToDriver($user->chauffeur);
        }

        return false;
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour le suivi GPS
     * (envoyer des positions)
     * - Seul le chauffeur assigné peut envoyer des positions
     */
    public function updateTracking(User $user, Demande $demande): bool
    {
        // Doit être chauffeur
        if ($user->role->type !== 'chauffeur' || !$user->chauffeur) {
            return false;
        }

        // Doit être assigné à cette course
        return $demande->isAssignedToDriver($user->chauffeur);
    }

    /**
     * Déterminer si l'utilisateur peut voir tous les détails d'une demande
     */
    public function view(User $user, Demande $demande): bool
    {
        // Admin
        if ($user->role->type === 'admin') {
            return true;
        }

        // Client: voir ses propres demandes
        if ($user->role->type === 'expediteur') {
            return $user->expediteur && $demande->expediteur_id === $user->expediteur->id;
        }

        // Chauffeur: voir les demandes auxquelles il est assigné
        if ($user->role->type === 'chauffeur') {
            return $user->chauffeur && $demande->isAssignedToDriver($user->chauffeur);
        }

        return false;
    }

    /**
     * Déterminer si l'utilisateur peut créer une demande
     */
    public function create(User $user): bool
    {
        // Seuls les expéditeurs peuvent créer des demandes
        return $user->role->type === 'expediteur' && $user->expediteur !== null;
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour une demande
     */
    public function update(User $user, Demande $demande): bool
    {
        // Admin peut tout mettre à jour
        if ($user->role->type === 'admin') {
            return true;
        }

        // Expéditeur: peut mettre à jour ses propres demandes (non-acceptées)
        if ($user->role->type === 'expediteur') {
            return $user->expediteur 
                && $demande->expediteur_id === $user->expediteur->id
                && $demande->status !== 'accepted';  // Une fois acceptée, ne plus modifier
        }

        return false;
    }

    /**
     * Déterminer si l'utilisateur peut supprimer une demande
     */
    public function delete(User $user, Demande $demande): bool
    {
        // Admin peut tout supprimer
        if ($user->role->type === 'admin') {
            return true;
        }

        // Expéditeur: peut supprimer ses propres demandes (non-acceptées)
        if ($user->role->type === 'expediteur') {
            return $user->expediteur 
                && $demande->expediteur_id === $user->expediteur->id
                && $demande->status !== 'accepted';
        }

        return false;
    }
}