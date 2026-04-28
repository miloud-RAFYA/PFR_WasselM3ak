<?php

namespace App\Http\Controllers;

use App\Events\DriverPositionUpdated;
use App\Models\Demande;
use App\Models\Suive;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function getPositions(Demande $demande)
    {
        $user = Auth::user();

        if (!$user) abort(403);

        if ($user->role->type === 'expediteur') {
            if (!$user->expediteur || $demande->expediteur_id !== $user->expediteur->id) {
                abort(403);
            }
        } elseif ($user->role->type === 'chauffeur') {
            if (!$user->chauffeur || !$demande->isAssignedToDriver($user->chauffeur)) {
                abort(403);
            }
        } elseif ($user->role->type !== 'admin') {
            abort(403);
        }

        $suivres = $demande->suivres()
            ->latest('created_at')
            ->take(20)
            ->get();
           return response()->json(
            $suivres
                ->sortBy('created_at')
                ->values()
                ->map(fn($p) => [
                    'lat' => (float) $p->latitude,
                    'lng' => (float) $p->longitude,
                    'time' => $p->horodatage?->format('H:i:s') ?? $p->created_at->format('H:i:s'),
                ])
        );
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Vérification de l'identité du chauffeur
        if (!$user || !$user->chauffeur) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        $chauffeur = $user->chauffeur;

        // 2. Validation des données GPS
        $data = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'latitude'   => 'required|numeric',
            'longitude'  => 'required|numeric',
        ]);

        $demande = Demande::findOrFail($data['demande_id']);

        // 3. Vérification que l'offre a été acceptée (Attention à l'orthographe 'acceptée')
        $acceptedOffer = $demande->offres()
            ->where('status', 'acceptee')
            ->first();

        if (!$acceptedOffer || $acceptedOffer->chauffeur_id !== $chauffeur->id) {
            return response()->json(['error' => 'Vous n\'êtes pas le chauffeur assigné.'], 403);
        }

        // 4. Vérification que la course est bien en cours
        if ($demande->status !== 'in_progress') {
            return response()->json(['error' => 'Le suivi est désactivé pour cette course.'], 403);
        }

        $position = [
            'lat'  => (float) $data['latitude'],
            'lng'  => (float) $data['longitude'],
            'time' => now()->format('H:i:s'),
        ];

        // 5. Logique d'optimisation de la base de données
        // On récupère la toute dernière position enregistrée
        $last = $demande->suivres()->latest('horodatage')->first();

        // Seuil de mouvement (environ 10-11 mètres) pour éviter de saturer la table 'suivres'
        $movementThreshold = 0.0001;

        if (
            $last &&
            abs($last->latitude - $data['latitude']) < $movementThreshold &&
            abs($last->longitude - $data['longitude']) < $movementThreshold
        ) {
            // Le chauffeur est immobile ou presque : on met juste à jour l'heure
            $last->update(['horodatage' => now()]);
        } else {
            // Le chauffeur a bougé : on crée un nouveau point de passage
            Suive::create([
                'demande_id' => $demande->id,
                'latitude'   => $data['latitude'],
                'longitude'  => $data['longitude'],
                'horodatage' => now(),
            ]);
        }

        // 6. Diffusion temps réel via Pusher/Laravel Echo
        broadcast(new DriverPositionUpdated($demande, $position))->toOthers();

        return response()->json([
            'success'  => true,
            'message'  => 'Position mise à jour',
            'position' => $position
        ]);
    }

    public function driverTracking(Demande $demande)
    {
        $chauffeur = Auth::user()->chauffeur;

        if (!$chauffeur || ! $demande->isAssignedToDriver($chauffeur)) {
            abort(403);
        }

        return view('driver.tracking', compact('demande'));
    }
}
