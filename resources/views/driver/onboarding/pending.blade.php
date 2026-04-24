@extends('layouts.app')

@section('title', 'Vérification en cours - WasselM3ak')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        {{-- Côté gauche : image --}}
        <div class="hidden md:block">
            <img src="{{ asset('images/driver-illustration.png') }}" alt="Logistique" class="h-full w-full object-cover">
        </div>

        {{-- Côté droit : Contenu --}}
        <div class="p-10 text-center">
            <div class="mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <div class="w-14 h-14 bg-primary-500 rounded-full flex items-center justify-center shadow-lg">
                        <i data-lucide="truck" class="w-7 h-7 text-white"></i>
                    </div>
                    <span class="text-3xl font-bold text-slate-800">
                        <span class="text-primary-500">Wassel</span>M3ak
                    </span>
                </a>
            </div>

            <!-- Icon -->
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="clock" class="w-10 h-10 text-yellow-600"></i>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-slate-900 mb-4">Vérification en cours</h1>

            <!-- Message -->
            <p class="text-slate-600 mb-6 leading-relaxed">
                Merci pour votre inscription ! Votre compte est en cours de vérification par notre équipe.
                Vous recevrez un email de confirmation dans les plus brefs délais.
            </p>

            <!-- Status -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-center gap-2 text-yellow-800">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    <span class="text-sm font-medium">Statut : En attente de vérification</span>
                </div>
            </div>

            <!-- What happens next -->
            <div class="text-left bg-slate-50 rounded-xl p-6 mb-6">
                <h3 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-primary-500"></i>
                    Que se passe-t-il ensuite ?
                </h3>
                <ul class="text-sm text-slate-600 space-y-3">
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mt-0.5"></i>
                        <span>Vérification de vos documents par notre équipe</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="clock" class="w-4 h-4 text-yellow-600 mt-0.5"></i>
                        <span>Validation de votre véhicule et permis</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-600 mt-0.5"></i>
                        <span>Email de confirmation d'activation</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="truck" class="w-4 h-4 text-primary-600 mt-0.5"></i>
                        <span>Accès à votre tableau de bord chauffeur</span>
                    </li>
                </ul>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('home') }}"
                    class="block w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-6 rounded-xl font-medium transition-colors shadow-lg hover:shadow-xl">
                    Retour à l'accueil
                </a>

                <button onclick="window.location.reload()"
                    class="block w-full bg-slate-200 hover:bg-slate-300 text-slate-700 py-3 px-6 rounded-xl font-medium transition-colors">
                    Actualiser le statut
                </button>
            </div>

            <!-- Contact -->
            <p class="text-xs text-slate-500 mt-6">
                Des questions ? Contactez-nous à
                <a href="mailto:support@wasselm3ak.com" class="text-primary-500 hover:text-primary-600 font-medium">
                    support@wasselm3ak.com
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
