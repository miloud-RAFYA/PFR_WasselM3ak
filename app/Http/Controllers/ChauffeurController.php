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


class ChauffeurController extends Controller
{
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
    public function index()
    {
        $demandes = Demande::latest()->paginate(10);
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
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (! $chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        return view('driver.vehicle', compact('chauffeur'));
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
}
