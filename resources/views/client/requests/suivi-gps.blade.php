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
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <div class="p-6 border-b flex justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">Suivi GPS</h1>
                    <p class="text-sm text-slate-500">
                        Visualisez l’emplacement en temps réel
                    </p>
                </div>

                <a href="{{ route('client.requests.suivi') }}"
                    class="px-4 py-2 border rounded-lg hover:bg-slate-50">
                    Retour
                </a>
            </div>

            <div class="bg-slate-100 relative" style="height: 500px;">
                <div id="map" class="h-full"></div>
                <div id="tracking-status" class="absolute top-4 left-4 z-20 rounded-2xl bg-white/95 px-4 py-3 text-sm text-slate-700 shadow-sm border border-slate-200">
                    Initialisation du suivi...
                </div>

                @if(!$selectedDemande || !$selectedDemande->suivres->count())
                <div id="tracking-empty-overlay" class="absolute inset-0 flex items-center justify-center bg-white/80">
                    <p class="text-slate-600">
                        Aucune position GPS disponible pour la demande sélectionnée.
                    </p>
                </div>
                @endif
            </div>

        </div>

        {{-- 📦 SIDEBAR --}}
        <div class="space-y-6">

            {{-- DEMANDES --}}
            <div class="bg-white rounded-xl shadow-sm p-6">

                <h2 class="font-semibold mb-4">Demandes en cours</h2>

                @forelse($demandes as $demande)

                @php
                    $last = $demande->suivres->sortByDesc('created_at')->first();
                @endphp

                 <div class="p-4 border rounded-xl mb-4 {{ optional($selectedDemande)->id === $demande->id ? 'border-primary-500 bg-primary-50' : 'border-slate-200 bg-white' }}">

                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold">
                                    {{ $demande->ville_depart }} → {{ $demande->ville_arrive }}
                                </h3>
                                <p class="text-sm text-slate-500">
                                    {{ $demande->type_marchendise }} • {{ $demande->poids_kg }} kg
                                </p>
                            </div>

                            <a href="?demande_id={{ $demande->id }}"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-full border {{ optional($selectedDemande)->id === $demande->id ? 'border-primary-500 bg-primary-500 text-white' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-100' }}">
                                Suivre
                            </a>
                        </div>

                    @if($last)
                        <p class="text-sm mt-2">
                            📍 {{ number_format($last->latitude, 6, '.', ',') }}, {{ number_format($last->longitude, 6, '.', ',') }}
                        </p>
                    @else
                        <p class="text-sm text-amber-500 mt-2">
                            Pas de GPS
                        </p>
                    @endif

                </div>

                @empty
                <p class="text-slate-500">Aucune demande</p>
                @endforelse

            </div>

        </div>

    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.4/echo.iife.min.js" integrity="sha512-lqq7A+D5nLAtRdx9DZHmAbGTkZ4O+WM+hA/8UJZ+0tYxgY3Y65wNwTLK7MzB6cbw8GT8/1Q5g3n7fYH1Mn8+fg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
const demandeId = @json(optional($selectedDemande)->id);
let polyline;
let marker;
let routePoints = [];
const noDataOverlay = document.getElementById('tracking-empty-overlay');
const statusNode = document.getElementById('tracking-status');

const truckSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><path fill="%232563eb" d="M48 36H17a2 2 0 0 1-2-2V19a2 2 0 0 1 2-2h22l8 8h1v11a2 2 0 0 1-2 2Z"/><path fill="%23fff" d="M45 20H35v6h10v-6Z"/><path fill="%230d6ede" d="M8 40h6v10H8zM50 40h6v10h-6z"/><circle cx="18" cy="52" r="6" fill="%231e3a8a"/><circle cx="46" cy="52" r="6" fill="%231e3a8a"/></svg>`;
const driverIcon = L.icon({
    iconUrl: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(truckSvg),
    iconSize: [42, 42],
    iconAnchor: [21, 21],
    popupAnchor: [0, -20],
});

const startIcon = L.divIcon({
    className: '',
    html: '<div style="width:18px;height:18px;border:4px solid #ffffff;border-radius:50%;background:#10b981;box-shadow:0 0 10px rgba(16,185,129,0.8);"></div>',
    iconSize: [26, 26],
    iconAnchor: [13, 13],
});

const endIcon = L.divIcon({
    className: '',
    html: '<div style="width:18px;height:18px;border:4px solid #ffffff;border-radius:50%;background:#ef4444;box-shadow:0 0 10px rgba(239,68,68,0.8);"></div>',
    iconSize: [26, 26],
    iconAnchor: [13, 13],
});

let startMarker = null;
let endMarker = null;

const map = L.map('map', {
    zoomControl: true,
    attributionControl: true,
    minZoom: 4,
    maxZoom: 18,
}).setView([31.79, -7.09], 5);
L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
}).addTo(map);

L.control.scale({ metric: true, imperial: false, position: 'bottomleft' }).addTo(map);

function updateStatus(message, isError = false) {
    if (!statusNode) return;
    statusNode.textContent = message;
    statusNode.classList.toggle('text-red-600', isError);
    statusNode.classList.toggle('text-slate-700', !isError);
}

function updateNoDataOverlay(visible) {
    if (!noDataOverlay) return;
    noDataOverlay.style.display = visible ? 'flex' : 'none';
}

function normalizePoint(point) {
    return {
        lat: parseFloat(point.lat),
        lng: parseFloat(point.lng),
        time: point.time || null,
    };
}

function addRoutePoint(point) {
    const normalized = normalizePoint(point);
    const lastPoint = routePoints[routePoints.length - 1];

    if (!lastPoint || Math.abs(lastPoint.lat - normalized.lat) > 0.0000001 || Math.abs(lastPoint.lng - normalized.lng) > 0.0000001) {
        routePoints.push(normalized);
    }
}

function interpolateLatLng(start, end, t) {
    return [
        start.lat + (end.lat - start.lat) * t,
        start.lng + (end.lng - start.lng) * t,
    ];
}

function animateMarkerTo(targetLatLng) {
    if (!marker) {
        marker = L.marker(targetLatLng, { icon: driverIcon }).addTo(map);
        return;
    }

    const startLatLng = marker.getLatLng();
    const endLatLng = L.latLng(targetLatLng);
    const duration = 400;
    const startTime = performance.now();

    function step(timestamp) {
        const elapsed = timestamp - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const [lat, lng] = interpolateLatLng(startLatLng, endLatLng, progress);
        marker.setLatLng([lat, lng]);

        if (progress < 1) {
            requestAnimationFrame(step);
        }
    }

    requestAnimationFrame(step);
}

function renderRoute(points) {
    if (!points.length) {
        updateNoDataOverlay(true);
        updateStatus('Aucune position GPS disponible.', true);
        return;
    }

    updateNoDataOverlay(false);
    updateStatus('Carte synchronisée en temps réel.');

    const latlngs = points.map(p => [p.lat, p.lng]);
    const lastPoint = latlngs[latlngs.length - 1];

    if (polyline) {
        map.removeLayer(polyline);
    }

    if (startMarker) {
        map.removeLayer(startMarker);
        startMarker = null;
    }
    if (endMarker) {
        map.removeLayer(endMarker);
        endMarker = null;
    }

    polyline = L.polyline(latlngs, {
        color: '#2563eb',
        weight: 5,
        opacity: 0.92,
        lineJoin: 'round',
        dashArray: '10, 8',
    }).addTo(map);

    startMarker = L.marker(latlngs[0], { icon: startIcon })
        .bindPopup(`<strong>Départ</strong><br>${latlngs[0][0].toFixed(6)}, ${latlngs[0][1].toFixed(6)}`)
        .addTo(map);

    endMarker = L.marker(lastPoint, { icon: endIcon })
        .bindPopup(`<strong>Arrivée</strong><br>${lastPoint[0].toFixed(6)}, ${lastPoint[1].toFixed(6)}`)
        .addTo(map);

    animateMarkerTo(lastPoint);

    if (latlngs.length === 1) {
        map.setView(lastPoint, 13);
    } else {
        map.fitBounds(polyline.getBounds(), { padding: [70, 70] });
    }
}

function initEcho() {
    if (!demandeId) {
        updateStatus('Aucune demande sélectionnée.', true);
        updateNoDataOverlay(true);
        return;
    }

    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: @json(env('PUSHER_APP_KEY')),
        cluster: @json(env('PUSHER_APP_CLUSTER')),
        wsHost: @json(env('PUSHER_HOST', '127.0.0.1')),
        wsPort: @json(env('PUSHER_PORT', 6001)),
        wssPort: @json(env('PUSHER_PORT', 6001)),
        forceTLS: @json(filter_var(env('PUSHER_APP_USE_TLS', false), FILTER_VALIDATE_BOOLEAN)),
        encrypted: @json(filter_var(env('PUSHER_APP_USE_TLS', false), FILTER_VALIDATE_BOOLEAN)),
        enabledTransports: ['ws', 'wss'],
        disableStats: true,
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        },
    });

    window.Echo.private(`tracking.demande.${demandeId}`)
        .listen('DriverPositionUpdated', (payload) => {
            addRoutePoint(payload);
            renderRoute(routePoints);
            updateStatus(`Position mise à jour à ${payload.time} — ${parseFloat(payload.lat).toFixed(6)}, ${parseFloat(payload.lng).toFixed(6)}`);
        });
}

function fetchInitialRoute() {
    if (!demandeId) {
        updateStatus('Aucune demande sélectionnée.', true);
        updateNoDataOverlay(true);
        return;
    }

    fetch(`/tracking/${demandeId}`)
        .then(res => res.json())
        .then(points => {
            if (!points.length) {
                updateNoDataOverlay(true);
                return;
            }
            routePoints.length = 0;
            points.forEach(addRoutePoint);
            renderRoute(routePoints);
        })
        .catch(() => {
            updateStatus('Impossible de charger l’historique GPS.', true);
            updateNoDataOverlay(true);
        });
}

fetchInitialRoute();
initEcho();
</script>
@endpush