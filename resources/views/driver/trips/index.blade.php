@extends('layouts.dashboard')

@section('title', 'Mes Missions')

@section('sidebar')
    @include('driver.partials.sidebar', ['active' => 'trips'])
@endsection

@section('page-title', 'Tableau de bord chauffeur')

@section('content')
    <div class="space-y-12">

        {{-- SECTION 1 : MISSIONS ACCEPTÉES --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <div class="h-8 w-1.5 bg-emerald-500 rounded-full"></div>
                <h2 class="text-2xl font-bold text-slate-900">Missions Validées</h2>
                <span
                    class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200">
                    {{ $acceptedCourses->count() }} Contrats actifs
                </span>
            </div>

            <div class="grid gap-6">
                @forelse($acceptedCourses as $course)
                    <div
                        class="relative overflow-hidden bg-white border border-slate-200 rounded-3xl shadow-sm transition hover:shadow-md">
                        {{-- Indicateur visuel dynamique --}}
                        <div
                            class="absolute left-0 top-0 bottom-0 w-2 {{ $course->demande->status === 'delivered' ? 'bg-slate-300' : 'bg-primary-500' }}">
                        </div>

                        <div class="p-6 ml-2">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                        {{ $course->demande->ville_depart }}
                                        <i data-lucide="arrow-right" class="w-4 h-4 text-slate-400"></i>
                                        {{ $course->demande->ville_arrive }}
                                    </h3>
                                    <p class="text-sm text-slate-500">
                                        <span class="font-medium text-slate-700">Client :</span>
                                        {{ $course->demande->expediteur->user->prenom }}
                                        {{ $course->demande->expediteur->user->nom }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Prix Convenu
                                        </p>
                                        <p class="text-2xl font-black text-slate-900">
                                            {{ number_format($course->montant_propose, 0, '.', ' ') }} DH</p>
                                    </div>

                                    {{-- Bouton Suivi (Modifié pour pointer vers la VUE et non l'action update) --}}
                                    @if ($course->demande->status === 'in_progress')
                                        <a href="{{ route('tracking.positions', $course->demande) }}"
                                            class="inline-flex items-center gap-2 bg-primary-600 text-white px-5 py-3 rounded-2xl font-bold hover:bg-primary-700 transition shadow-lg shadow-primary-200">
                                            <i data-lucide="map-pin" class="w-4 h-4"></i> Suivi Live
                                        </a>
                                    @elseif($course->demande->status === 'delivered')
                                        <div
                                            class="flex items-center gap-2 bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200">
                                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i> Terminée
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-12 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 text-slate-400">
                        <i data-lucide="truck" class="w-10 h-10 mx-auto mb-3 opacity-20"></i>
                        <p>Vous n'avez pas encore de mission acceptée.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- SECTION 2 : OFFRES EN ATTENTE --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <div class="h-8 w-1.5 bg-amber-400 rounded-full"></div>
                <h2 class="text-2xl font-bold text-slate-900">Mes Propositions</h2>
                <span
                    class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-200">En
                    attente client</span>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @forelse($pendingOffers as $offer)
                    <div
                        class="bg-slate-50 border border-slate-200 rounded-2xl p-5 hover:bg-white hover:border-primary-300 transition-all group shadow-sm">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-slate-900">{{ $offer->demande->ville_depart }} →
                                    {{ $offer->demande->ville_arrive }}</p>
                                <p class="text-xs text-slate-500 flex items-center gap-1">
                                    <i data-lucide="package" class="w-3 h-3"></i> {{ $offer->demande->type_marchendise }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary-600">
                                    {{ number_format($offer->montant_propose, 0, '.', ' ') }} DH</p>
                                <a href="{{ route('driver.offres.update', $offer->id) }}"
                                    class="inline-flex items-center gap-1 text-[10px] uppercase font-bold text-slate-400 group-hover:text-primary-500 underline transition">
                                    <i data-lucide="pencil-line" class="w-3 h-3"></i> Modifier
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="md:col-span-2 text-center py-8 text-slate-400 text-sm italic border border-slate-100 rounded-2xl">
                        Aucune offre envoyée récemment.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        @if ($activeCourse)
            const currentDemandeId = {{ $activeCourse->demande->id }};
            if ("geolocation" in navigator) {
                setInterval(() => {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            axios.post("{{ route('tracking.update') }}", {
                                    demande_id: currentDemandeId,
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude
                                })
                                .then(res => console.log("Position mise à jour"))
                                .catch(err => console.error("Erreur d'envoi", err));
                        },
                        (error) => {
                            console.warn("Erreur GPS (" + error.code + "): " + error.message);
                        }, {
                            enableHighAccuracy: false, // OBLIGATOIRE sur PC pour éviter le Timeout
                            timeout: 10000, // 10 secondes d'attente max
                            maximumAge: 0
                        }
                    );
                }, 15000); // Envoi toutes les 15 secondes
            }
        @endif
    </script>
@endpush
