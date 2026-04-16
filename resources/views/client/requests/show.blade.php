@extends('layouts.dashboard')

@section('title', 'Détails de la demande')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('page-title', 'Détails de la demande')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                {{ $demande->ville_depart }} → {{ $demande->ville_arrive }}
            </h1>
            <p class="text-slate-500 mt-1">
                Référence: {{ $demande->reference }}
            </p>
        </div>

        <a href="{{ route('client.index') }}"
            class="flex items-center gap-2 px-4 py-3 border rounded-lg hover:bg-slate-50">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            Retour
        </a>
    </div>

    @if($demande->image_marchandise)
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <img src="{{ asset('storage/' . $demande->image_marchandise) }}"
                 alt="Image de la marchandise"
                 class="w-full h-80 object-cover">
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- INFOS --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold mb-4">Informations</h3>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-slate-500">Type</p>
                        <p class="font-medium">{{ $demande->type_marchendise }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Poids</p>
                        <p class="font-medium">{{ $demande->poids_kg }} kg</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Prix estimé</p>
                        <p class="font-medium">{{ $demande->prix_estime }} DH</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Statut</p>

                        @if($demande->status === 'pending')
                            <span class="px-3 py-1 text-xs border border-primary-500 text-primary-500 rounded-full">
                                En attente
                            </span>
                        @elseif($demande->status === 'in_progress')
                            <span class="px-3 py-1 text-xs bg-blue-500 text-white rounded-full">
                                En cours
                            </span>
                        @elseif($demande->status === 'delivered')
                            <span class="px-3 py-1 text-xs bg-green-500 text-white rounded-full">
                                Livrée
                            </span>
                        @endif

                    </div>

                </div>
            </div>

            {{-- OFFRES --}}
            <div class="bg-white rounded-xl shadow-sm p-6">

                <h3 class="font-semibold mb-4">
                    Offres ({{ $demande->offres->count() }})
                </h3>

                @forelse($offres as $offre)

                <div class="border rounded-lg p-4 mb-3">

                    <div class="flex justify-between items-center mb-3">

                        {{-- DRIVER --}}
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 text-white flex items-center justify-center rounded-full">
                                {{ strtoupper(substr($offre->chauffeur->user->prenom,0,1)) }}
                            </div>

                            <div>
                                <p class="font-medium">
                                    {{ $offre->chauffeur->user->prenom }}
                                    {{ $offre->chauffeur->user->nom }}
                                </p>
                                <p class="text-sm text-slate-500">
                                    {{ $offre->chauffeur->total_livraisons }} livraisons
                                </p>
                            </div>
                        </div>

                        {{-- PRICE --}}
                        <div class="text-right">
                            <p class="text-lg font-bold text-primary-500">
                                {{ $offre->montant_propose }} DH
                            </p>
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex justify-between items-center border-t pt-3">

                        <span class="text-xs px-2 py-1 bg-slate-100 rounded">
                            {{ ucfirst($offre->status) }}
                        </span>

                        @if($demande->status === 'pending')
                        <form method="POST" action="{{ route('offre.accepte', $offre->id) }}">
                            @csrf

                            <button type="submit"
                                class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm">
                                Accepter
                            </button>
                        </form>
                        @endif

                    </div>

                </div>

                @empty
                <p class="text-center text-slate-500 py-6">
                    Aucune offre pour le moment
                </p>
                @endforelse

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="font-semibold mb-4">Résumé</h4>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span>Départ</span>
                        <span>{{ $demande->ville_depart }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Arrivée</span>
                        <span>{{ $demande->ville_arrive }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Offres</span>
                        <span class="text-primary-500 font-bold">
                            {{ $demande->offres->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Meilleur prix</span>
                        <span class="text-primary-500 font-bold">
                            {{ $demande->offres->min('montant_propose') ?? '-' }}
                        </span>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection