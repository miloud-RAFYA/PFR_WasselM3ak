@extends('layouts.dashboard')

@section('title', 'Mes demandes')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('content')
<div class="space-y-8">
    <!-- Header avec bouton retour si nécessaire -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            @if(request()->has('from') && request('from') === 'show')
            <a href="{{ route('client.index', request()->except(['from', 'page'])) }}" 
               class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Retour
            </a>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Mes demandes</h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-sm font-medium">
                        <i data-lucide="package" class="w-4 h-4"></i>
                        {{ $demandes->total() }} demande(s)
                    </span>
                </div>
            </div>
        </div>
        <a href="{{ route('client.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Nouvelle demande
        </a>
    </div>

    <!-- Filtres avec conservation des paramètres -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('client.index', request()->except(['status', 'page'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ !request('status') ? 'bg-primary-500 text-white shadow-md shadow-primary-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            <i data-lucide="list" class="w-4 h-4"></i>
            Toutes
        </a>
        <a href="{{ route('client.index', array_merge(request()->except(['page']), ['status' => 'pending'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            <i data-lucide="clock" class="w-4 h-4"></i>
            En attente
        </a>
        <a href="{{ route('client.index', array_merge(request()->except(['page']), ['status' => 'in_progress'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'in_progress' ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            <i data-lucide="truck" class="w-4 h-4"></i>
            En cours
        </a>
        <a href="{{ route('client.index', array_merge(request()->except(['page']), ['status' => 'delivered'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'delivered' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            Livrées
        </a>
    </div>

    @if($demandes->count())
    <!-- Grille des demandes -->
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($demandes as $demande)
        @php
            $statusColors = [
                'delivered' => ['bg' => 'bg-emerald-500', 'text' => 'Livrée', 'icon' => 'check-circle'],
                'in_progress' => ['bg' => 'bg-sky-500', 'text' => 'En cours', 'icon' => 'truck'],
                'pending' => ['bg' => 'bg-amber-500', 'text' => 'En attente', 'icon' => 'clock'],
                'cancelled' => ['bg' => 'bg-red-500', 'text' => 'Annulée', 'icon' => 'x-circle'],
            ];
            $status = $statusColors[$demande->status] ?? ['bg' => 'bg-slate-500', 'text' => ucfirst($demande->status), 'icon' => 'circle'];
        @endphp
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
            <!-- Badge statut -->
            <div class="absolute top-4 right-4 z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg {{ $status['bg'] }} text-white text-xs font-semibold uppercase tracking-wide shadow-lg">
                    <i data-lucide="{{ $status['icon'] }}" class="w-3.5 h-3.5"></i>
                    {{ $status['text'] }}
                </span>
            </div>

            <!-- Image section -->
            <div class="relative h-52 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                <img src="{{ $demande->image_marchandise ? asset('storage/' . $demande->image_marchandise) : asset('images/packages.png') }}" 
                     alt="{{ $demande->type_marchendise }}" 
                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                
                <div class="absolute bottom-4 left-4 right-4">
                    <div class="flex items-center justify-between text-white">
                        <span class="text-xs font-medium uppercase tracking-wider bg-white/20 backdrop-blur-sm px-2 py-1 rounded-lg">
                            {{ $demande->type_marchendise }}
                        </span>
                        <span class="text-xs font-medium uppercase tracking-wider bg-white/20 backdrop-blur-sm px-2 py-1 rounded-lg">
                            {{ $demande->poids_kg }} kg
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-5 space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Référence</p>
                        <button onclick="copyToClipboard('{{ $demande->reference }}')" 
                                class="text-slate-400 hover:text-primary-500 transition-colors">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    <p class="text-lg font-bold text-slate-900 font-mono">{{ $demande->reference }}</p>
                    
                    <div class="mt-4 flex items-center justify-between bg-slate-50 rounded-xl p-3">
                        <div class="text-center flex-1">
                            <i data-lucide="map-pin" class="w-4 h-4 text-primary-500 mx-auto mb-1"></i>
                            <p class="text-xs text-slate-500">Départ</p>
                            <p class="font-semibold text-slate-800 text-sm">{{ $demande->ville_depart }}</p>
                        </div>
                        <div class="flex-1 text-center">
                            <div class="relative">
                                <div class="w-full h-0.5 bg-primary-200 my-2"></div>
                                <i data-lucide="arrow-right" class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4 h-4 text-primary-500 bg-white rounded-full"></i>
                            </div>
                        </div>
                        <div class="text-center flex-1">
                            <i data-lucide="flag" class="w-4 h-4 text-primary-500 mx-auto mb-1"></i>
                            <p class="text-xs text-slate-500">Arrivée</p>
                            <p class="font-semibold text-slate-800 text-sm">{{ $demande->ville_arrive }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-3">
                        <p class="text-xs text-slate-500 mb-1">Montant</p>
                        <p class="text-xl font-bold text-primary-600">
                            {{ number_format($demande->prix_final ?? $demande->prix_estime, 0, ',', ' ') }} DH
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-3">
                        <p class="text-xs text-slate-500 mb-1">Créé le</p>
                        <p class="text-base font-semibold text-slate-800">{{ $demande->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-slate-400">{{ $demande->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-2">
                        <i data-lucide="gavel" class="w-4 h-4 text-amber-500"></i>
                        <span class="text-sm text-slate-600">
                            <strong class="text-slate-900">{{ $demande->offres->count() }}</strong> offre(s)
                        </span>
                    </div>
                    <a href="{{ route('client.requests.show', ['demande' => $demande, 'from' => 'index', 'page' => request('page', 1), 'status' => request('status')]) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5">
                        Détails
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination stylisée avec conservation des paramètres -->
    <div class="mt-8">
        @if($demandes->hasPages())
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="text-sm text-slate-600">
                Affichage de <span class="font-semibold">{{ $demandes->firstItem() }}</span> à 
                <span class="font-semibold">{{ $demandes->lastItem() }}</span> sur 
                <span class="font-semibold">{{ $demandes->total() }}</span> demandes
            </div>
            <div class="flex gap-2">
                {{ $demandes->appends(request()->except('page'))->links() }}
            </div>
        </div>
        @endif
    </div>
    
    @else
    <!-- Empty state -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full mb-6">
            <i data-lucide="inbox" class="w-12 h-12 text-slate-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-slate-900 mb-2">Aucune demande trouvée</h3>
        <p class="text-slate-500 mb-6 max-w-md mx-auto">
            @if(request('status'))
                Aucune demande avec le statut "{{ request('status') }}" n'a été trouvée.
            @else
                Vous n'avez pas encore de demande de transport.
            @endif
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('client.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Créer ma première demande
            </a>
            @if(request('status'))
            <a href="{{ route('client.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl transition-all duration-200 font-medium">
                <i data-lucide="x" class="w-5 h-5"></i>
                Effacer le filtre
            </a>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Optionnel: Afficher un toast de confirmation
        showToast('Référence copiée !', 'success');
    });
}

function showToast(message, type = 'success') {
    // Implémentation simple d'un toast
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} z-50`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endsection