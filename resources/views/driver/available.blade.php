@extends('layouts.dashboard')

@section('title', 'Demandes disponibles')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'available'])
@endsection

@section('content')
<div class="space-y-8">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Demandes disponibles</h1>
        <p class="text-slate-500 mt-1">Consultez et proposez vos services sur les annonces récentes</p>
    </div>

    {{-- Barre de recherche + filtre --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative flex-1 sm:min-w-[260px]">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Ville de départ ou d'arrivée"
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
            </div>

            {{-- Filtre dropdown amélioré --}}
            <div x-data="{ open: false }" class="relative">
                <button type="button" @click="open = !open"
                        class="px-5 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 flex items-center gap-2 transition shadow-sm">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                    <span>Filtres</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>

                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl p-5 z-50">
                    <h4 class="font-semibold text-slate-800 mb-3">Affiner la recherche</h4>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Type de marchandise</label>
                            <select name="type" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-primary-500">
                                <option value="">Tous</option>
                                <option value="Meubles" {{ request('type') == 'Meubles' ? 'selected' : '' }}>🪑 Meubles</option>
                                <option value="Cartons" {{ request('type') == 'Cartons' ? 'selected' : '' }}>📦 Cartons</option>
                                <option value="Électroménager" {{ request('type') == 'Électroménager' ? 'selected' : '' }}>🔌 Électroménager</option>
                                <option value="Palettes" {{ request('type') == 'Palettes' ? 'selected' : '' }}>📐 Palettes</option>
                                <option value="Véhicules" {{ request('type') == 'Véhicules' ? 'selected' : '' }}>🚗 Véhicules</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Poids max (kg)</label>
                            <input type="number" name="poids" value="{{ request('poids') }}"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-primary-500"
                                   placeholder="ex: 500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Prix max (DH)</label>
                            <input type="number" name="prix" value="{{ request('prix') }}"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-primary-500"
                                   placeholder="ex: 1000">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-5 pt-2">
                        <button type="submit"
                                class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-2 rounded-xl transition shadow-sm">
                            Appliquer
                        </button>
                        <a href="{{ route('driver.available') }}"
                           class="flex-1 text-center border border-slate-200 py-2 rounded-xl hover:bg-slate-50 transition">
                            Réinitialiser
                        </a>
                    </div>
                </div>
            </div>
        </form>

        @if(request()->anyFilled(['search', 'type', 'poids', 'prix']))
            <div class="text-sm text-slate-500">
                Filtres actifs – 
                <a href="{{ route('driver.available') }}" class="text-primary-500 hover:underline">Tout afficher</a>
            </div>
        @endif
    </div>

    {{-- Nombre de résultats --}}
    <div class="text-sm text-slate-500">
        {{ $demandes->total() }} demande(s) trouvée(s)
    </div>

    {{-- Grille des demandes --}}
    @if($demandes->count())
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($demandes as $demande)
                @php
                    $type = strtolower($demande->type_marchendise);
                    if (str_contains($type, 'frais') || str_contains($type, 'alimentaire')) {
                        $imageUrl = asset('images/image.png');
                    } else {
                        $imageUrl = asset('images/packages.png');
                    }
                @endphp
                <div class="group bg-white rounded-2xl border border-slate-200 shadow-soft hover:shadow-primary transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    {{-- Image --}}
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $imageUrl }}" alt="{{ $demande->type_marchendise }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <i data-lucide="package" class="w-3 h-3"></i>
                                {{ ucfirst($demande->type_marchendise) }}
                            </span>
                        </div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <div class="flex justify-between items-end">
                                <div>
                                    <h3 class="text-white font-bold text-lg leading-tight">
                                        {{ $demande->ville_depart }} → {{ $demande->ville_arrive }}
                                    </h3>
                                    <p class="text-white/80 text-xs mt-0.5">Réf: {{ $demande->reference }}</p>
                                </div>
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2 py-1 rounded-lg">
                                    {{ $demande->poids_kg }} kg
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Corps --}}
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-1 text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                <span>{{ $demande->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1 text-slate-500">
                                <i data-lucide="gavel" class="w-4 h-4"></i>
                                <span>{{ $demande->offres->count() }} offre(s)</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-slate-50 rounded-xl p-2 text-center">
                                <p class="text-xs text-slate-500">Prix estimé</p>
                                <p class="text-lg font-bold text-primary-600">{{ number_format($demande->prix_estime, 0, ',', ' ') }} DH</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-2 text-center">
                                <p class="text-xs text-slate-500">Trajet</p>
                                <p class="text-sm font-medium text-slate-700 truncate">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('driver.offres.create', $demande->id) }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition shadow-md hover:shadow-lg font-medium">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                Proposer une offre
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $demandes->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-5">
                <i data-lucide="inbox" class="w-10 h-10 text-slate-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Aucune demande disponible</h3>
            <p class="text-slate-500">Revenez plus tard, de nouvelles annonces seront publiées.</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .shadow-soft {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
    }
    .shadow-primary:hover {
        box-shadow: 0 20px 30px -12px rgba(2,124,177,0.2);
    }
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush