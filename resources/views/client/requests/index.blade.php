@extends('layouts.dashboard')

@section('title', 'Mes demandes')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('content')
<div class="space-y-8">
    <!-- Header avec bouton retour intelligent -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            @if(request()->has('from') && request('from') === 'show')
            <a href="{{ route('client.index', request()->except(['from', 'page'])) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:border-primary-300 hover:text-primary-600 transition-all duration-200 text-slate-600">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Retour
            </a>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Mes demandes</h1>
                <div class="flex items-center gap-2 mt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-sm font-medium">
                        <i data-lucide="package" class="w-4 h-4"></i>
                        {{ $demandes->total() }} demande(s)
                    </span>
                </div>
            </div>
        </div>
        <a href="{{ route('client.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition-all duration-200 shadow-soft hover:shadow-primary transform hover:-translate-y-0.5 font-medium">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Nouvelle demande
        </a>
    </div>

    <!-- Filtres améliorés -->
    <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-4">
        <a href="{{ route('client.index', request()->except(['status', 'page'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ !request('status') ? 'bg-primary-500 text-white shadow-md shadow-primary-200' : 'bg-white text-slate-600 border border-slate-200 hover:border-primary-300 hover:text-primary-600' }}">
            <i data-lucide="list" class="w-4 h-4"></i>
            Toutes
        </a>
        <a href="{{ route('client.index', array_merge(request()->except(['page']), ['status' => 'pending'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-white text-slate-600 border border-slate-200 hover:border-amber-300 hover:text-amber-600' }}">
            <i data-lucide="clock" class="w-4 h-4"></i>
            En attente
        </a>
        <a href="{{ route('client.index', array_merge(request()->except(['page']), ['status' => 'in_progress'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'in_progress' ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-white text-slate-600 border border-slate-200 hover:border-sky-300 hover:text-sky-600' }}">
            <i data-lucide="truck" class="w-4 h-4"></i>
            En cours
        </a>
        <a href="{{ route('client.index', array_merge(request()->except(['page']), ['status' => 'delivered'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'delivered' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-200' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-300 hover:text-emerald-600' }}">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            Livrées
        </a>
    </div>

    @if($demandes->count())
    <!-- Grille des demandes avec animations -->
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($demandes as $index => $demande)
        @php
            $statusColors = [
                'delivered' => ['bg' => 'bg-emerald-100 text-emerald-700', 'icon' => 'check-circle', 'label' => 'Livrée'],
                'in_progress' => ['bg' => 'bg-sky-100 text-sky-700', 'icon' => 'truck', 'label' => 'En cours'],
                'pending' => ['bg' => 'bg-amber-100 text-amber-700', 'icon' => 'clock', 'label' => 'En attente'],
                'cancelled' => ['bg' => 'bg-red-100 text-red-700', 'icon' => 'x-circle', 'label' => 'Annulée'],
            ];
            $status = $statusColors[$demande->status] ?? ['bg' => 'bg-slate-100 text-slate-700', 'icon' => 'circle', 'label' => ucfirst($demande->status)];
        @endphp
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft hover:shadow-primary transition-all duration-300 hover:-translate-y-1 opacity-0 animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s">
            <!-- Badge statut flottant -->
            <div class="absolute top-4 right-4 z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg {{ $status['bg'] }} text-xs font-semibold uppercase tracking-wide shadow-sm">
                    <i data-lucide="{{ $status['icon'] }}" class="w-3.5 h-3.5"></i>
                    {{ $status['label'] }}
                </span>
            </div>

            <!-- Section image avec fallback -->
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

            <!-- Contenu de la carte -->
            <div class="p-5 space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Référence</p>
                        <button onclick="copyToClipboard('{{ $demande->reference }}')" 
                                class="text-slate-400 hover:text-primary-500 transition-colors p-1 rounded-lg hover:bg-slate-100">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    <p class="text-lg font-bold text-slate-900 font-mono tracking-tight">{{ $demande->reference }}</p>
                    
                    <!-- Itinéraire stylisé -->
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

                <!-- Prix et date -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-3 border border-slate-100">
                        <p class="text-xs text-slate-500 mb-1">Montant</p>
                        <p class="text-xl font-bold text-primary-600">
                            {{ number_format($demande->prix_final ?? $demande->prix_estime, 0, ',', ' ') }} DH
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-3 border border-slate-100">
                        <p class="text-xs text-slate-500 mb-1">Créé le</p>
                        <p class="text-base font-semibold text-slate-800">{{ $demande->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-slate-400">{{ $demande->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Offres & action -->
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
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination améliorée -->
    <div class="mt-8">
        @if($demandes->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white rounded-xl border border-slate-200">
            <div class="text-sm text-slate-600">
                Affichage de <span class="font-semibold text-slate-900">{{ $demandes->firstItem() }}</span> à 
                <span class="font-semibold text-slate-900">{{ $demandes->lastItem() }}</span> sur 
                <span class="font-semibold text-slate-900">{{ $demandes->total() }}</span> demandes
            </div>
            <div class="flex gap-2">
                {{ $demandes->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
    </div>
    
    @else
    <!-- Empty state moderne -->
    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-12 text-center">
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
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition-all duration-200 shadow-soft hover:shadow-primary font-medium">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Créer ma première demande
            </a>
            @if(request('status'))
            <a href="{{ route('client.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-slate-200 hover:border-primary-300 hover:text-primary-600 text-slate-700 rounded-xl transition-all duration-200 font-medium">
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
        showToast('Référence copiée !', 'success');
    }).catch(() => {
        showToast('Impossible de copier', 'error');
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-5 py-3 rounded-xl shadow-lg text-white z-50 animate-fade-in-up ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="w-5 h-5"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    lucide.createIcons();
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>

@push('styles')
<style>
    .shadow-soft { box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02); }
    .shadow-primary { box-shadow: 0 12px 24px rgba(2,124,177,0.12); }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.4s ease-out forwards;
    }
</style>
@endpush
@endsection