@extends('layouts.dashboard')

@section('title', 'Créer une offre')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'available'])
@endsection

@section('page-title', 'Proposer une offre')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between gap-6 mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">Demande de transport</h2>
                <p class="text-sm text-slate-500">Complétez votre proposition pour cette demande.</p>
            </div>
            <a href="{{ route('driver.available') }}" class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-700">Retour aux demandes</a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 mb-8">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <p class="text-sm text-slate-500 uppercase tracking-wide">Trajet</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</p>
                <p class="mt-3 text-sm text-slate-600">Type de marchandise: <span class="font-medium text-slate-900">{{ $demande->type_marchendise }}</span></p>
                <p class="mt-1 text-sm text-slate-600">Poids estimé: <span class="font-medium text-slate-900">{{ $demande->poids_kg }} kg</span></p>
                <p class="mt-1 text-sm text-slate-600">Prix estimé: <span class="font-medium text-slate-900">{{ $demande->prix_estime }} DH</span></p>
            </div>
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <p class="text-sm text-slate-500 uppercase tracking-wide">Référence</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $demande->reference ?? 'N/A' }}</p>
                <p class="mt-3 text-sm text-slate-600">Statut de la demande: <span class="font-medium text-slate-900">{{ ucfirst(str_replace('_', ' ', $demande->status)) }}</span></p>
            </div>
        </div>

        <form action="{{ route('driver.offres.store', $demande->id) }}" method="POST" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="montant_propose" class="text-sm font-medium text-slate-700">Montant proposé (DH)</label>
                    <input id="montant_propose" name="montant_propose" type="number" step="0.01" value="{{ old('montant_propose') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Statut de l'offre</label>
                    <div class="px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-700">en attente</div>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('driver.available') }}" class="px-6 py-3 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50">Annuler</a>
                <button type="submit" class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium">Envoyer l'offre</button>
            </div>
        </form>
    </div>
</div>
@endsection
