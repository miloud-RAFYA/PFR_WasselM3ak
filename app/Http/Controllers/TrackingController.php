<?php

namespace App\Http\Controllers;

use App\Events\DriverPositionUpdated;
use App\Models\Demande;
use App\Models\Suive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Récupère les positions historiques d'une demande
     */
    public function getPositions(Demande $demande)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        // Vérification des permissions
        if ($user->role->type === 'expediteur') {
            if (!$user->expediteur || $demande->expediteur_id !== $user->expediteur->id) {
                abort(403, 'Accès refusé à cette demande');
            }
        } elseif ($user->role->type === 'chauffeur') {
            if (!$user->chauffeur || !$demande->isAssignedToDriver($user->chauffeur)) {
                abort(403, 'Vous n\'êtes pas assigné à cette course');
            }
        } elseif ($user->role->type !== 'admin') {
            abort(403, 'Accès refusé');
        }

        // Récupérer les 20 dernières positions
        $suivres = $demande->suivres()
            ->latest('created_at')
            ->take(20)
            ->get();

        // Retourner les positions dans l'ordre chronologique avec format uniforme
        return response()->json(
            $suivres
                ->sortBy('created_at')
                ->values()
                ->map(fn($p) => [
                    'latitude' => (float) $p->latitude,
                    'longitude' => (float) $p->longitude,
                    'time' => $p->horodatage?->format('H:i:s') ?? $p->created_at->format('H:i:s'),
                    'timestamp' => $p->horodatage?->timestamp ?? $p->created_at->timestamp,
                ])
        );
    }

    /**
     * Enregistre une nouvelle position GPS du chauffeur
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Vérification de l'authentification et du rôle chauffeur
        if (!$user || !$user->chauffeur) {
            return response()->json(['error' => 'Accès non autorisé. Vous devez être chauffeur.'], 403);
        }

        $chauffeur = $user->chauffeur;

        // 2. Validation des données GPS
        $data = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        $demande = Demande::findOrFail($data['demande_id']);

        // 3. Vérification que le chauffeur est assigné à cette course
        $acceptedOffer = $demande->offres()
            ->where('status', 'acceptee')
            ->where('chauffeur_id', $chauffeur->id)
            ->first();

        if (!$acceptedOffer) {
            return response()->json([
                'error' => 'Vous n\'êtes pas assigné à cette course.'
            ], 403);
        }

        // 4. Vérification que la course est en cours
        if ($demande->status !== 'in_progress') {
            return response()->json([
                'error' => 'Le suivi est désactivé pour cette course. Status: ' . $demande->status
            ], 403);
        }

        // 5. Logique d'optimisation pour éviter le flood de données
        $last = $demande->suivres()->latest('horodatage')->first();

        // Seuil de mouvement: ~10 mètres en degrés (0.0001 ≈ 11 mètres à l'équateur)
        $movementThreshold = 0.0001;

        if (
            $last &&
            abs($last->latitude - $data['latitude']) < $movementThreshold &&
            abs($last->longitude - $data['longitude']) < $movementThreshold
        ) {
            // Chauffeur immobile: on met à jour l'heure seulement
            $last->update(['horodatage' => now()]);
            
            return response()->json([
                'success' => true,
                'message' => 'Position inchangée (mise à jour horodatage)',
                'position' => [
                    'latitude' => (float) $last->latitude,
                    'longitude' => (float) $last->longitude,
                    'time' => now()->format('H:i:s'),
                ],
                'cached' => true
            ]);
        }

        // Le chauffeur a bougé: créer une nouvelle position
        $position = Suive::create([
            'demande_id' => $demande->id,
            'latitude'   => $data['latitude'],
            'longitude'  => $data['longitude'],
            'horodatage' => now(),
        ]);

        // 6. Diffusion temps réel via Pusher/Laravel Echo
        broadcast(new DriverPositionUpdated(
            $demande,
            [
                'latitude' => (float) $data['latitude'],
                'longitude' => (float) $data['longitude'],
                'time' => now()->format('H:i:s'),
            ]
        ))->toOthers();

        return response()->json([
            'success'  => true,
            'message'  => 'Position mise à jour avec succès',
            'position' => [
                'latitude' => (float) $position->latitude,
                'longitude' => (float) $position->longitude,
                'time' => $position->horodatage->format('H:i:s'),
            ]
        ]);
    }

    /**
     * Affiche la vue de suivi pour le chauffeur
     */
    public function driverTracking(Demande $demande)
    {
        $chauffeur = Auth::user()->chauffeur;

        if (!$chauffeur || !$demande->isAssignedToDriver($chauffeur)) {
            abort(403, 'Vous n\'êtes pas assigné à cette course');
        }

        return view('driver.tracking', compact('demande'));
    }
}