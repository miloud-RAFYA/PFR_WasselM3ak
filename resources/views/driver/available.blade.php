@extends('layouts.dashboard')

@section('title', 'Demandes disponibles')

@section('sidebar')
    @include('driver.partials.sidebar', ['active' => 'available'])
@endsection

@section('page-title', 'Demandes disponibles')

@section('content')
    <div class="space-y-6">

        {{-- 🔍 SEARCH + FILTER --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between">

                {{-- 🔍 SEARCH --}}
                <form method="GET" class="flex items-center gap-2">

                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ville..."
                            class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>

                    {{-- 🔽 FILTER BUTTON --}}
                    <div x-data="{ open: false }" class="relative">

                        <button type="button" @click="open = !open"
                            class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 flex items-center gap-2">
                            <i data-lucide="filter" class="w-4 h-4"></i>
                            Filtrer
                        </button>

                        {{-- DROPDOWN --}}
                        <div x-show="open" @click.outside="open = false"
                            class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-xl p-4 z-50">

                            {{-- TYPE --}}
                            <div class="mb-3">
                                <label class="text-sm text-slate-600">Type</label>
                                <select name="type" class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2">
                                    <option value="">Tous</option>
                                    <option value="Meubles">Meubles</option>
                                    <option value="Cartons">Cartons</option>
                                    <option value="Électroménager">Électroménager</option>
                                </select>
                            </div>

                            {{-- POIDS --}}
                            <div class="mb-3">
                                <label class="text-sm text-slate-600">Poids max (kg)</label>
                                <input type="number" name="poids" value="{{ request('poids') }}"
                                    class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2">
                            </div>

                            {{-- PRIX --}}
                            <div class="mb-3">
                                <label class="text-sm text-slate-600">Prix max</label>
                                <input type="number" name="prix" value="{{ request('prix') }}"
                                    class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2">
                            </div>

                            {{-- ACTIONS --}}
                            <div class="flex gap-2 mt-4">

                                <button type="submit" class="flex-1 bg-primary-500 text-white py-2 rounded-lg">
                                    Appliquer
                                </button>

                                <a href="{{ route('driver.available') }}" class="flex-1 text-center border py-2 rounded-lg">
                                    Reset
                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- 📦 LISTE DES DEMANDES --}}
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">

            @forelse($demandes as $demande)
                @php
                    $type = strtolower($demande->type_marchendise);
                    if (str_contains($type, 'frais') || str_contains($type, 'alimentaire')) {
                        $imageUrl = asset('images/image.png');
                    } elseif (
                        str_contains($type, 'électronique') ||
                        str_contains($type, 'electronique') ||
                        str_contains($type, 'tech')
                    ) {
                        $imageUrl = asset('images/packages.png');
                    } else {
                        $imageUrl = asset('images/packages.png');
                    }
                @endphp
                <div
                    class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $imageUrl }}" alt="Marchandise {{ $demande->type_marchendise }}"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/10 to-transparent">
                        </div>
                        <div class="absolute inset-x-0 top-0 flex items-center justify-between px-5 py-4">
                            <span
                                class="rounded-full bg-primary-500/90 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-white">{{ ucfirst($demande->type_marchendise) }}</span>
                            <span
                                class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-800">{{ $demande->poids_kg }}
                                kg</span>
                        </div>
                        <div class="absolute left-5 bottom-5 text-white">
                            <h3 class="text-2xl font-semibold tracking-tight">{{ $demande->ville_depart }} →
                                {{ $demande->ville_arrive }}</h3>
                            <p class="text-sm text-slate-200/90 mt-1">{{ $demande->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Référence</p>
                                <p class="text-lg font-semibold text-slate-900">{{ $demande->reference }}</p>
                            </div>
                            <span
                                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] {{ 'bg-slate-100 text-slate-700' }}">
                                Nouvelle demande
                            </span>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3 text-sm text-slate-600">
                            <div class="rounded-3xl bg-slate-50 p-4 shadow-sm">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Départ</p>
                                <p class="mt-2 font-semibold text-slate-900">{{ $demande->ville_depart }}</p>
                            </div>
                            <div class="rounded-3xl bg-slate-50 p-4 shadow-sm">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Arrivée</p>
                                <p class="mt-2 font-semibold text-slate-900">{{ $demande->ville_arrive }}</p>
                            </div>
                            <div class="rounded-3xl bg-slate-50 p-4 shadow-sm">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Prix estimé</p>
                                <p class="mt-2 font-semibold text-slate-900">{{ $demande->prix_estime }} DH</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 flex items-center justify-between gap-3">
                        <div class="text-sm text-slate-600">
                            <p class="uppercase tracking-[0.2em] text-xs text-slate-400">Offres</p>
                            <p class="font-medium">{{ $demande->offres->count() }}</p>
                        </div>
                        <form method="POST" action="{{ route('driver.offres.create',$demande->id) }}"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-primary-500 hover:text-white">
                            @csrf
                            <button type='supmit'>
                                Proposer
                            </button>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </form>
                    </div>
                </div>
            @empty

                <div class="text-center py-10 bg-white rounded-xl shadow-sm">
                    <p class="text-slate-500">Aucune demande disponible</p>
                </div>
            @endforelse

        </div>

        {{-- 📄 PAGINATION --}}
        <div>
            {{ $demandes->links() }}
        </div>

    </div>
@endsection
