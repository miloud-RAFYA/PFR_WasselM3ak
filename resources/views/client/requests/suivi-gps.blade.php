@extends('layouts.dashboard')

@section('title', 'Suivi GPS des demandes')

@section('sidebar')
    @include('client.partials.sidebar', ['active' => 'suivi-gps'])
@endsection

@section('page-title', 'Suivi GPS des demandes')

@section('content')
<div class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-[1.7fr_1fr]">

        {{-- 🗺️ MAP --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Suivi GPS</h1>
                    <p class="text-sm text-slate-500 mt-1">Visualisez l'emplacement de votre marchandise en temps réel</p>
                </div>
                @if ($selectedDemande)
                    <div id="live-indicator" class="flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-xs text-slate-500">Live</span>
                    </div>
                @endif
            </div>

            <div class="bg-slate-100 relative" style="height: 550px;">
                <div id="map" class="h-full w-full z-0"></div>

                {{-- Status overlay --}}
                <div id="tracking-status" class="absolute top-4 left-4 z-20 rounded-xl bg-white/95 backdrop-blur-sm px-4 py-2.5 text-sm text-slate-700 shadow-md border border-slate-200 flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-slate-400"></div>
                    <span>Initialisation...</span>
                </div>

                {{-- Controls overlay --}}
                <div class="absolute bottom-4 right-4 z-20 flex gap-2">
                    <button onclick="resetMapView()" class="bg-white hover:bg-slate-50 rounded-lg p-2 shadow-md border border-slate-200 transition-colors">
                        <i data-lucide="target" class="w-5 h-5 text-slate-600"></i>
                    </button>
                </div>

                @if (!$selectedDemande || !$selectedDemande->suivres->count())
                    <div id="tracking-empty-overlay" class="absolute inset-0 flex items-center justify-center bg-white/90 backdrop-blur-sm z-10">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-full mb-3">
                                <i data-lucide="map-pin-off" class="w-8 h-8 text-slate-400"></i>
                            </div>
                            <p class="text-slate-600 font-medium">En attente de signal GPS</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- 📦 SIDEBAR --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h2 class="font-semibold text-slate-900 flex items-center gap-2">
                        <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                        Mes livraisons actives
                    </h2>
                </div>

                <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto">
                    @forelse($demandes as $demande)
                        @php $isSelected = optional($selectedDemande)->id === $demande->id; @endphp
                        <div class="p-5 transition-all {{ $isSelected ? 'bg-primary-50 border-l-4 border-l-primary-500' : 'hover:bg-slate-50' }}">
                            <div class="flex flex-col gap-3">
                                <h3 class="font-semibold text-slate-900">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-sky-100 text-sky-700">En cours</span>
                                    <button onclick="selectDemande({{ $demande->id }})" class="text-sm font-bold {{ $isSelected ? 'text-primary-600' : 'text-slate-400' }}">
                                        {{ $isSelected ? 'Suivi actif' : 'Voir sur la carte' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400">Aucune course en cours</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .truck-icon-container { 
        transition: transform 0.5s ease-in-out;
        display: inline-block;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.4/echo.iife.min.js"></script>

<script>
    const demandeId = @json(optional($selectedDemande)->id);
    const trackingUrl = @json(optional($selectedDemande) ? route('tracking.positions', $selectedDemande->id) : null);

    let map, polyline, truckMarker, routePoints = [];
    
    // Icône Camion avec rotation
    const truckSvg = (color = "#2563eb") => `
        <div class="truck-icon-container">
            <svg width="40" height="40" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <rect x="8" y="28" width="48" height="24" rx="4" fill="${color}" stroke="#1e3a8a" stroke-width="2"/>
                <path d="M44 28V20H28V28" stroke="#1e3a8a" stroke-width="2" fill="none"/>
                <circle cx="18" cy="52" r="6" fill="#1e3a8a"/>
                <circle cx="46" cy="52" r="6" fill="#1e3a8a"/>
            </svg>
        </div>`;

    function initMap() {
        map = L.map('map', { zoomControl: false }).setView([31.79, -7.09], 6);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        L.control.zoom({ position: 'bottomleft' }).addTo(map);
    }

    /**
     * Calcule l'angle entre deux points pour la rotation du camion
     */
    function calculateHeading(start, end) {
        return (Math.atan2(end.lng - start.lng, end.lat - start.lat) * 180) / Math.PI;
    }

    /**
     * Met à jour l'affichage du suivi avec les positions reçues
     */
    function updateTracking(points) {
        if (!points || !points.length) {
            updateStatusText("Aucune position disponible");
            return;
        }
        
        // Normaliser les points pour gérer latitude/longitude et lat/lng
        const normalizedPoints = points.map(p => ({
            latitude: p.latitude !== undefined ? p.latitude : p.lat,
            longitude: p.longitude !== undefined ? p.longitude : p.lng,
            time: p.time || ''
        }));

        const latlngs = normalizedPoints.map(p => [p.latitude, p.longitude]);
        const lastPos = latlngs[latlngs.length - 1];

        // 1. Mise à jour ou création de la ligne de route
        if (polyline) {
            polyline.setLatLngs(latlngs);
        } else {
            polyline = L.polyline(latlngs, { 
                color: '#2563eb', 
                weight: 4, 
                opacity: 0.6,
                lineCap: 'round'
            }).addTo(map);
        }

        // 2. Calcul de l'angle de rotation du camion
        let angle = 0;
        if (latlngs.length > 1) {
            const p1 = L.latLng(latlngs[latlngs.length - 2]);
            const p2 = L.latLng(lastPos);
            angle = calculateHeading(p1, p2);
        }

        // 3. Création ou mise à jour du marqueur camion
        const customIcon = L.divIcon({
            html: truckSvg(),
            className: 'custom-truck',
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });

        if (truckMarker) {
            truckMarker.setLatLng(lastPos);
            const iconElement = truckMarker.getElement()?.querySelector('.truck-icon-container');
            if (iconElement) {
                iconElement.style.transform = `rotate(${angle}deg)`;
            }
        } else {
            truckMarker = L.marker(lastPos, { icon: customIcon }).addTo(map);
            // Centrer sur le camion avec zoom approprié
            map.setView(lastPos, 14);
        }

        // Masquer le message "En attente de signal"
        const emptyOverlay = document.getElementById('tracking-empty-overlay');
        if (emptyOverlay) {
            emptyOverlay.classList.add('hidden');
        }

        updateStatusText(`✓ Synchronisé (${points.length} points)`);
    }

    /**
     * Met à jour le texte du statut de suivi
     */
    function updateStatusText(msg) {
        const node = document.querySelector('#tracking-status span');
        if (node) {
            node.textContent = msg;
        }
    }

    /**
     * Charge les données historiques initiales
     */
    function fetchInitialData() {
        if (!trackingUrl) {
            updateStatusText("Pas de demande sélectionnée");
            return;
        }

        fetch(trackingUrl)
            .then(res => {
                if (!res.ok) throw new Error(`Erreur ${res.status}`);
                return res.json();
            })
            .then(data => {
                routePoints = data;
                updateTracking(data);
                if (data.length && polyline) {
                    map.fitBounds(polyline.getBounds(), { padding: [50, 50] });
                }
            })
            .catch(error => {
                console.error('Erreur chargement données:', error);
                updateStatusText("Erreur lors du chargement des positions");
            });
    }

    /**
     * Initialise la connexion Pusher pour les mises à jour en temps réel
     */
    function initRealtime() {
        if (!demandeId) {
            console.log('Pas de demande sélectionnée pour le temps réel');
            return;
        }

        try {
            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: "{{ env('PUSHER_APP_KEY') }}",
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                forceTLS: true
            });

            window.Echo.private(`tracking.demande.${demandeId}`)
                .listen('DriverPositionUpdated', (event) => {
                    console.log('Nouvelle position reçue:', event);
                    
                    const newPoint = {
                        latitude: event.latitude,
                        longitude: event.longitude,
                        time: event.time || new Date().toLocaleTimeString('fr-FR')
                    };

                    routePoints.push(newPoint);
                    updateTracking(routePoints);
                })
                .error((error) => {
                    console.error('Erreur Pusher:', error);
                    updateStatusText("Avertissement: Connexion temps réel perdue");
                });

            console.log('Suivi temps réel initialisé pour la demande', demandeId);
        } catch (error) {
            console.error('Erreur initialisation Pusher:', error);
            updateStatusText("Avertissement: Temps réel indisponible");
        }
    }

    /**
     * Sélectionne une nouvelle demande
     */
    function selectDemande(id) {
        window.location.search = `demande_id=${id}`;
    }

    /**
     * Réinitialise la vue sur l'ensemble de la route
     */
    function resetMapView() {
        if (polyline) {
            map.fitBounds(polyline.getBounds(), { padding: [40, 40] });
        } else if (truckMarker) {
            map.setView(truckMarker.getLatLng(), 14);
        }
    }

    /**
     * Initialisation au chargement de la page
     */
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Initialisation du suivi GPS...');
        initMap();
        fetchInitialData();
        initRealtime();
    });

    /**
     * Nettoyage lors du déchargement
     */
    window.addEventListener('beforeunload', () => {
        if (window.Echo) {
            window.Echo.leave(`tracking.demande.${demandeId}`);
        }
    });
</script>
@endpush