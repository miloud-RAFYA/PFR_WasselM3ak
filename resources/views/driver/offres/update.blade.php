@extends('layouts.dashboard')

@section('title', 'Modifier mon offre')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'my_offers']) {{-- Adapté pour l'onglet des offres du chauffeur --}}
@endsection

@section('page-title', 'Modifier la proposition')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        {{-- Header avec dégradé subtil pour différencier de la création --}}
        <div class="bg-slate-50 border-b border-slate-200 px-8 py-6">
            <div class="flex items-start justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Modifier votre offre</h2>
                    <p class="text-sm text-slate-500 mt-1">Vous pouvez ajuster votre prix tant que l'offre n'a pas été acceptée.</p>
                </div>
                {{-- <a href="{{ route('driver.offres.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-700 transition-colors shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Mes offres
                </a> --}}
            </div>
        </div>

        <div class="p-8">
            {{-- Rappel des détails du trajet --}}
            <div class="grid gap-6 md:grid-cols-2 mb-10">
                <div class="p-5 bg-primary-50/30 rounded-2xl border border-primary-100">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-2 bg-primary-500 rounded-lg text-white">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-primary-600">Détails du Trajet</p>
                    </div>
                    <p class="text-xl font-bold text-slate-900">{{ $offre->demande->ville_depart }} <span class="text-primary-400 mx-2">→</span> {{ $offre->demande->ville_arrive }}</p>
                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-500">Marchandise:</span>
                            <p class="font-semibold text-slate-900">{{ $offre->demande->type_marchendise }}</p>
                        </div>
                        <div>
                            <span class="text-slate-500">Poids:</span>
                            <p class="font-semibold text-slate-900">{{ $offre->demande->poids_kg }} kg</p>
                        </div>
                    </div>
                </div>

                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-2 bg-slate-200 rounded-lg text-slate-600">
                            <i data-lucide="info" class="w-4 h-4"></i>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Info Demande</p>
                    </div>
                    <p class="text-lg font-bold text-slate-900">Réf: {{ $offre->demande->reference ?? 'N/A' }}</p>
                    <div class="mt-4">
                        <span class="text-slate-500 text-sm">Budget estimé du client:</span>
                        <p class="text-lg font-bold text-emerald-600">{{ number_format($offre->demande->prix_estime, 2) }} DH</p>
                    </div>
                </div>
            </div>
    
            {{-- Formulaire de modification --}}
            <form action="{{ route('driver.offres.edit', $offre->id) }}" method="POST" class="max-w-2xl mx-auto space-y-8">
                @csrf
                @method('PUT') {{-- CRUCIAL pour Laravel --}}

                @if ($errors->any())
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-sm text-red-700 flex gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label for="montant_propose" class="text-sm font-bold text-slate-700">Votre nouveau prix (DH)</label>
                        <div class="relative">
                            <input id="montant_propose" name="montant_propose" type="number" step="0.01" 
                                   value="{{ old('montant_propose', $offre->montant_propose) }}" 
                                   class="w-full pl-12 pr-4 py-4 border-2 border-slate-200 rounded-2xl focus:border-primary-500 focus:ring-0 transition-all text-lg font-bold text-slate-900" 
                                   required>
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">DH</span>
                        </div>
                        <p class="text-xs text-slate-500 italic">Ancien montant : {{ number_format($offre->montant_propose, 2) }} DH</p>
                    </div>

                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-4">
                        <i data-lucide="shield-alert" class="w-6 h-6 text-amber-500 shrink-0"></i>
                        <p class="text-xs text-amber-800 leading-relaxed">
                            <strong>Note :</strong> Modifier votre offre pourrait vous faire remonter ou descendre dans la liste des propositions vues par le client. Soyez compétitif !
                        </p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-4 items-center justify-end">
                    {{-- {{ route('driver.offres.c') }} --}}
                    <a href="" class="w-full sm:w-auto px-8 py-4 text-slate-600 font-semibold hover:text-slate-900 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-primary-500 hover:bg-primary-600 text-white rounded-2xl font-bold shadow-lg shadow-primary-500/30 transition-all hover:-translate-y-0.5 active:translate-y-0">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection