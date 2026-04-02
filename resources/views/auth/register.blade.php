@extends('layouts.auth')

@section('title', 'Inscription Chauffeur - WasselM3ak')

@section('content')
<div class="min-h-screen bg-[#111111] flex items-center justify-center p-4 md:p-8 font-sans antialiased text-slate-200">

    {{-- Conteneur Principal (Ombre + Coins Arrondis) --}}
    <div class="max-w-7xl w-full bg-[#1A1A1A] rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        {{-- Côté Gauche : Formulaire (Fond sombre) --}}
        <div class="p-8 md:p-16 flex flex-col justify-center">

            {{-- Logo et En-tête --}}
            <div class="mb-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="truck" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-3xl font-bold text-white">
                        <span class="text-primary-500">Wassel</span>M3ak
                    </span>
                </a>
                <h1 class="text-4xl font-bold text-white tracking-tight mb-2">Créer votre compte chauffeur</h1>
                <p class="text-slate-400 text-lg">Rejoignez notre réseau de transporteurs professionnels.</p>
            </div>

            {{-- Bouton Connexion Google --}}
            <button class="w-full flex items-center justify-center gap-3 bg-[#2A2A2A] hover:bg-[#333333] text-white py-3.5 px-6 rounded-xl transition-colors border border-[#3A3A3A] mb-6 shadow-sm">
                <img src="{{ asset('images/google-icon.svg') }}" alt="Google" class="w-5 h-5">
                <span class="font-medium">Continuer avec Google</span>
            </button>

            {{-- Séparateur "ou" --}}
            <div class="relative mb-8">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-[#3A3A3A]"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-[#1A1A1A] px-3 text-sm text-slate-500 uppercase tracking-widest">ou</span>
                </div>
            </div>

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ showPassword: false }">
                @csrf

                {{-- Barre de Progression (Inspirée de l'image mais adaptée) --}}
                <div class="mb-8 p-4 bg-[#2A2A2A] rounded-xl border border-[#3A3A3A]">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-primary-400">Étape 1 : Informations de base</span>
                        <span class="text-xs text-slate-500">1 / 3</span>
                    </div>
                    <div class="w-full bg-[#3A3A3A] rounded-full h-2">
                        <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" style="width: 33%"></div>
                    </div>
                </div>

                {{-- Erreurs --}}
                @if($errors->any())
                    <div class="bg-red-900/50 border border-red-700 text-red-200 rounded-xl p-4 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Champs Nom & Prénom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nom *</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" required
                            class="w-full px-4 py-3 bg-[#2A2A2A] border {{ $errors->has('nom') ? 'border-red-600' : 'border-[#3A3A3A]' }} rounded-xl text-white placeholder-slate-600 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="Votre nom">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Prénom *</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" required
                            class="w-full px-4 py-3 bg-[#2A2A2A] border {{ $errors->has('prenom') ? 'border-red-600' : 'border-[#3A3A3A]' }} rounded-xl text-white placeholder-slate-600 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="Votre prénom">
                    </div>
                </div>

                {{-- Champ Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Adresse email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-[#2A2A2A] border {{ $errors->has('email') ? 'border-red-600' : 'border-[#3A3A3A]' }} rounded-xl text-white placeholder-slate-600 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        placeholder="votre@email.com">
                </div>

                {{-- Champ Téléphone --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Téléphone *</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 bg-[#2A2A2A] border {{ $errors->has('phone') ? 'border-red-600' : 'border-[#3A3A3A]' }} rounded-xl text-white placeholder-slate-600 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        placeholder="+212 600 000 000">
                </div>

                {{-- Champ Mot de Passe --}}
                <div class="sm:col-span-2 relative">
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Mot de passe *</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full px-4 py-3 pr-12 bg-[#2A2A2A] border {{ $errors->has('password') ? 'border-red-600' : 'border-[#3A3A3A]' }} rounded-xl text-white placeholder-slate-600 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 p-1">
                            <i data-lucide="eye" class="w-5 h-5" x-show="!showPassword"></i>
                            <i data-lucide="eye-off" class="w-5 h-5" x-show="showPassword" x-cloak></i>
                        </button>
                    </div>
                </div>

                {{-- Bouton Soumettre --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-500 text-white py-4 px-8 rounded-xl font-semibold transition-all flex items-center justify-center gap-3 shadow-lg hover:shadow-primary-500/20 active:scale-[0.98]">
                        <span>Continuer vers l'étape 2</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </form>

            {{-- Lien Connexion --}}
            <p class="text-center mt-10 text-slate-500">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-medium transition-colors">
                    Se connecter
                </a>
            </p>
        </div>

        {{-- Côté Droit : Illustration & Texte (Fond dégradé violet comme l'image) --}}
        <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-[#6D28D9] via-[#4F46E5] to-[#7C3AED] p-16 relative overflow-hidden">
            
            {{-- Effet de grille en arrière-plan (optionnel, pour plus de ressemblance) --}}
            <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 40px 40px;"></div>

            {{-- Illustration centrale --}}
            <div class="relative z-10 flex-grow flex items-center justify-center">
                <img src="{{ asset('images/driver-illustration.png') }}" 
                     alt="Illustration Chauffeur WasselM3ak" 
                     class="max-w-full h-auto object-contain transform hover:scale-105 transition-transform duration-500 ease-out drop-shadow-2xl">
            </div>

            {{-- Texte du bas (Inspiré de l'image) --}}
            <div class="relative z-10 text-center mt-12 bg-white/5 backdrop-blur-sm p-8 rounded-2xl border border-white/10 shadow-xl">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-white rounded-2xl shadow-inner mb-6">
                     <i data-lucide="shield-check" class="w-8 h-8 text-primary-600"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-white leading-tight mb-4">Un service fiable et sécurisé</h3>
                <p class="text-purple-100 text-lg max-w-md mx-auto">Offrez le meilleur service de transport à nos clients en rejoignant une plateforme conçue pour votre réussite.</p>
            </div>
            
            {{-- Bouton Retour (Déplacé ici pour le style) --}}
            <a href="{{ route('home') }}" class="absolute top-6 right-6 z-20 flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg backdrop-blur-sm transition-colors border border-white/10 shadow-md text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Retour à l'accueil
            </a>
        </div>

    </div>
</div>

{{-- Styles additionnels pour les champs obligatoires (*) et x-cloak --}}
<style>
    [x-cloak] { display: none !important; }
    label::after {
        content: " *";
        color: #ef4444; /* red-500 */
    }
    /* Désactiver l'autofill jaune sur fond sombre */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px #2A2A2A inset !important;
        -webkit-text-fill-color: white !important;
    }
</style>
@endsection