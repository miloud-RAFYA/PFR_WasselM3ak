@extends('layouts.dashboard')

@section('title', 'Tableau de bord Chauffeur')

@section('availability-toggle')

    <form method="POST" action="{{ route('driver.toggle') }}">
        @csrf

        <button type="submit"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition shadow-sm
        {{ $chauffeur->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">

            {{-- Indicator --}}
            <div class="w-3 h-3 rounded-full
            {{ $chauffeur->is_available ? 'bg-green-500' : 'bg-red-500' }}">
            </div>

            {{-- Text --}}
            <span class="text-sm font-medium">
                {{ $chauffeur->is_available ? 'Disponible' : 'Indisponible' }}
            </span>

            {{-- Toggle Switch --}}
            <div
                class="ml-2 relative inline-flex h-5 w-10 items-center rounded-full
            {{ $chauffeur->is_available ? 'bg-green-500' : 'bg-slate-300' }}">

                <span
                    class="inline-block h-4 w-4 transform bg-white rounded-full transition
                {{ $chauffeur->is_available ? 'translate-x-5' : 'translate-x-1' }}">
                </span>

            </div>

        </button>

    </form>

@endsection
@section('sidebar')
    @include('driver.partials.sidebar')
@endsection

@section('page-title', 'Tableau de bord')

@section('content')
    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['courses_ce_mois'] }}</p>
                        <p class="text-sm text-slate-500">Courses acceptées</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['offres_en_attente'] }}</p>
                        <p class="text-sm text-slate-500">Offres en attente</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-500"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['gains_ce_mois'], 0, ',', ' ') }} DH</p>
                        <p class="text-sm text-slate-500">Gains ce mois</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="star" class="w-6 h-6 text-amber-500"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $chauffeur->note_moyenne }}/5</p>
                        <p class="text-sm text-slate-500">Note moyenne</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Earnings -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-900">Actions rapides</h3>
                </div>
                <div class="p-6 space-y-3">
                    {{-- {{ route('driver.available') }} --}}
                    <a href="{{ route('driver.available') }}"
                        class="flex items-center gap-3 w-full px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                        Voir les demandes disponibles
                    </a>
                    <a href="{{ route('driver.trips') }}"
                        class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                        Mes courses en cours
                    </a>
                    <a href="{{ route('driver.vehicle') }}"
                        class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        Gérer mon véhicule
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-900">Évolution des gains</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-end gap-2">
                            <span class="text-4xl font-bold text-slate-900">{{ number_format($stats['gains_ce_mois'], 0, ',', ' ') }} DH</span>
                        </div>
                        <p class="text-slate-500 text-sm">Revenus générés ce mois</p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Revenu total</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900">{{ number_format($stats['revenu_total'], 0, ',', ' ') }} DH</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Notes</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $chauffeur->note_moyenne ?? '—' }}/5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Demandes récentes près de vous</h3>
                <a href="{{ route('driver.available') }}" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($demandes as $demande)
                        <div
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition">

                            {{-- LEFT --}}
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                    <i data-lucide="package" class="w-6 h-6 text-primary-500"></i>
                                </div>

                                <div>
                                    <p class="font-medium text-slate-900">
                                        {{ $demande->ville_depart }} → {{ $demande->ville_arrive }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        {{ $demande->type_marchendise }} • {{ $demande->created_at->format('Y-m-d') }}
                                    </p>
                                </div>

                            </div>

                            {{-- RIGHT --}}
                            <div class="flex items-center gap-4">

                                <p class="font-medium text-primary-500">
                                    {{ $demande->prix_estime }} DH
                                </p>

                                <a href="{{ route('driver.offres.create', $demande->id) }}"
                                    class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition">
                                    Proposer
                                </a>

                            </div>

                        </div>

                    @empty

                        <p class="text-center text-slate-500 py-6">
                            Aucune demande disponible
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
