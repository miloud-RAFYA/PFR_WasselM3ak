@extends('layouts.dashboard')

@section('title', 'Créer une offre')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'available'])
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- En-tête --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Créer une offre</h1>
            <p class="text-slate-500 mt-1">Proposez votre service pour cette demande de transport</p>
        </div>
        <a href="{{ route('driver.available') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-slate-700">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Retour aux demandes
        </a>
    </div>

    {{-- Carte principale --}}
    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 overflow-hidden">
        {{-- En-tête de la carte --}}
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5 text-primary-500"></i>
                Détails de la demande
            </h2>
        </div>

        {{-- Informations de la demande --}}
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Colonne gauche --}}
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Trajet</p>
                            <p class="text-lg font-bold text-slate-900">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="package" class="w-5 h-5 text-primary-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Type de marchandise</p>
                            <p class="font-medium text-slate-800">{{ $demande->type_marchendise }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="weight" class="w-5 h-5 text-primary-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Poids estimé</p>
                            <p class="font-medium text-slate-800">{{ $demande->poids_kg }} kg</p>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite --}}
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="hash" class="w-5 h-5 text-primary-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Référence</p>
                            <p class="font-mono font-medium text-slate-800">{{ $demande->reference ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="calendar" class="w-5 h-5 text-primary-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Date de publication</p>
                            <p class="font-medium text-slate-800">{{ $demande->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="dollar-sign" class="w-5 h-5 text-primary-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Prix estimé par le client</p>
                            <p class="font-bold text-primary-600">{{ number_format($demande->prix_estime, 0, ',', ' ') }} DH</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire d'offre --}}
        <div class="border-t border-slate-200 bg-white px-6 py-6">
            <h3 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="gavel" class="w-5 h-5 text-primary-500"></i>
                Votre proposition
            </h3>

            <form action="{{ route('driver.offres.store', $demande->id) }}" method="POST" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</p>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label for="montant_propose" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Montant proposé (DH) *
                        </label>
                        <div class="relative">
                            <i data-lucide="dollar-sign" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="number" step="10" name="montant_propose" id="montant_propose"
                                   value="{{ old('montant_propose') }}"
                                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                   placeholder="ex: 750" required>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Proposez un prix qui vous semble juste (le client a estimé {{ number_format($demande->prix_estime, 0, ',', ' ') }} DH).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Statut de l'offre</label>
                        <div class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>En attente de validation</span>
                        </div>
                    </div>
                </div>

                {{-- Message optionnel (bonne pratique) --}}
                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Message au client (optionnel)
                    </label>
                    <textarea id="message" name="message" rows="3"
                              class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 transition"
                              placeholder="Ajoutez un petit mot pour rassurer le client (délai, équipement, expérience...)">{{ old('message') }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <a href="{{ route('driver.available') }}"
                       class="flex-1 text-center py-3 border border-slate-200 rounded-xl font-medium text-slate-600 hover:bg-slate-50 transition">
                        Annuler
                    </a>
                    <button type="submit"
                            class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold shadow-md transition-all flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        Envoyer l'offre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .shadow-soft {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
    }
    input:focus, textarea:focus {
        outline: none;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush