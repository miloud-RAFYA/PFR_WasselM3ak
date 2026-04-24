<?php

namespace App\Http\Controllers;
use App\Notifications\OffreAccepteeNotification;
use App\Models\Conversation;
use App\Models\Demande;
use App\Models\Message;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    public function store(Request $request, $id)
    {
        $chauffeur = Auth::user()->chauffeur;

        if (! $chauffeur) {
            return redirect()->route('driver.dashboard')->with('error', 'Accès non autorisé.');
        }
 
        $request->validate([
            'montant_propose' => ['required', 'numeric', 'min:0'],
        ]);

        Offre::create([
            'chauffeur_id' => $chauffeur->id,
            'demande_id' => $id,
            'montant_propose' => $request->input('montant_propose'),
            'status' => 'en attente',
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Offre créée avec succès.');
    }
    public function refuse($id){
       $offre = Offre::findOrFail($id);
        $demande = $offre->demande;

        if ($demande->status !== 'in_progress') {
            return back()->with('error', 'Déjà traitée');
        }

        $offre->update(['status' => 'refusee']);

        $chauffeur = $offre->chauffeur->user;
        $chauffeur->notify(new OffreAccepteeNotification($offre));

        Offre::where('demande_id', $demande->id)
            ->where('id', '!=', $offre->id)
            ->update(['status' => 'refusee']);

        $demande->update([
            'status' => 'pending',
            'prix_final' => $offre->montant_propose,
        ]);
        $conversation=$demande->conversation();
         $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => "Bonjour, j'ai refuse votre offre de {$offre->montant_propose} DH pour la demande {$demande->reference}. Pouvons-nous finaliser les détails ici ?",
            'type' => 'text',
        ]);
  
    }
    public function accepte($id)
    {
        
        $offre = Offre::findOrFail($id);
        $demande = $offre->demande;

        if ($demande->status !== 'pending') {
            return back()->with('error', 'Déjà traitée');
        }

        $offre->update(['status' => 'acceptee']);

        $chauffeur = $offre->chauffeur->user;
        $chauffeur->notify(new OffreAccepteeNotification($offre));

        Offre::where('demande_id', $demande->id)
            ->where('id', '!=', $offre->id)
            ->update(['status' => 'refusee']);

        $demande->update([
            'status' => 'in_progress',
            'prix_final' => $offre->montant_propose,
        ]);

        $conversation = Conversation::firstOrCreate(
            [
                'demande_id' => $demande->id,
                'expediteur_id' => $demande->expediteur_id,
                'chauffeur_id' => $offre->chauffeur_id,
            ],
            [
                'last_message' => 'Offre acceptée — la discussion est créée dans vos messages.',
            ]
        );

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => "Bonjour, j'ai accepté votre offre de {$offre->montant_propose} DH pour la demande {$demande->reference}. Pouvons-nous finaliser les détails ici ?",
            'type' => 'text',
        ]);

        $conversation->update(['last_message' => $message->content]);

        return back()->with('success', 'Offre acceptée et conversation créée dans vos messages.');
    }
    public function createOffre( $id){
        $demande=Demande::findOrFail($id);
        return view('driver.offres.create',compact('demande'));
    }
}
