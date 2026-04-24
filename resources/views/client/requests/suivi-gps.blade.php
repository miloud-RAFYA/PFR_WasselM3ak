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
                        <p class="text-sm text-slate-500 mt-1">
                            Visualisez l'emplacement de votre marchandise en temps réel
                        </p>
                    </div>

                    @if ($selectedDemande)
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-xs text-slate-500">Live</span>
                        </div>
                    @endif
                </div>

                <div class="bg-slate-100 relative" style="height: 550px;">
                    <div id="map" class="h-full w-full"></div>

                    {{-- Status overlay --}}
                    <div id="tracking-status"
                        class="absolute top-4 left-4 z-20 rounded-xl bg-white/95 backdrop-blur-sm px-4 py-2.5 text-sm text-slate-700 shadow-md border border-slate-200 flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-slate-400"></div>
                        <span>Initialisation du suivi...</span>
                    </div>

                    {{-- Controls overlay --}}
                    <div class="absolute bottom-4 right-4 z-20 flex gap-2">
                        <button onclick="resetMapView()"
                            class="bg-white hover:bg-slate-50 rounded-lg p-2 shadow-md border border-slate-200 transition-colors"
                            title="Centrer la carte">
                            <i data-lucide="target" class="w-5 h-5 text-slate-600"></i>
                        </button>
                        <button onclick="toggleTraffic()"
                            class="bg-white hover:bg-slate-50 rounded-lg p-2 shadow-md border border-slate-200 transition-colors"
                            title="Couche trafic">
                            <i data-lucide="car" class="w-5 h-5 text-slate-600"></i>
                        </button>
                    </div>

                    @if (!$selectedDemande || !$selectedDemande->suivres->count())
                        <div id="tracking-empty-overlay"
                            class="absolute inset-0 flex items-center justify-center bg-white/90 backdrop-blur-sm z-10">
                            <div class="text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-full mb-3">
                                    <i data-lucide="map-pin-off" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <p class="text-slate-600 font-medium">Aucune position GPS disponible</p>
                                <p class="text-sm text-slate-400 mt-1">Sélectionnez une demande pour commencer le suivi</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Info bar --}}
                @if ($selectedDemande && $selectedDemande->suivres->count())
                    <div class="p-4 bg-slate-50 border-t border-slate-200">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    <span class="text-slate-600">Départ: {{ $selectedDemande->ville_depart }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <span class="text-slate-600">Arrivée: {{ $selectedDemande->ville_arrive }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-slate-500" id="last-update-time">Dernière mise à jour: --</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- 📦 SIDEBAR --}}
            <div class="space-y-6">

                {{-- DEMANDES EN COURS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                        <h2 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                            Demandes en cours de livraison
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">{{ $demandes->count() }} demande(s) active(s)</p>
                    </div>

                    <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                        @forelse($demandes as $demande)
                            @php
                                $last = $demande->suivres->sortByDesc('created_at')->first();
                                $isSelected = optional($selectedDemande)->id === $demande->id;
                            @endphp

                            <div
                                class="p-5 transition-all duration-200 hover:bg-slate-50 {{ $isSelected ? 'bg-primary-50 border-l-4 border-l-primary-500' : '' }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div
                                                class="h-2 w-2 rounded-full {{ $last ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                            </div>
                                            <h3 class="font-semibold text-slate-900">
                                                {{ $demande->ville_depart }} → {{ $demande->ville_arrive }}
                                            </h3>
                                        </div>

                                        <div class="flex flex-wrap gap-3 text-xs text-slate-500 mb-3">
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="package" class="w-3 h-3"></i>
                                                {{ $demande->type_marchendise }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="weight" class="w-3 h-3"></i>
                                                {{ $demande->poids_kg }} kg
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                                {{ $demande->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        @if ($last)
                                            <div class="bg-slate-100 rounded-lg p-2 mb-3">
                                                <p class="text-xs text-slate-500 mb-1">📍 Dernière position</p>
                                                <p class="text-xs font-mono text-slate-700">
                                                    {{ number_format($last->latitude, 6, '.', ',') }},
                                                    {{ number_format($last->longitude, 6, '.', ',') }}
                                                </p>
                                                <p class="text-xs text-slate-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($last->created_at)->diffForHumans() }}
                                                </p>
                                            </div>
                                        @else
                                            <div class="bg-amber-50 rounded-lg p-2 mb-3">
                                                <p class="text-xs text-amber-600 flex items-center gap-1">
                                                    <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                                    En attente de données GPS
                                                </p>
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-amber-100 text-amber-700',
                                                        'in_progress' => 'bg-sky-100 text-sky-700',
                                                        'delivered' => 'bg-emerald-100 text-emerald-700',
                                                    ];
                                                    $statusClass =
                                                        $statusColors[$demande->status] ??
                                                        'bg-slate-100 text-slate-700';
                                                @endphp
                                                <span class="text-xs px-2 py-1 rounded-full {{ $statusClass }}">
                                                    {{ $demande->status === 'pending' ? 'En attente' : ($demande->status === 'in_progress' ? 'En cours' : 'Livrée') }}
                                                </span>
                                            </div>
                                            <button onclick="selectDemande({{ $demande->id }})"
                                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 
                                                {                                           { $isSelected ? 'bg-primary-500 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                                                {{-- {{dd($isSelected)}} --}}
                                                @if ($isSelected)
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                    En cours
                                                @else
                                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                                    Suivre
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-full mb-4">
                                    <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Aucune demande active</p>
                                <p class="text-sm text-slate-400 mt-1">Les demandes suivies apparaîtront ici</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- INFORMATIONS DE SUIVI --}}
                @if ($selectedDemande && $selectedDemande->suivres->count())
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <i data-lucide="activity" class="w-5 h-5 text-primary-600"></i>
                            <h3 class="font-semibold text-primary-900">Informations de suivi</h3>
                        </div>

                        @php
                            $lastPosition = $selectedDemande->suivres->sortByDesc('created_at')->first();
                            $totalPoints = $selectedDemande->suivres->count();
                        @endphp

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-primary-800">Points enregistrés</span>
                                <span class="font-semibold text-primary-900">{{ $totalPoints }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-primary-800">Dernière mise à jour</span>
                                <span class="font-semibold text-primary-900">
                                    {{ \Carbon\Carbon::parse($lastPosition->created_at)->format('H:i:s') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-primary-800">Statut</span>
                                <span class="inline-flex items-center gap-1 text-emerald-600">
                                    <i data-lucide="wifi" class="w-3 h-3"></i>
                                    Actif
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
        }

        .leaflet-popup-content {
            margin: 8px 12px;
        }

        .custom-div-icon {
            background: transparent;
            border: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.4/echo.iife.min.js"></script>

    <script>
        // Configuration
        const demandeId = @json(optional($selectedDemande)->id);
        const departVille = @json(optional($selectedDemande)->ville_depart ?? '');
        const arriveeVille = @json(optional($selectedDemande)->ville_arrive ?? '');
        const startLatLng = @json($startLatLng ?? null);
        const endLatLng = @json($endLatLng ?? null);
        const trackingPositionsUrl = @json(optional($selectedDemande) ? route('driver.tracking', ['demande' => $selectedDemande->id]) : null);
        const pusherHost = @json(env('PUSHER_HOST'));
        const pusherPort = @json(env('PUSHER_PORT'));
        const pusherScheme = @json(env('PUSHER_SCHEME', 'https'));
        const pusherUseTls = @json(filter_var(env('PUSHER_APP_USE_TLS', true), FILTER_VALIDATE_BOOLEAN));

        let polyline;
        let marker;
        let routePoints = [];
        let trafficLayer = null;
        let routingControl = null;

        const noDataOverlay = document.getElementById('tracking-empty-overlay');
        const statusNode = document.getElementById('tracking-status');
        const lastUpdateSpan = document.getElementById('last-update-time');

        // Icône camion améliorée
        const truckSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="42" height="42">
    <rect x="8" y="28" width="48" height="24" rx="4" fill="#2563eb" stroke="#1e3a8a" stroke-width="2"/>
    <rect x="28" y="20" width="20" height="8" fill="#3b82f6" stroke="#1e3a8a" stroke-width="1"/>
    <circle cx="18" cy="52" r="6" fill="#1e3a8a" stroke="#0f172a" stroke-width="1.5"/>
    <circle cx="46" cy="52" r="6" fill="#1e3a8a" stroke="#0f172a" stroke-width="1.5"/>
    <rect x="12" y="32" width="8" height="12" fill="#60a5fa" rx="1"/>
    <rect x="44" y="32" width="8" height="12" fill="#60a5fa" rx="1"/>
</svg>`;

        const driverIcon = L.icon({
            iconUrl: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(truckSvg),
            iconSize: [42, 42],
            iconAnchor: [21, 35],
            popupAnchor: [0, -35],
        });

        // Icônes départ/arrivée
        const startIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="width:24px;height:24px;background:#10b981;border:4px solid #fff;border-radius:50%;box-shadow:0 0 10px rgba(16,185,129,0.5);"></div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
        });

        const endIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="width:24px;height:24px;background:#ef4444;border:4px solid #fff;border-radius:50%;box-shadow:0 0 10px rgba(239,68,68,0.5);"></div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
        });

        let startMarker = null;
        let endMarker = null;

        // Initialisation de la carte
        const map = L.map('map', {
            zoomControl: true,
            attributionControl: true,
            minZoom: 4,
            maxZoom: 18,
        }).setView([31.79, -7.09], 6);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
        }).addTo(map);

        L.control.scale({
            metric: true,
            imperial: false,
            position: 'bottomleft'
        }).addTo(map);

        // Fonctions utilitaires
        function updateStatus(message, isError = false) {
            if (!statusNode) return;
            const span = statusNode.querySelector('span');
            const dot = statusNode.querySelector('.h-2');
            if (span) span.textContent = message;
            if (dot) {
                dot.className = `h-2 w-2 rounded-full ${isError ? 'bg-red-500' : 'bg-emerald-500 animate-pulse'}`;
            }
            if (isError) {
                statusNode.classList.add('border-red-200', 'bg-red-50');
            } else {
                statusNode.classList.remove('border-red-200', 'bg-red-50');
            }
        }

        function updateLastUpdateTime(time) {
            if (lastUpdateSpan) {
                lastUpdateSpan.textContent = `Dernière mise à jour: ${time || new Date().toLocaleTimeString()}`;
            }
        }

        function updateNoDataOverlay(visible) {
            if (!noDataOverlay) return;
            noDataOverlay.style.display = visible ? 'flex' : 'none';
        }

        function normalizePoint(point) {
            return {
                lat: parseFloat(point.latitude || point.lat),
                lng: parseFloat(point.longitude || point.lng),
                time: point.created_at || point.time || null,
            };
        }

        function addRoutePoint(point) {
            const normalized = normalizePoint(point);
            const lastPoint = routePoints[routePoints.length - 1];

            if (!lastPoint || Math.abs(lastPoint.lat - normalized.lat) > 0.00001 ||
                Math.abs(lastPoint.lng - normalized.lng) > 0.00001) {
                routePoints.push(normalized);
                return true;
            }
            return false;
        }

        function interpolateLatLng(start, end, t) {
            return [
                start.lat + (end.lat - start.lat) * t,
                start.lng + (end.lng - start.lng) * t,
            ];
        }

        function animateMarkerTo(targetLatLng, duration = 500) {
            if (!marker) {
                marker = L.marker(targetLatLng, {
                    icon: driverIcon
                }).addTo(map);
                marker.bindPopup('<strong>📦 Votre marchandise</strong><br>Position actuelle');
                return;
            }

            const startLatLng = marker.getLatLng();
            const endLatLng = L.latLng(targetLatLng);
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
            updateStatus('Carte synchronisée en temps réel');
            updateLastUpdateTime(points[points.length - 1]?.time);

            const latlngs = points.map(p => [p.lat, p.lng]);
            const lastPoint = latlngs[latlngs.length - 1];
            const firstPoint = latlngs[0];

            // Supprimer les anciennes couches
            if (polyline) map.removeLayer(polyline);
            if (startMarker) map.removeLayer(startMarker);
            if (endMarker) map.removeLayer(endMarker);
            if (routingControl) map.removeControl(routingControl);

            // Tracer la route
            polyline = L.polyline(latlngs, {
                color: '#2563eb',
                weight: 5,
                opacity: 0.85,
                lineJoin: 'round',
                lineCap: 'round',
            }).addTo(map);

            // Ajouter un effet de gradient sur la ligne
            polyline.on('add', function() {
                const gradient = L.polyline(latlngs, {
                    color: '#3b82f6',
                    weight: 3,
                    opacity: 0.4,
                    lineJoin: 'round',
                }).addTo(map);
                setTimeout(() => map.removeLayer(gradient), 100);
            });

            // Marqueurs départ et arrivée
            startMarker = L.marker(firstPoint, {
                    icon: startIcon
                })
                .bindPopup(
                    `<strong>📍 Départ</strong><br>${firstPoint[0].toFixed(6)}, ${firstPoint[1].toFixed(6)}<br>${departVille || 'Point de départ'}`
                )
                .addTo(map);

            endMarker = L.marker(lastPoint, {
                    icon: endIcon
                })
                .bindPopup(
                    `<strong>🏁 Arrivée</strong><br>${lastPoint[0].toFixed(6)}, ${lastPoint[1].toFixed(6)}<br>${arriveeVille || 'Point d\'arrivée'}`
                )
                .addTo(map);

            // Animation du marqueur
            animateMarkerTo(lastPoint);

            // Ajuster la vue
            if (latlngs.length === 1) {
                map.setView(lastPoint, 13);
            } else {
                map.fitBounds(polyline.getBounds(), {
                    padding: [50, 50]
                });
            }
        }

        function selectDemande(demandeId) {
            const url = new URL(window.location.href);
            url.searchParams.set('demande_id', demandeId);
            window.location.href = url.toString();
        }

        function resetMapView() {
            if (routePoints.length) {
                const latlngs = routePoints.map(p => [p.lat, p.lng]);
                const bounds = L.latLngBounds(latlngs);
                map.fitBounds(bounds, {
                    padding: [50, 50]
                });
            } else if (startLatLng && endLatLng) {
                const bounds = L.latLngBounds([startLatLng.lat, startLatLng.lng], [endLatLng.lat, endLatLng.lng]);
                map.fitBounds(bounds, {
                    padding: [50, 50]
                });
            }
        }

        function toggleTraffic() {
            if (trafficLayer) {
                map.removeLayer(trafficLayer);
                trafficLayer = null;
                showToast('Couche trafic désactivée', 'info');
            } else {
                trafficLayer = L.tileLayer(
                    'https://{s}.tile.thunderforest.com/transport/{z}/{x}/{y}.png?apikey={{ env('THUNDERFOREST_API_KEY', 'your-key') }}', {
                        attribution: '&copy; <a href="https://www.thunderforest.com/">Thunderforest</a>',
                        maxZoom: 18,
                    }).addTo(map);
                showToast('Couche trafic activée', 'success');
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg text-white z-50 animate-in ${
        type === 'success' ? 'bg-emerald-500' : 'bg-blue-500'
    }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        function initEcho() {
            if (!demandeId) {
                updateStatus('Aucune demande sélectionnée.', true);
                updateNoDataOverlay(true);
                return;
            }

            window.Pusher = Pusher;
            const echoOptions = {
                broadcaster: 'pusher',
                key: @json(env('PUSHER_APP_KEY')),
                cluster: @json(env('PUSHER_APP_CLUSTER')),
                forceTLS: pusherUseTls,
                encrypted: pusherUseTls,
                enabledTransports: ['ws', 'wss'],
                disableStats: true,
            };

            if (pusherHost) {
                echoOptions.wsHost = pusherHost;
            }

            if (pusherPort) {
                echoOptions.wsPort = pusherPort;
                echoOptions.wssPort = pusherPort;
            }

            if (pusherScheme) {
                echoOptions.scheme = pusherScheme;
            }

            window.Echo = new Echo(echoOptions);

            const pusherConnection = window.Echo.connector?.pusher?.connection;
            if (pusherConnection) {
                pusherConnection.bind('connected', () => updateStatus('Connexion WebSocket établie.'));
                pusherConnection.bind('disconnected', () => updateStatus('Connexion WebSocket déconnectée.', true));
                pusherConnection.bind('error', (err) => updateStatus('Erreur WebSocket : ' + (err?.message ||
                    'Échec de connexion'), true));
            }

            window.Echo.private(`tracking.demande.${demandeId}`)
                .listen('DriverPositionUpdated', (payload) => {
                    const added = addRoutePoint(payload);
                    if (added) {
                        renderRoute(routePoints);
                    }
                    updateStatus(
                        `Position mise à jour — ${parseFloat(payload.lat).toFixed(6)}, ${parseFloat(payload.lng).toFixed(6)}`
                    );
                });
        }

        function fetchInitialRoute() {
            if (!demandeId) {
                updateStatus('Aucune demande sélectionnée.', true);
                updateNoDataOverlay(true);
                return;
            }

            if (!trackingPositionsUrl) {
                updateStatus('Impossible de déterminer l’URL de suivi.', true);
                return;
            }

            updateStatus('Chargement des positions GPS...');
            fetch(trackingPositionsUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
                .then(res => {
                    if (!res.ok) {
                        return res.text().then(text => {
                            throw new Error(`HTTP ${res.status}: ${text.slice(0, 200)}`);
                        });
                    }
                    return res.json();
                })
                .then(points => {
                    if (!points || !points.length) {
                        updateNoDataOverlay(true);
                        updateStatus('Aucune donnée GPS disponible.', true);
                        return;
                    }
                    routePoints.length = 0;
                    points.forEach(addRoutePoint);
                    renderRoute(routePoints);
                })
                .catch(err => {
                    console.error('Erreur fetch:', err);
                    updateStatus('Impossible de charger l\'historique GPS. ' + err.message, true);
                    updateNoDataOverlay(true);
                });
        }

        // Initialisation
        if (demandeId) {
            fetchInitialRoute();
            initEcho();
        } else {
            updateStatus('Sélectionnez une demande pour commencer le suivi', true);
            updateNoDataOverlay(true);
        }

        // Rafraîchissement périodique
        setInterval(() => {
            if (demandeId && routePoints.length === 0) {
                fetchInitialRoute();
            }
        }, 30000);

        // Initialiser Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
@endpush
