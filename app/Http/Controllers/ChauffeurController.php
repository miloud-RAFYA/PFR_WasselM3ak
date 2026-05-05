<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chauffeur;
use App\Models\Conversation;
use App\Models\Demande;
use App\Models\Message;
use App\Models\Offre;
use Carbon\Month;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\MessageSent;
use App\Events\UserTyping;
use App\Http\Requests\Vehicule\StoreRequest;
use App\Models\Vehicule;

class ChauffeurController extends Controller
{
       public function profile()
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;

        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        return view('client.profile.edit', compact('user', 'expediteur'));
    }

    /**
     * Mettre à jour le profil
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'adresse_principale' => 'nullable|string|max:500',
        ]);

        $user->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);


        return redirect()
            ->route('profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }
    public function dashboard()
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (! $chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $offres = Offre::with('demande')
            ->where('chauffeur_id', $chauffeur->id)
            ->latest()
            ->get();

        $acceptedOffers = $offres->where('status', 'acceptee');
        $pendingOffers = $offres->where('status', 'en attente');
        $monthlyOffers = $acceptedOffers->filter(fn($offre) => $offre->created_at->isCurrentMonth());

        $stats = [
            'courses_ce_mois' => $acceptedOffers->filter(fn($offre) => $offre->created_at->isCurrentMonth())->count(),
            'offres_en_attente' => $pendingOffers->count(),
            'gains_ce_mois' => $monthlyOffers->sum('montant_propose'),
            'revenu_total' => $acceptedOffers->sum('montant_propose'),
        ];

        $demandes = Demande::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('driver.dashboard', compact(
            'chauffeur',
            'offres',
            'stats',
            'demandes'
        ));
    }
    public function available(Request $request)
    {
        // Récupérer le chauffeur connecté pour éviter de lui montrer ses propres demandes
        $chauffeur = Auth::user()->chauffeur;
        
        // Construire la requête de base (demandes en attente uniquement)
        $query = Demande::where('status', 'pending')
            ->with(['offres']) // Charger les offres pour compter
        
            // Exclure les demandes où le chauffeur a déjà proposé une offre
            ->whereDoesntHave('offres', function($q) use ($chauffeur) {
                $q->where('chauffeur_id', $chauffeur->id);
            });
        
        // 🔍 RECHERCHE PAR VILLE
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ville_depart', 'like', "%{$search}%")
                  ->orWhere('ville_arrive', 'like', "%{$search}%");
            });
        }
        
        // 🏷️ FILTRE PAR TYPE DE MARCHANDISE
        if ($request->filled('type')) {
            $query->where('type_marchendise', $request->type);
        }
        
        // ⚖️ FILTRE PAR POIDS MAX
        if ($request->filled('poids')) {
            $query->where('poids_kg', '<=', $request->poids);
        }
        
        // 💰 FILTRE PAR PRIX MAX
        if ($request->filled('prix')) {
            $query->where('prix_estime', '<=', $request->prix);
        }
        
        $demandes = $query->orderBy('created_at', 'desc')
                          ->paginate(9)
                          ->appends($request->query()); // Conserver les filtres dans la pagination
        
        return view('driver.available', compact('demandes'));
    }
    public function toggleAvailability()
    {
        $chauffeur =  Auth::user()->chauffeur;
        $chauffeur->is_available = !$chauffeur->is_available;
        $chauffeur->save();

        return back()->with('success', 'Statut mis à jour');
    }

    public function trips()
    {
        $chauffeur = Auth::user()->chauffeur;

        if (!$chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        // On charge toutes les offres avec les relations nécessaires
        $allOffres = Offre::with(['demande.expediteur.user'])
            ->where('chauffeur_id', $chauffeur->id)
            ->latest()
            ->get();

        // On sépare en deux collections via la méthode filter() de Laravel (en mémoire)
        // 1. Les missions où le client a dit "OUI"
        $acceptedCourses = $allOffres->where('status', 'acceptee');

        // 2. Les offres où on attend encore le client
        $pendingOffers = $allOffres->where('status', 'en attente');

        // On identifie s'il y a un trajet en cours pour activer le script GPS
        $activeCourse = $acceptedCourses->first(fn($c) => optional($c->demande)->status === 'in_progress');

        return view('driver.trips.index', compact(
            'acceptedCourses',
            'pendingOffers',
            'activeCourse'
        ));
    }

    public function vehicle()
    {

        $chauffeur = Auth::user()->chauffeur;
        $vehicule = $chauffeur->vehicule ?? new Vehicule(); // utilise la relation
        return view('driver.vehicle', compact('vehicule'));
    }

    public function updateVehicle(StoreRequest $request)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (! $chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $data = $request->validated();
        $chauffeur->vehicule()->update($data);
        return view('driver.vehicle', compact('chauffeur'));
    }

    public function messages()
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $conversations = Conversation::where('chauffeur_id', $chauffeur->id)
            ->with(['expediteur.user', 'demande', 'messages.sender'])
            ->orderByDesc('updated_at')
            ->get();

        return view('driver.messages.index', compact('conversations'));
    }

    public function showConversation(Conversation $conversation)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur || $conversation->chauffeur_id !== $chauffeur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $conversation->load(['expediteur.user', 'demande', 'messages.sender']);

        return view('driver.messages.show', compact('conversation'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur || $conversation->chauffeur_id !== $chauffeur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $request->input('content'),
            'type' => 'text',
        ]);

        $conversation->update([
            'last_message' => $message->content,
        ]);

        $conversation->touch();

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            Log::warning('Broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'id' => $message->id,
            'content' => $message->content,
            'sender_id' => $message->sender_id,
            'time' => $message->created_at->format('H:i'),
        ]);
    }
    public function marquerLivree(Demande $demande)
    {
        // Vérifier que le chauffeur est bien assigné à cette demande
        $offre = $demande->offres()->where('chauffeur_id', Auth::user()->chauffeur->id)
            ->where('status', 'acceptee')->first();
        if (!$offre) {
            return back()->with('error', 'Action non autorisée.');
        }

        // Vérifier que la demande est bien en cours
        if ($demande->status !== 'in_progress') {
            return back()->with('error', 'Impossible de livrer une demande non en cours.');
        }

        // Mettre à jour les statuts
        $demande->update(['status' => 'delivered']);
        $offre->update(['status' => 'livree']); // ou 'completed'

        // Optionnel : enregistrer la date de livraison effective
        // $demande->update(['delivered_at' => now()]);

        // Notifier le client (via notification ou event)
        // event(new DemandeLivree($demande));

        return redirect()->route('driver.trips')->with('success', 'Livraison confirmée. Merci !');
    }
  
}
