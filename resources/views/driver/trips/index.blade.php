@extends('layouts.dashboard')

@section('title', 'Mes courses')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'trips'])
@endsection

@section('page-title', 'Mes courses')

@section('content')
@php
    $statusFilter = request('status', 'en_cours');
    $filteredCourses = $courses->filter(function ($course) use ($statusFilter) {
        $demandeStatus = optional($course->demande)->status;

        return match ($statusFilter) {
            'en_cours' => $demandeStatus === 'in_progress',
            'terminee' => $demandeStatus === 'delivered',
            'en_attente' => $course->status === 'en attente',
            default => true,
        };
    });
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.24em] text-slate-400">Chauffeur</p>
            <h2 class="text-3xl font-semibold text-slate-900">Mes courses</h2>
            <p class="mt-2 text-sm text-slate-500">Retrouvez un aperçu clair de vos courses, statuts et actions prioritaires.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach(['en_cours' => 'En cours', 'en_attente' => 'En attente', 'terminee' => 'Terminées'] as $key => $label)
                <a href="{{ route('driver.trips', ['status' => $key]) }}"
                    class="rounded-full px-4 py-2 text-sm font-medium transition {{ $statusFilter === $key ? 'bg-primary-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid gap-5">
        @forelse($filteredCourses as $course)
            @php
                $demande = $course->demande;
                $client = optional(optional($demande)->expediteur)->user;
                $status = $demande?->status;
                $statusColor = match ($status) {
                    'in_progress' => 'blue',
                    'delivered' => 'green',
                    default => 'amber',
                };
                $statusText = match ($status) {
                    'in_progress' => 'En cours',
                    'delivered' => 'Terminée',
                    default => 'En attente',
                };
            @endphp

            <article class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-800 px-6 py-5 text-white">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.28em] text-slate-300">Course #{{ $course->id }}</p>
                            <h3 class="text-2xl font-semibold tracking-tight">{{ optional($demande)->ville_depart }} → {{ optional($demande)->ville_arrive }}</h3>
                        </div>
                        <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-sm text-slate-100">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                            <span>{{ $statusText }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Client</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ optional($client)->prenom ?? 'Client' }} {{ optional($client)->nom ?? '' }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ optional($client)->telephone ?? 'Téléphone indisponible' }}</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Marchandise</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ optional($demande)->type_marchendise ?? 'Non précisé' }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ optional($demande)->poids_kg ?? '—' }} kg</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Montant</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $course->montant_propose }} DH</p>
                            <p class="mt-1 text-sm text-slate-500">Offre {{ ucfirst($course->status) }}</p>
                        </div>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Date de création</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ optional($demande)->created_at?->format('d F Y') ?? '–' }}</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Référence demande</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ optional($demande)->reference ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-2 rounded-full bg-{{ $statusColor }}-100 px-3 py-1 text-sm font-medium text-{{ $statusColor }}-700">
                                <i data-lucide="circle" class="w-2 h-2"></i> {{ $statusText }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-600">{{ optional($demande)->ville_depart }} → {{ optional($demande)->ville_arrive }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @if($status === 'in_progress' && $demande)
                                <a href="{{ route('driver.tracking', $demande) }}" class="inline-flex items-center justify-center rounded-2xl bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600">Accéder au suivi</a>
                            @elseif($status === 'delivered')
                                <span class="inline-flex items-center justify-center rounded-2xl bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">Livré</span>
                            @else
                                <span class="inline-flex items-center justify-center rounded-2xl bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800">En attente</span>
                            @endif
                            <a href="{{ route('driver.offres.create', optional($demande)->id) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-primary-500 hover:text-primary-600">Modifier l’offre</a>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                <p class="text-lg font-medium text-slate-800">Aucune course trouvée pour ce statut.</p>
                <p class="mt-2 text-sm text-slate-500">Explorez d'autres statuts ou consultez votre tableau de bord pour plus d'informations.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
