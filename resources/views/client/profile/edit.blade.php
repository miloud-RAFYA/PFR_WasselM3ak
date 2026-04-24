@extends('layouts.dashboard')

@section('title', 'Profil')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'profile'])
@endsection

@section('page-title', 'Mon Profil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Mon Profil</h1>
        <p class="text-slate-500 mt-1">Gérez vos informations personnelles</p>
    </div>

    <!-- Profile Forms -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-slate-900 mb-6">Informations personnelles</h3>
                
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-700 font-medium">Erreur lors de la mise à jour du profil:</p>
                    <ul class="mt-2 text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                @endif

                <form method="PATCH" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('prenom') border-red-500 @enderror" required>
                            @error('prenom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('nom') border-red-500 @enderror" required>
                            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700 mb-2 block">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror" required>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700 mb-2 block">Téléphone</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('phone') border-red-500 @enderror" required>
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700 mb-2 block">Adresse principale</label>
                        <textarea name="adresse_principale" rows="3" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('adresse_principale') border-red-500 @enderror" placeholder="Votre adresse...">{{ old('adresse_principale', $expediteur->adresse_principale ?? '') }}</textarea>
                        @error('adresse_principale')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('client.dashboard') }}" class="flex-1 py-2 border border-slate-200 rounded-lg text-center font-medium hover:bg-slate-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-2 rounded-lg font-medium transition-colors">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                        {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                    </div>
                    <h3 class="font-semibold text-slate-900">{{ $user->prenom }} {{ $user->nom }}</h3>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Account Stats -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="font-semibold text-slate-900 mb-4">Statistiques</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                        <span class="text-slate-500">Demandes créées</span>
                        <span class="font-bold text-slate-900">0</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                        <span class="text-slate-500">Livraisons complétées</span>
                        <span class="font-bold text-slate-900">0</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Membre depuis</span>
                        <span class="font-bold text-slate-900">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
