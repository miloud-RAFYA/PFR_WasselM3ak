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
use App\Events\MessageSent;
use App\Events\UserTyping;


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
            'courses_ce_mois' => $acceptedOffers->count(),
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
    public function toggleAvailability()
    {
        $chauffeur =  Auth::user()->chauffeur;
        $chauffeur->is_available = !$chauffeur->is_available;
        $chauffeur->save();

        return back()->with('success', 'Statut mis à jour');
    }
    public function index()
    {
        $demandes = Demande::latest()->paginate(10);
        return view('driver.available', compact('demandes'));
    }

    public function trips()
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (! $chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $courses = Offre::with(['demande.expediteur.user'])
            ->where('chauffeur_id', $chauffeur->id)
            ->latest()
            ->get();

        return view('driver.trips.index', compact('courses'));
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

    public function updateVehicle(Request $request)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (! $chauffeur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $request->validate([
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'license_plate' => 'nullable|string|max:50',
            'year' => 'nullable|integer|min:1900|max:' . now()->year,
            'capacity' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
        ]);

        return back()->with('success', 'Informations du véhicule mises à jour.');
    }

    public function store() {}

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

    public function getMessages(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur || $conversation->chauffeur_id !== $chauffeur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $perPage = $request->query('per_page', 20);

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'conversation_id' => $message->conversation_id,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->prenom ?? $message->sender->name ?? 'Utilisateur',
                    'content' => $message->content,
                    'type' => $message->type,
                    'is_read' => $message->is_read,
                    'time' => $message->created_at->format('H:i'),
                ];
            })->values(),
            'next_page_url' => $messages->nextPageUrl(),
            'current_page' => $messages->currentPage(),
        ]);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $chauffeur = $user->chauffeur;

        if (!$chauffeur || $conversation->chauffeur_id !== $chauffeur->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
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
            \Log::warning('Broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'id' => $message->id,
            'content' => $message->content,
            'sender_id' => $message->sender_id,
            'time' => $message->created_at->format('H:i'),
        ]);
    }
