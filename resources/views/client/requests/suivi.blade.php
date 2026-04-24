@extends('layouts.dashboard')

@section('title', 'Suivi des demandes')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'suivi'])
@endsection

@section('page-title', 'Suivi des demandes')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Suivi des demandes</h1>
                <p class="text-slate-500 mt-1">Suivez l’avancement de vos demandes en cours et consultez leur position GPS.</p>
            </div>
            <a href="{{ route('client.requests.suivi_gps') }}" class="inline-flex items-center gap-2 px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                <i data-lucide="map-pin" class="w-5 h-5"></i>
                Voir la carte
            </a>
        </div>

        <div class="grid gap-6 mt-6 sm:grid-cols-2 xl:grid-cols-3">
            @forelse($demandes as $demande)
                <div class="group overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</h2>
                                <p class="text-sm text-slate-500">{{ $demande->type_marchendise }} • {{ $demande->poids_kg }} kg</p>
                            </div>
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] {{ $demande->status === 'in_progress' ? 'bg-sky-500 text-white' : 'bg-slate-100 text-slate-700' }}">
                                {{ $demande->status === 'in_progress' ? 'En cours' : ucfirst(str_replace('_', ' ', $demande->status)) }}
                            </span>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 text-sm text-slate-600 mb-6">
                            <div class="rounded-[1.5rem] bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Référence</p>
                                <p class="mt-2 font-semibold text-slate-900">{{ $demande->reference }}</p>
                            </div>
                            <div class="rounded-[1.5rem] bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Dernière position</p>
                                @php $last = $demande->suivres->sortByDesc('created_at')->first(); @endphp
                                <p class="mt-2 font-semibold text-slate-900">{{ $last ? number_format($last->latitude, 6, '.', ',') . ', ' . number_format($last->longitude, 6, '.', ',') : 'Pas de position' }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <a href="{{ route('client.requests.suivi_gps', ['demande_id' => $demande->id]) }}" class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700 hover:bg-primary-100 transition">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                Voir sur la carte
                            </a>
                            <a href="{{ route('client.requests.show', $demande) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Détail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-[1.5rem] border border-slate-200 bg-white p-10 text-center">
                    <p class="text-slate-500">Vous n’avez aucune demande en cours pour le suivi GPS.</p>
                    <a href="{{ route('client.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Retour aux demandes
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $demandes->links() }}
        </div>
    </div>
</div>
@endsection
