<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Demande;
use App\Models\Chauffeur;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'transporteurs_verifies' => Chauffeur::whereHas('user', function($query) {
                $query->where('est_verifie', true);
            })->count(),
            'expeditions_realisees' => Demande::where('status', 'delivered')->count(),
            'total_users' => User::count(),
            'demandes_en_cours' => Demande::whereIn('status', ['pending', 'in_progress'])->count(),
        ];

        return view('home', compact('stats'));
    }
}