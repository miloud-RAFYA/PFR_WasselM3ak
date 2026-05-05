@extends('layouts.dashboard')

@section('title', 'Offres acceptées')

@section('sidebar')
    @include('client.partials.sidebar', ['active' => 'accepted_offers'])
@endsection

@section('content')
    <div class="space-y-8">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Offres acceptées</h1>
                <p class="text-slate-500 mt-1">
                    Retrouvez ici toutes les offres que vous avez acceptées
                </p>
            </div>
            <a href="{{ route('client.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition shadow-md hover:shadow-lg">
                <i data-lucide="package" class="w-4 h-4"></i>
                Voir mes demandes
            </a>
        </div>

        {{-- Filtres --}}
        <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-4">
            <a href="{{ route('client.accepted_offers') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all
                  {{ !request('status') ? 'bg-primary-500 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-primary-300' }}">
                <i data-lucide="list" class="w-4 h-4"></i>
                Toutes
            </a>
            <a href="{{ route('client.accepted_offers', ['status' => 'in_progress']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all
                  {{ request('status') == 'in_progress' ? 'bg-sky-500 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-sky-300' }}">
                <i data-lucide="truck" class="w-4 h-4"></i>
                En cours
            </a>
            <a href="{{ route('client.accepted_offers', ['status' => 'delivered']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all
                  {{ request('status') == 'delivered' ? 'bg-emerald-500 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-300' }}">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Livrées
            </a>
        </div>

        @if ($acceptedOffres->count())
            <div class="space-y-4">
                @foreach ($acceptedOffres as $offre)
                    @php
                        $demande = $offre->demande;
                        $status = $demande->status;
                        $statusConfig = [
                            'in_progress' => [
                                'bg' => 'bg-sky-100 text-sky-700',
                                'icon' => 'truck',
                                'label' => 'En cours',
                            ],
                            'delivered' => [
                                'bg' => 'bg-emerald-100 text-emerald-700',
                                'icon' => 'check-circle',
                                'label' => 'Livrée',
                            ],
                            'pending' => [
                                'bg' => 'bg-amber-100 text-amber-700',
                                'icon' => 'clock',
                                'label' => 'En attente',
                            ],
                        ];
                        $statusInfo = $statusConfig[$status] ?? [
                            'bg' => 'bg-slate-100 text-slate-700',
                            'icon' => 'circle',
                            'label' => ucfirst($status),
                        ];
                    @endphp

                    <div
                        class="bg-white rounded-2xl shadow-soft border border-slate-200 overflow-hidden hover:shadow-md transition-all">
                        <div class="p-6">
                            {{-- Entête : trajet, statut, référence --}}
                            <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                                <div>
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                                        <i data-lucide="hash" class="w-4 h-4"></i>
                                        <span class="font-mono">{{ $demande->reference }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2 flex-wrap">
                                        {{ $demande->ville_depart }}
                                        <i data-lucide="arrow-right" class="w-4 h-4 text-primary-500"></i>
                                        {{ $demande->ville_arrive }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusInfo['bg'] }}">
                                        <i data-lucide="{{ $statusInfo['icon'] }}" class="w-3.5 h-3.5"></i>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Grille d'infos : chauffeur, prix, date --}}
                            <div class="grid md:grid-cols-4 gap-4 mb-5">
                                {{-- Chauffeur --}}
                                <div class="flex items-center gap-3 bg-slate-50 rounded-xl p-3 md:col-span-1">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ strtoupper(substr($offre->chauffeur->user->prenom ?? 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $offre->chauffeur->user->prenom }}
                                            {{ $offre->chauffeur->user->nom }}</p>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <span class="flex items-center gap-1"><i data-lucide="truck"
                                                    class="w-3 h-3"></i> {{ $offre->chauffeur->total_livraisons ?? 0 }}
                                                courses</span>
                                            <span class="flex items-center gap-1"><i data-lucide="star"
                                                    class="w-3 h-3 text-amber-500"></i>
                                                {{ number_format($offre->chauffeur->note_moyenne ?? 0, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Prix accepté --}}
                                <div class="bg-slate-50 rounded-xl p-3 flex items-center gap-3 md:col-span-1">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-primary-500"></i>
                                    <div>
                                        <p class="text-xs text-slate-500">Montant accepté</p>
                                        <p class="text-xl font-bold text-primary-600">
                                            {{ number_format($offre->montant_propose, 0, ',', ' ') }} DH</p>
                                    </div>
                                </div>
                                {{-- Date d'acceptation --}}
                                <div class="bg-slate-50 rounded-xl p-3 flex items-center gap-3 md:col-span-1">
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-primary-500"></i>
                                    <div>
                                        <p class="text-xs text-slate-500">Acceptée le</p>
                                        <p class="font-semibold text-slate-800">{{ $offre->updated_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-slate-400">{{ $offre->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                {{-- Bouton Refuser (si demande en cours) --}}
                                @if ($demande->status === 'in_progress')
                                    <div class="flex items-center justify-end md:col-span-1">
                                        <form method="POST" action="{{ route('client.offre.refuse', $offre->id) }}"
                                            onsubmit="return confirm('⚠️ Attention : refuser cette offre annulera l’acceptation et remettra la demande en attente. Voulez-vous continuer ?');">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition shadow-md hover:shadow-lg text-sm font-medium flex items-center gap-2">
                                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                                Refuser l'offre
                                            </button>
                                        </form>
                                        {{-- Dans la carte de chaque offre acceptée --}}
                                        <div class="flex flex-wrap items-center gap-3 mt-3 pt-3 border-t">
                                            @php
                                                $paiement = $demande->paiements()->first(); // ou dernierPaiement()
                                            @endphp

                                            @if ($demande->status == 'delivered' && (!$paiement || $paiement->status == 'unpaid'))
                                                <a href="{{ route('client.paiement.show', $demande) }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-xl text-sm font-medium hover:bg-primary-600 transition">
                                                    <i data-lucide="credit-card" class="w-4 h-4"></i> Payer cette livraison
                                                </a>
                                            @elseif($paiement && in_array($paiement->status, ['paid', 'confirmed']))
                                                <span
                                                    class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full text-sm">
                                                    <i data-lucide="check-circle" class="w-4 h-4"></i> Payé
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($demande->status === 'delivered')
                                    <div class="flex items-center justify-end md:col-span-1">
                                        <span class="text-xs text-slate-400 italic">Livraison terminée</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Message du chauffeur --}}
                            @if ($offre->message)
                                <div
                                    class="mb-4 p-3 bg-slate-50 rounded-xl text-sm text-slate-600 border-l-4 border-primary-500">
                                    <i data-lucide="message-circle"
                                        class="w-4 h-4 inline mr-1 text-primary-500 align-middle"></i>
                                    {{ $offre->message }}
                                </div>
                            @endif

                            <div class="flex justify-end border-t border-slate-100 pt-4">
                                <a href="{{ route('client.requests.show', $demande) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors">
                                    Voir la demande
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $acceptedOffres->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-12 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-slate-100 rounded-full mb-6">
                    <i data-lucide="handshake" class="w-12 h-12 text-slate-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Aucune offre acceptée</h3>
                <p class="text-slate-500 max-w-md mx-auto">
                    Vous n’avez encore accepté aucune offre.
                </p>
                <div class="mt-6">
                    <a href="{{ route('client.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition shadow-md">
                        <i data-lucide="package" class="w-4 h-4"></i>
                        Voir mes demandes
                    </a>
                </div>
            </div>
        @endif

    </div>
@endsection

@push('styles')
    <style>
        .shadow-soft {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.02);
        }
    </style>
@endpush
