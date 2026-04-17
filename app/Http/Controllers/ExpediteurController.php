<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use App\Models\Conversation;
use App\Models\Demande;
use App\Models\Message;
use App\Models\Offre;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpediteurController extends Controller
{
    /**
     * Dashboard du client
     */
    public function dashboard()
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;
        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }
        $demandes = Demande::where('expediteur_id', $expediteur->id)->with('offres.chauffeur.user')->get();
        $demandesRecentes = $demandes->sortByDesc('created_at')->take(5);
        $chauffeursDisponibles = Chauffeur::where('is_available', true)
            ->with('user', 'vehicule')
            ->orderByDesc('note_moyenne')
            ->limit(3)
            ->get();

        $economiesRealisees = 0;
        $demandesLivrees = $demandes->where('status', 'delivered');
        foreach ($demandesLivrees as $demande) {
            if ($demande->prix_estime && $demande->prix_final) {
                $economiesRealisees += max(0, $demande->prix_estime - $demande->prix_final);
            }
        }

        $messagesNonLus = 0;

        $stats = [
            'total_demandes' => $demandes->count(),
            'demandes_pending' => $demandes->where('status', 'pending')->count(),
            'demandes_in_progress' => $demandes->where('status', 'in_progress')->count(),
            'demandes_delivered' => $demandes->where('status', 'delivered')->count(),
            'total_offres_recues' => $demandes->pluck('offres')->flatten()->count(),
            'messages_non_lus' => $messagesNonLus,
            'economies_realisees' => round($economiesRealisees, 2),
        ];

        return view('client.dashboard', compact('expediteur', 'demandes', 'demandesRecentes', 'chauffeursDisponibles', 'stats'));
    }

    public function requestsSuiviGps(Request $request)
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;

        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $demandes = Demande::where('expediteur_id', $expediteur->id)
            ->where('status', 'in_progress')
            ->with(['offres.chauffeur.user', 'suivres'])
            ->latest()
            ->paginate(10);

        $selectedDemande = $demandes->first();
        $selectedDemandeId = $request->query('demande_id');

        if ($selectedDemandeId) {
            $selectedDemande = $demandes->firstWhere('id', $selectedDemandeId) ?? $selectedDemande;
        }

        return view('client.requests.suivi-gps', compact('demandes', 'selectedDemande'));
    }

    public function messages()
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;

        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $conversations = Conversation::where('expediteur_id', $expediteur->id)
            ->with(['chauffeur.user', 'demande', 'messages.sender'])
            ->orderByDesc('updated_at')
            ->get();

        return view('client.messages.index', compact('conversations'));
    }

    public function showConversation(Conversation $conversation)
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;

        if (!$expediteur || $conversation->expediteur_id !== $expediteur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $conversation->load(['chauffeur.user', 'demande', 'messages.sender']);

        return view('client.messages.show', compact('conversation'));
    }

    public function getMessages(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;

        if (!$expediteur || $conversation->expediteur_id !== $expediteur->id) {
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
        $expediteur = $user->expediteur;

        if (!$expediteur || $conversation->expediteur_id !== $expediteur->id) {
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

    /**
     * Afficher le profil du client
     */
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
        $expediteur = $user->expediteur;

        if (!$expediteur) {
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

        $expediteur->update([
            'adresse_principale' => $validated['adresse_principale'] ?? $expediteur->adresse_principale,
        ]);

        return redirect()
            ->route('profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
