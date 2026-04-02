<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chauffeur;
use App\Models\Offre;
use Illuminate\Support\Facades\Auth;

class ChauffeurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        // Check if account is verified
        if (!$user->est_actif || !$user->est_verifie) {
            return redirect()->route('driver.onboarding.pending');
        }

        $offres = Offre::where('chauffeur_id', $chauffeur->id)->with('demande')->get();

        $stats = [
            'total_offres' => $offres->count(),
            'offres_acceptees' => $offres->where('status', 'acceptee')->count(),
            'offres_en_attente' => $offres->where('status', 'en attente')->count(),
            'offres_refusees' => $offres->where('status', 'refusee')->count(),
        ];

        return view('driver.dashboard', compact('chauffeur', 'offres', 'stats'));
    }
    public function index(){
        return view('driver.available');
    }
}
