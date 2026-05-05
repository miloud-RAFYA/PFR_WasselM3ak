<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Offre;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    // Afficher la page de paiement
    public function statistiquesChauffeur()
    {
        $chauffeur = Auth::user()->chauffeur;

        // Récupérer les IDs des demandes pour lesquelles ce chauffeur a une offre acceptée
        $demandeIds = Offre::where('chauffeur_id', $chauffeur->id)
            ->where('status', 'acceptee')   // ou votre colonne de statut accepté
            ->pluck('demande_id');

        // Requête sur les paiements liés à ces demandes
        $query = Paiement::whereIn('demande_id', $demandeIds)
            ->whereIn('status', ['paid', 'confirmed']);

        $stats = [
            'total_gagne'         => (clone $query)->sum('montant_total'),
            'commission_prelevee' => (clone $query)->sum('commission'),
            'net'                 => (clone $query)->sum(DB::raw('montant_total - commission')),
            'nombre_livraisons'   => (clone $query)->count(),
        ];

        return view('driver.paiements.statistiques', compact('stats'));
    }

    // Pour l’admin
    public function statistiquesAdmin(Request $request)
    {
        $selectedYear = (int) $request->get('year', date('Y')); // Conversion explicite en entier

        $totalVerse = Paiement::whereIn('status', ['paid', 'confirmed'])->sum('montant_total');
        $totalCommission = Paiement::whereIn('status', ['paid', 'confirmed'])->sum('commission');
        $nbTransactions = Paiement::whereIn('status', ['paid', 'confirmed'])->count();
        $nbConfirmed = Paiement::where('status', 'confirmed')->count();
        $nbEnAttente = Paiement::where('status', 'unpaid')->count();

        // ✅ PARTIE CORRIGÉE
        $monthlyLabels = [];
        $monthlyData = [];
        $monthlyCommissionData = [];

        for ($month = 1; $month <= 12; $month++) {
            // Méthode 1 : Carbon::create()
            $monthStart = \Carbon\Carbon::create($selectedYear, $month, 1, 0, 0, 0);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $monthlyLabels[] = $monthStart->translatedFormat('F'); // "Janvier", "Février"...

            $monthlyData[] = Paiement::whereIn('status', ['paid', 'confirmed'])
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('montant_total');

            $monthlyCommissionData[] = Paiement::whereIn('status', ['paid', 'confirmed'])
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('commission');
        }



        $paymentModeData = DB::table('paiements')
            ->select('mode_paiement', DB::raw('SUM(montant_total) as total'))
            ->whereIn('status', ['paid', 'confirmed'])
            ->groupBy('mode_paiement')
            ->get();


        $topChauffeurs = DB::table('paiements')
            ->join('demandes', 'paiements.demande_id', '=', 'demandes.id')
            ->join('offres', function ($join) {
                $join->on('demandes.id', '=', 'offres.demande_id')
                    ->where('offres.status', '=', 'acceptee');
            })
            ->join('chauffeurs', 'offres.chauffeur_id', '=', 'chauffeurs.id')
            ->join('users', 'chauffeurs.user_id', '=', 'users.id')
            ->whereIn('paiements.status', ['paid', 'confirmed'])
            ->select(
                'users.id',
                DB::raw("CONCAT(users.prenom, ' ', users.nom) as chauffeur_nom"),
                DB::raw('SUM(paiements.montant_total) as total_montant'),
                DB::raw('SUM(paiements.commission) as total_commission'),
                DB::raw('COUNT(*) as nb_livraisons')
            )
            ->groupBy('users.id', 'users.prenom', 'users.nom')
            ->orderByDesc('total_commission')
            ->limit(10)
            ->get();

        $recentPayments = Paiement::with(['demande.expediteur.user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.paiements.statistiques', compact(
            'totalVerse',
            'totalCommission',
            'nbTransactions',
            'nbConfirmed',
            'nbEnAttente',
            'monthlyLabels',
            'monthlyData',
            'monthlyCommissionData',
            'paymentModeData',
            'topChauffeurs',
            'recentPayments',
            'selectedYear'
        ));
    }
}
