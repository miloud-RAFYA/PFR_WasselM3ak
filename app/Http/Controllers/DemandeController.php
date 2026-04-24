<?php

namespace App\Http\Controllers;

use App\Http\Requests\Demande\StoreDemandeRequest;
use App\Http\Requests\Demande\UpdateDemandeRequest;
use App\Http\Resources\DemandeCollection;
use App\Http\Resources\DemandeResource;
use App\Models\Demande;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;
        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }
        $ds = Demande::where('expediteur_id', $expediteur->id)
            ->with('offres.chauffeur.user', 'expediteur')
            ->latest()
            ->paginate(10);
        $demandes = new DemandeCollection($ds);
        return view('client.requests.index', compact('demandes'));
    }
    public function create()
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;
        if (!$expediteur) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }
        return view('client.requests.create');
    }
    public function store(StoreDemandeRequest $request)
    {
        $user = Auth::user();
        $expediteur = $user->expediteur;
        $data = $request->validated();
        if ($request->hasFile('image_marchandise')) {
            $data['image_marchandise'] = $request->file('image_marchandise')->store('demandes', 'public');
        }
        $data['expediteur_id'] = $expediteur->id;
        $data['status'] = 'pending';
        $data['reference'] = $data['reference'] ?? 'REF-' . now()->format('YmdHis');
        Demande::create($data);
        return redirect()->route('client.index');
    }
    public function show(Demande $demande)
    {
        $this->authorize('view', $demande);
        $offres = $demande->offres()->get();
        // dd($offres);
        
        $demande = new DemandeResource($demande);
        return view('client.requests.show',compact('demande','offres'));
    }
    public function update(UpdateDemandeRequest $request, Demande $demande)
    {
        $this->authorize('update', $demande);
        $demande->update($request->validated());
        return redirect()->route('client.index');
    }
    public function destroy(Demande $demande)
    {
        $this->authorize('delete', $demande);
        $demande->delete();
        return redirect()->route('client.index');
    }
}
