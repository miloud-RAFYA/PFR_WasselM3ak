@extends('layouts.auth')

@section('title', 'Inscription Chauffeur - Étape 2')

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
                <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Informations du véhicule</h2>
                <p class="text-slate-500">Détails de votre véhicule et documents requis</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-slate-500">Étape 2 sur 3</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" style="width: 66%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-slate-500">
                    <span>Informations de base</span>
                    <span class="text-primary-600 font-medium">Véhicule & Documents</span>
                    <span>Vérification</span>
                </div>
            </div>

            <form method="POST" action="{{ route('driver.onboarding.store.step2') }}" enctype="multipart/form-data" class="space-y-6">
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

                <!-- Informations Véhicule -->
                <div class="bg-slate-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                        Informations du véhicule
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Type de véhicule -->
                        @php
                            $typeVehiculeClass = $errors->has('type_vehicule') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Type de véhicule *</label>
                            <select name="type_vehicule"
                                class="w-full px-4 py-3 border {{ $typeVehiculeClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Sélectionnez un type</option>
                                <option value="camion" {{ old('type_vehicule') == 'camion' ? 'selected' : '' }}>Petit Camion</option>
                                <option value="fourgonnette" {{ old('type_vehicule') == 'fourgonnette' ? 'selected' : '' }}>Fourgonnette</option>
                                <option value="voiture" {{ old('type_vehicule') == 'voiture' ? 'selected' : '' }}>Voiture commerciale</option>
                            </select>
                            @error('type_vehicule')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Immatriculation -->
                        @php
                            $immatriculationClass = $errors->has('immatriculation') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Immatriculation *</label>
                            <input type="text" name="immatriculation" value="{{ old('immatriculation') }}"
                                class="w-full px-4 py-3 border {{ $immatriculationClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="AA-123-AA">
                            @error('immatriculation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacité de charge -->
                        @php
                            $capaciteChargeClass = $errors->has('capacite_charge_kg') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Capacité de charge (Kg) *</label>
                            <input type="number" name="capacite_charge_kg" value="{{ old('capacite_charge_kg') }}"
                                class="w-full px-4 py-3 border {{ $capaciteChargeClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="1000" min="0">
                            @error('capacite_charge_kg')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacité volume -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Capacité volume (m³)</label>
                            <input type="number" name="capacite_volume_m3" value="{{ old('capacite_volume_m3') }}"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="5.0" min="0" step="0.1">
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-slate-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-primary-500"></i>
                        Documents requis
                    </h3>
                    <p class="text-sm text-slate-600 mb-6">Formats acceptés : JPG, PNG ou PDF (max 2MB chacun)</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Permis de conduire -->
                        @php
                            $permisConduireClass = $errors->has('permis_conduire') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Permis de conduire *</label>
                            <div class="relative">
                                <input type="file" name="permis_conduire" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full px-4 py-3 border {{ $permisConduireClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            </div>
                            @error('permis_conduire')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Carte grise -->
                        @php
                            $carteGriseClass = $errors->has('carte_grise') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Carte grise *</label>
                            <div class="relative">
                                <input type="file" name="carte_grise" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full px-4 py-3 border {{ $carteGriseClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            </div>
                            @error('carte_grise')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Assurance -->
                        @php
                            $assuranceClass = $errors->has('assurance') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Assurance *</label>
                            <div class="relative">
                                <input type="file" name="assurance" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full px-4 py-3 border {{ $assuranceClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            </div>
                            @error('assurance')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between pt-6 border-t border-slate-200">
                    <a href="{{ route('driver.onboarding.step1') }}"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-3 rounded-xl font-medium transition-colors flex items-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Précédent</span>
                    </a>

                    <button type="submit"
                        class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <span>Suivant</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
