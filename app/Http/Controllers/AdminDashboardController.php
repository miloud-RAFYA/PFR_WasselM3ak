<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Demande;
use App\Models\Offre;
use App\Models\Chauffeur;
use App\Models\Expediteur;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        
        $stats = [
            'total_users' => User::count(),
            'total_demandes' => Demande::count(),
            'total_offres' => Offre::count(),
            'total_chauffeurs' => Chauffeur::count(),
            'total_expediteurs' => Expediteur::count(),
            'demandes_en_cours' => Demande::where('status', 'in_progress')->count(),
            'demandes_terminees' => Demande::where('status', 'delivered')->count(),
        ];
        $usersByRole = User::with('role')->get()->groupBy(function($user) {
            return $user->role?->type ?? 'sans rôle';
        })->map->count();
        $recentDemandes = Demande::with('expediteur.user')->latest()->take(5)->get(); 
        $recentOffres = Offre::with('chauffeur.user', 'demande')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'usersByRole', 'recentDemandes', 'recentOffres'));
    }
}