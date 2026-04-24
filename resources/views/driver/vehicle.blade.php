@extends('layouts.dashboard')

@section('title', 'Mon véhicule')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'vehicle'])
@endsection

@section('page-title', 'Mon véhicule')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-semibold text-slate-900">Informations du véhicule</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-24 h-24 bg-slate-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="truck" class="w-12 h-12 text-slate-400"></i>
                </div>
                <div>
                    <p class="text-xl font-semibold text-slate-900">Renault Master</p>
                    <p class="text-slate-500">Camionnette • Blanc</p>
                    <span class="inline-block mt-2 px-2 py-1 bg-green-500 text-white text-xs rounded-full">Vérifié</span>
                </div>
            </div>

            <form method="POST" action="{{ route('driver.vehicle.update') }}">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Marque</label>
                        <input type="text" name="brand" value="Renault" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Modèle</label>
                        <input type="text" name="model" value="Master" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Immatriculation</label>
                        <input type="text" name="license_plate" value="12345-A-67" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Année</label>
                        <input type="number" name="year" value="2020" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="space-y-2 mb-4">
                    <label class="text-sm font-medium text-slate-700">Capacité de charge (kg)</label>
                    <input type="number" name="capacity" value="1500" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div class="space-y-2 mb-6">
                    <label class="text-sm font-medium text-slate-700">Dimensions du chargement (m)</label>
                    <div class="grid grid-cols-3 gap-4">
                        <input type="number" name="length" value="3.5" placeholder="Longueur" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <input type="number" name="width" value="1.8" placeholder="Largeur" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <input type="number" name="height" value="1.9" placeholder="Hauteur" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="reset" class="flex-1 py-3 border border-slate-200 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-medium transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
