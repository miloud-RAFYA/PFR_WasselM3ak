<?php

namespace App\Http\Controllers;

use App\Events\DriverPositionUpdated;
use App\Models\Demande;
use App\Models\Suive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function getPositions(Demande $demande)
    {
        $user = Auth::user();

        if ($user->role->type === 'expediteur') {
            $expediteur = $user->expediteur;

            if (!$expediteur || $demande->expediteur_id !== $expediteur->id) {
                abort(403);
            }
        } elseif ($user?->role?->type === 'chauffeur') {
            $chauffeur = $user->chauffeur;
            if (!$chauffeur || ! $demande->isAssignedToDriver($chauffeur)) {
                abort(403);
            }
        } elseif (!$user?->role?->type === 'admin') {
            abort(403);
        }

        return response()->json(
            $demande->suivres()
                ->latest('created_at')
                ->take(20)
                ->get()
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
        $chauffeur = Auth::user()->chauffeur;

        if (!$chauffeur) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $demande = Demande::findOrFail($data['demande_id']);
        $acceptedOffer = $demande->offres()->where('status', 'acceptee')->first();

        if (!$acceptedOffer || $acceptedOffer->chauffeur_id !== $chauffeur->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($demande->status !== 'in_progress') {
            return response()->json(['error' => 'Tracking disabled'], 403);
        }

        $position = [
            'lat' => $data['latitude'],
            'lng' => $data['longitude'],
            'time' => now()->format('d/m/Y H:i:s'),
        ];

        $lastPosition = $demande->suivres()->latest('created_at')->first();

        if (
            $lastPosition &&
            abs($lastPosition->latitude - $data['latitude']) < 0.000001 &&
            abs($lastPosition->longitude - $data['longitude']) < 0.000001
        ) {
            $lastPosition->update(['horodatage' => now()]);
        } else {
            Suive::create([
                'demande_id' => $demande->id,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'horodatage' => now(),
            ]);
        }

        event(new DriverPositionUpdated($demande, $position));

        return response()->json(['success' => true, 'position' => $position]);
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
