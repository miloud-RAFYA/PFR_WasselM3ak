@extends('layouts.auth')

@section('title', 'Inscription Chauffeur - Étape 3')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    <!-- Return Button -->
    <a href="{{ route('home') }}" class="absolute top-4 left-4 z-10 flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg shadow-md transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Retour
    </a>

    <div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        {{-- Côté gauche : image --}}
        <div class="hidden md:block">
            <img src="{{ asset('images/driver-illustration.png') }}" alt="Logistique" class="h-full w-full object-cover">
        </div>

        {{-- Côté droit : Formulaire --}}
        <div class="p-10">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <div class="w-14 h-14 bg-primary-500 rounded-full flex items-center justify-center shadow-lg">
                        <i data-lucide="truck" class="w-7 h-7 text-white"></i>
                    </div>
                    <span class="text-3xl font-bold text-slate-800">
                        <span class="text-primary-500">Wassel</span>M3ak
                    </span>
                </a>
                <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Finalisation de l'inscription</h2>
                <p class="text-slate-500">Vérifiez vos informations avant de valider</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-slate-500">Étape 3 sur 3</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-slate-500">
                    <span>Informations de base</span>
                    <span>Véhicule & Documents</span>
                    <span class="text-primary-600 font-medium">Vérification</span>
                </div>
            </div>

            <!-- Review Information -->
            <div class="space-y-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 mb-2">Vérifiez vos informations</h2>
                    <p class="text-slate-600">Assurez-vous que toutes les informations sont correctes avant de finaliser votre inscription.</p>
                </div>

                @php
                    $step1 = session('onboarding.step1', []);
                    $step2 = session('onboarding.step2', []);
                @endphp

                <!-- Informations personnelles -->
                <div class="bg-slate-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-primary-500"></i>
                        Informations personnelles
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-slate-700">Nom complet:</span>
                            <span class="text-slate-900 ml-2">{{ $step1['nom'] ?? '' }} {{ $step1['prenom'] ?? '' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-slate-700">Email:</span>
                            <span class="text-slate-900 ml-2">{{ $step1['email'] ?? '' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-slate-700">Téléphone:</span>
                            <span class="text-slate-900 ml-2">{{ $step1['phone'] ?? '' }}</span>
                        </div>
                        @if(isset($step1['numero_permis']) && $step1['numero_permis'])
                        <div>
                            <span class="font-medium text-slate-700">Numéro de permis:</span>
                            <span class="text-slate-900 ml-2">{{ $step1['numero_permis'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informations véhicule -->
                <div class="bg-slate-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                        Informations du véhicule
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-slate-700">Type:</span>
                            <span class="text-slate-900 ml-2">
                                @switch($step2['type_vehicule'] ?? '')
                                    @case('camion') Petit Camion @break
                                    @case('fourgonnette') Fourgonnette @break
                                    @case('voiture') Voiture commerciale @break
                                @endswitch
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-slate-700">Immatriculation:</span>
                            <span class="text-slate-900 ml-2">{{ $step2['immatriculation'] ?? '' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-slate-700">Capacité charge:</span>
                            <span class="text-slate-900 ml-2">{{ $step2['capacite_charge_kg'] ?? '' }} Kg</span>
                        </div>
                        @if(isset($step2['capacite_volume_m3']) && $step2['capacite_volume_m3'])
                        <div>
                            <span class="font-medium text-slate-700">Capacité volume:</span>
                            <span class="text-slate-900 ml-2">{{ $step2['capacite_volume_m3'] }} m³</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-slate-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="file-check" class="w-5 h-5 text-primary-500"></i>
                        Documents fournis
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                            <span class="text-slate-900">Permis de conduire</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                            <span class="text-slate-900">Carte grise</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                            <span class="text-slate-900">Assurance</span>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 mt-0.5"></i>
                        <div>
                            <h4 class="font-medium text-yellow-800 mb-1">Important</h4>
                            <p class="text-sm text-yellow-700">
                                Après validation, votre compte sera soumis à vérification par notre équipe.
                                Vous recevrez un email de confirmation une fois votre compte activé.
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('driver.onboarding.complete') }}">
                    @csrf

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <ul class="text-sm text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="flex justify-between pt-6 border-t border-slate-200">
                        <a href="{{ route('driver.onboarding.step2') }}"
                            class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-3 rounded-xl font-medium transition-colors flex items-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Modifier</span>
                        </a>

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg hover:shadow-xl">
                            <span>Finaliser l'inscription</span>
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
