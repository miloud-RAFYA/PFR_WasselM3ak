@extends('layouts.auth')

@section('title', 'Inscription Chauffeur - Étape 1')

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
                <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Devenir Chauffeur</h2>
                <p class="text-slate-500">Rejoignez notre réseau de transporteurs professionnels</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-slate-500">Étape 1 sur 3</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" style="width: 33%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-slate-500">
                    <span class="text-primary-600 font-medium">Informations de base</span>
                    <span>Véhicule & Documents</span>
                    <span>Vérification</span>
                </div>
            </div>

            <form method="POST" action="{{ route('driver.onboarding.store.step1') }}" class="space-y-6" x-data="{ showPassword: false }">
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nom -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nom *</label>
                        @php
                            $nomClass = $errors->has('nom') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <input type="text" name="nom" value="{{ old('nom') }}"
                            class="w-full px-4 py-3 border {{ $nomClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Votre nom">
                        @error('nom')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Prénom *</label>
                        @php
                            $prenomClass = $errors->has('prenom') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <input type="text" name="prenom" value="{{ old('prenom') }}"
                            class="w-full px-4 py-3 border {{ $prenomClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Votre prénom">
                        @error('prenom')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse email *</label>
                        @php
                            $emailClass = $errors->has('email') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 border {{ $emailClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="votre@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone *</label>
                        @php
                            $phoneClass = $errors->has('phone') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-3 border {{ $phoneClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="+212 600 000 000">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Numéro de permis (optionnel) -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Numéro de permis</label>
                        <input type="text" name="numero_permis" value="{{ old('numero_permis') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Numéro de permis (optionnel)">
                    </div>

                    <!-- Mot de passe -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe *</label>
                        @php
                            $passwordClass = $errors->has('password') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password"
                                class="w-full px-4 py-3 pr-12 border {{ $passwordClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" class="w-5 h-5" x-show="!showPassword"></i>
                                <i data-lucide="eye-off" class="w-5 h-5" x-show="showPassword"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le mot de passe *</label>
                        @php
                            $passwordConfirmationClass = $errors->has('password_confirmation') ? 'border-red-300' : 'border-slate-200';
                        @endphp
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-3 border {{ $passwordConfirmationClass }} rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="••••••••">
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-end pt-6 border-t border-slate-200">
                    <button type="submit"
                        class="bg-primary-500 hover:bg-primary-600 text-white py-3 px-8 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <span>Suivant</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <p class="text-center mt-6 text-sm text-slate-600">
                Déjà un compte ?
                <a href="{{ route('login.form') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                    Se connecter
                </a>
            </p>
        </div>

    </div>
</div>
@endsection

               