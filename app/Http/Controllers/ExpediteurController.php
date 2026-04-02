<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpediteurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $expediteur = $user->expediteur; 

        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $demandes = Demande::where('expediteur_id', $expediteur->id)->with('offres.chauffeur.user')->get();

        $stats = [
            'total_demandes' => $demandes->count(),
            'demandes_pending' => $demandes->where('status', 'pending')->count(),
            'demandes_in_progress' => $demandes->where('status', 'in_progress')->count(),
            'demandes_delivered' => $demandes->where('status', 'delivered')->count(),
            'total_offres_recues' => $demandes->pluck('offres')->flatten()->count(),
        ];

        return view('client.dashboard', compact('expediteur', 'demandes', 'stats'));
    }
    public function index(){
        return view('admin.dashboard');
    }
}
