<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Demande;
use App\Models\Offre;
use App\Models\Chauffeur;
use App\Models\Expediteur;
use App\Models\Document;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment\Doc;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        // Statistiques principales
        $stats = [
            'total_users' => User::count(),
            'total_demandes' => Demande::count(),
            'total_offres' => Offre::count(),
            'total_chauffeurs' => Chauffeur::count(),
            'total_expediteurs' => Expediteur::count(),
            'demandes_en_cours' => Demande::where('status', 'in_progress')->count(),
            'demandes_terminees' => Demande::where('status', 'delivered')->count(),
        ];

        // Revenus totaux (somme des demandes livrées)
        $stats['revenus_totaux'] = Demande::where('status', 'delivered')
            ->sum('prix_estime') ?? 0;

        // Revenus ce mois
        $stats['revenus_mois'] = Demande::where('status', 'delivered')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('prix_estime') ?? 0;

        // Répartition utilisateurs par rôle
        $usersByRole = User::with('role')->get()->groupBy(function ($user) {
            return $user->role?->type ?? 'sans_role';
        })->map->count();

        // Pourcentages clients vs transporteurs
        $totalClientsDrivers = ($usersByRole['expediteur'] ?? 0) + ($usersByRole['chauffeur'] ?? 0);
        $stats['clients_percent'] = $totalClientsDrivers > 0 
            ? round(($usersByRole['expediteur'] ?? 0) / $totalClientsDrivers * 100) 
            : 0;
        $stats['drivers_percent'] = $totalClientsDrivers > 0 
            ? round(($usersByRole['chauffeur'] ?? 0) / $totalClientsDrivers * 100) 
            : 0;

        // Inscriptions par mois (12 derniers mois)
        $monthlyRegistrations = User::select(
            DB::raw('COUNT(id) as total'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Formatter pour Chart.js
        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $monthLabel = $date->format('M');
            
            $chartLabels[] = $monthLabel;
            
            $found = $monthlyRegistrations->first(function ($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });
            
            $chartData[] = $found ? $found->total : 0;
        }

        // Données pour le graphique
        $chartDataJson = [
            'labels' => $chartLabels,
            'data' => $chartData,
        ];

        // Dernières demandes et offres
        $recentDemandes = Demande::with('expediteur.user')->latest()->take(5)->get();
        $recentOffres = Offre::with('chauffeur.user', 'demande')->latest()->take(5)->get();

        // Derniers utilisateurs inscrits
        $recentUsers = User::with('role')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'usersByRole',
            'chartDataJson',
            'recentDemandes',
            'recentOffres',
            'recentUsers'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('type', $request->role);
                
                });
                // $user1=$query->paginate(22)->withQueryString();
                // dd($user1);

        }

        if ($request->filled('est_verifie')) {
            $query->where('est_verifie', $request->est_verifie);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }
    public function verify($id)
    {
        $user = User::findOrFail($id);
        $user->update(['est_verifie' => 1]);
        return back()->with('success', 'Utilisateur vérifié avec succès.');
    }

    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // Find or create admin role
        $adminRole = \App\Models\Role::firstOrCreate(['type' => 'admin']);
        
        $user->update(['role_id' => $adminRole->id]);
        return back()->with('success', 'Utilisateur promu administrateur avec succès.');
    }

    public function userDocuments($userId)
    {
        $user = User::with('chauffeur.documents')->findOrFail($userId);
        
        if (!$user->isDriver()) {
            return back()->with('error', 'Aucun document pour cet utilisateur.');
            }
            
            $documents = $user->chauffeur->documents()->latest()->get();
        //    dd($documents);        // Vérifier que chaque document existe dans le storage
        foreach ($documents as $document) {
            $documentPath = public_path($document->chemin);
            $document->file_exists = file_exists($documentPath);
        }
        
        return view('admin.users.documents', compact('user', 'documents'));
    }

    public function verifyAllUserDocuments($userId)
    {
        $user = User::with('chauffeur.documents')->findOrFail($userId);
        
        if (!$user->isDriver() || !$user->chauffeur) {
            return back()->with('error', 'Aucun document pour cet utilisateur.');
        }
        
        $user->chauffeur->documents()->update(['status' => 'approuve']);
        return back()->with('success', 'Tous les documents ont été approuvés.');
    }

    public function destroy( $id)
    {
        $user = User::FindOrFail($id);
        // dd($user);
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function statistics()
    {
        $clientsCount = User::whereHas('role', function ($q) {
            $q->where('type', 'expediteur');
        })->count();

        $driversCount = User::whereHas('role', function ($q) {
            $q->where('type', 'chauffeur');
        })->count();

        $totalUsers = $clientsCount + $driversCount;

        $clientsPercent = $totalUsers > 0 ? round(($clientsCount / $totalUsers) * 100) : 0;
        $driversPercent = $totalUsers > 0 ? round(($driversCount / $totalUsers) * 100) : 0;

        $registrations = User::select(
            DB::raw('count(id) as total'),
            DB::raw("DATE_FORMAT(created_at, '%m') as month")
        )
            ->where('created_at', '>=', now()->startOfYear())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyData = [];
        foreach (range(1, 12) as $m) {
            $monthKey = str_pad($m, 2, '0', STR_PAD_LEFT);
            $monthlyData[] = $registrations[$monthKey] ?? 0;
        }

        // 3. Statistiques mensuelles (Demandes, Courses, Revenus)
        $currentMonth = now()->month;

        // Exemple : Nombre de demandes créées ce mois-ci
        $newDemandes = DB::table('demandes')->whereMonth('created_at', $currentMonth)->count();

        // Exemple : Courses terminées
        $completedRides = DB::table('demandes')->where('status', 'delivered')
            ->whereMonth('updated_at', $currentMonth)->count();

        // Exemple : Somme des revenus (si tu as une colonne 'prix' ou 'commission')
        $totalRevenue = DB::table('demandes')->where('status', 'delivered')
            ->whereMonth('updated_at', $currentMonth)->sum('prix_estime');

        // 4. Satisfaction moyenne (Rating)
        // On imagine une table 'reviews' ou une colonne 'rating' dans les courses
        $averageRating = DB::table('evaluations')->avg('note_generale') ?? 4.5;
        // dd( [
        //     'clientsCount' => $clientsCount,
        //     'driversCount' => $driversCount,
        //     'clientsPercent' => $clientsPercent,
        //     'driversPercent' => $driversPercent,
        //     'monthlyData' => $monthlyData,
        //     'newDemandes' => $newDemandes,
        //     'completedRides' => $completedRides,
        //     'totalRevenue' => $totalRevenue,
        //     'averageRating' => number_format($averageRating, 1),
        // ]);
        return view('admin.statistics', [
            'clientsCount' => $clientsCount,
            'driversCount' => $driversCount,
            'clientsPercent' => $clientsPercent,
            'driversPercent' => $driversPercent,
            'monthlyData' => $monthlyData,
            'newDemandes' => $newDemandes,
            'completedRides' => $completedRides,
            'totalRevenue' => $totalRevenue,
            'averageRating' => number_format($averageRating, 1),
        ]);
    }

    public function driverDocuments(Request $request)
    {
        $query = Document::with('chauffeur.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();
        return view('admin.driver-documents', compact('documents'));
    }

    public function verifyDocument(Request $request, Document $document)
    {
        if ($request->has('reject')) {
            $document->update(['status' => 'rejete']);
            return back()->with('success', 'Document rejeté.');
        }
        $document->update(['status' => 'approuve']);
        return back()->with('success', 'Document approuvé avec succès.');
    }

    public function destroyDocument(Document $document)
    {
        // Supprimer le fichier physique
        if (file_exists(public_path($document->chemin))) {
            unlink(public_path($document->chemin));
        }
        $document->delete();
        return back()->with('success', 'Document supprimé.');
    }

    public function sendDocumentMessage(Request $request, Document $document)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chauffeur = $document->chauffeur;
        
        // Pour l'admin, on utilise l'utilisateur connecté ou par défaut l'admin avec ID 1
        $adminId = Auth::check() ? Auth::id() : 1;

        // Créer ou récupérer une conversation
        $conversation = Conversation::firstOrCreate(
            [
                'chauffeur_id' => $chauffeur->id,
                'expediteur_id' => null,
            ],
            [
                'admin_id' => $adminId,
            ]
        );

        // Créer le message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $adminId,
            'sender_type' => 'admin',
            'content' => $request->message,
        ]);

        // Mettre à jour le commentaire admin sur le document
        $document->update(['commentaire_admin' => $request->message]);

        return back()->with('success', 'Message envoyé au chauffeur.');
    }
}
