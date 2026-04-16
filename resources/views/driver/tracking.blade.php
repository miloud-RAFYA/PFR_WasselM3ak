@extends('layouts.dashboard')

@section('title', 'Suivi GPS Chauffeur')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'messages'])
@endsection

@section('page-title', 'Suivi GPS Chauffeur')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Envoi de position GPS</h1>
                <p class="text-sm text-slate-500">Votre position sera envoyée automatiquement toutes les 5 secondes pour le suivi en temps réel.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-500">Demande : {{ $demande->reference }}</p>
                <p class="text-sm text-slate-500">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</p>
            </div>
        </div>

        <div class="p-6">
            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-6">
                <p class="text-slate-700">Ouvrez cette page depuis le navigateur de votre mobile et laissez-la ouverte pendant la livraison.</p>
                <p class="text-sm text-slate-500 mt-3">Votre position sera envoyée à l’application client pour mise à jour du suivi.</p>
                <p id="tracking-status" class="text-sm mt-4 text-amber-600">Activation du GPS en cours...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const demandeId = @json($demande->id);
const demandeStatus = @json($demande->status);
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let watchId = null;
let retryTimeout = null;
let trackingActive = false;
const GEO_OPTIONS = {
    enableHighAccuracy: true,
    timeout: 20000,
    maximumAge: 5000,
};

function updateStatus(message, isError = false) {
    const statusNode = document.getElementById('tracking-status');
    statusNode.textContent = message;
    statusNode.classList.toggle('text-amber-600', !isError);
    statusNode.classList.toggle('text-red-600', isError);
}

function stopTracking(reason) {
    if (watchId !== null) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
    }

    if (retryTimeout) {
        clearTimeout(retryTimeout);
        retryTimeout = null;
    }

    trackingActive = false;
    updateStatus(reason || 'Suivi GPS arrêté.');
}

function sendPosition(coords) {
    fetch('/api/send-position', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            latitude: coords.latitude,
            longitude: coords.longitude,
            demande_id: demandeId,
        }),
    }).then(response => {
        if (!response.ok) {
            throw new Error('Erreur serveur');
        }
        updateStatus('Position envoyée : ' + new Date().toLocaleTimeString());
    }).catch(() => {
        updateStatus('Impossible d’envoyer la position.', true);
    });
}

function handlePosition(position) {
    sendPosition(position.coords);
}

function scheduleRetry() {
    if (retryTimeout) {
        clearTimeout(retryTimeout);
    }

    retryTimeout = setTimeout(() => {
        if (!trackingActive || !navigator.geolocation) {
            return;
        }

        navigator.geolocation.getCurrentPosition(handlePosition, handleError, GEO_OPTIONS);
    }, 5000);
}

function handleError(error) {
    let message = error.message;

    if (error.code === error.PERMISSION_DENIED) {
        message = 'Permission de localisation refusée.';
    } else if (error.code === error.POSITION_UNAVAILABLE) {
        message = 'Position introuvable. Vérifiez le signal GPS.';
    } else if (error.code === error.TIMEOUT) {
        message = 'Délai trop long, tentative de nouvelle lecture...';
        scheduleRetry();
    }

    updateStatus('Erreur géolocalisation : ' + message, true);
}

function startTracking() {
    if (trackingActive || !demandeId) {
        return;
    }

    if (demandeStatus !== 'in_progress') {
        updateStatus('Le suivi GPS démarre automatiquement lorsque la demande passe en cours.', true);
        return;
    }

    if (!navigator.geolocation) {
        updateStatus('Géolocalisation non supportée par votre navigateur.', true);
        return;
    }

    trackingActive = true;
    updateStatus('Suivi GPS actif. Recherche de position...');
    watchId = navigator.geolocation.watchPosition(handlePosition, handleError, GEO_OPTIONS);
}

function initializeTrackingStatus() {
    if (demandeStatus === 'delivered') {
        stopTracking('Demande terminée. Le suivi est arrêté.');
        return;
    }

    startTracking();
}

if (demandeId) {
    initializeTrackingStatus();
}
</script>
@endpush
