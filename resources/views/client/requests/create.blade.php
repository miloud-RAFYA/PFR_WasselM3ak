@extends('layouts.dashboard')

@section('title', 'Nouvelle demande')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests.create'])
@endsection

@section('page-title', 'Nouvelle demande de transport')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-semibold text-slate-900">Détails de la demande</h3>
        </div>
        <div class="p-6 space-y-6">
            <form method="POST" action="{{ route('client.requests.store') }}">
                @csrf
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Ville de départ</label>
                        <div class="relative">
                            <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="text" name="from_city" placeholder="ex: Casablanca" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Ville d'arrivée</label>
                        <div class="relative">
                            <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="text" name="to_city" placeholder="ex: Rabat" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 mb-4">
                    <label class="text-sm font-medium text-slate-700">Type de marchandise</label>
                    <select name="item_type" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="meubles">Meubles</option>
                        <option value="electromenager">Électroménager</option>
                        <option value="velo">Vélos / 2 roues</option>
                        <option value="cartons">Cartons</option>
                        <option value="palettes">Palettes</option>
                        <option value="divers">Divers</option>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Poids estimé (kg)</label>
                        <div class="relative">
                            <i data-lucide="weight" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="number" name="weight" placeholder="ex: 50" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Date souhaitée</label>
                        <div class="relative">
                            <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="date" name="delivery_date" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 mb-4">
                    <label class="text-sm font-medium text-slate-700">Description détaillée</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Décrivez votre marchandise (dimensions, fragilité, etc.)..."></textarea>
                </div>

                <div class="space-y-2 mb-6">
                    <label class="text-sm font-medium text-slate-700">Prix proposé (DH)</label>
                    <div class="relative">
                        <i data-lucide="dollar-sign" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input type="number" name="proposed_price" placeholder="ex: 350" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('client.dashboard') }}" class="flex-1 py-3 border border-slate-200 rounded-lg font-medium text-center hover:bg-slate-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-medium transition-colors">
                        Publier la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
