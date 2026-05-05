@extends('layouts.dashboard')

@section('title', 'Mon véhicule')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'vehicle'])
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Mon véhicule</h1>
        <p class="text-slate-500 mt-1">Gérez les informations de votre véhicule professionnel</p>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5"></i>
            <p class="text-emerald-800">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"></i>
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Carte formulaire --}}
    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                Informations du véhicule
            </h3>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('driver.vehicle.update') }}">
                @csrf
                @method('PUT')

                {{-- Type de véhicule --}}
                <div class="mb-5">
                    <label class="text-sm font-medium text-slate-700 flex items-center gap-1 mb-1.5">
                        <i data-lucide="truck" class="w-4 h-4 text-slate-400"></i> Type de véhicule *
                    </label>
                    <select name="type" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                        <option value="">Sélectionnez</option>
                        <option value="Camionnette" {{ old('type', $vehicule->type ?? '') == 'Camionnette' ? 'selected' : '' }}>Camionnette</option>
                        <option value="Camion" {{ old('type', $vehicule->type ?? '') == 'Camion' ? 'selected' : '' }}>Camion</option>
                        <option value="Fourgon" {{ old('type', $vehicule->type ?? '') == 'Fourgon' ? 'selected' : '' }}>Fourgon</option>
                        <option value="Remorque" {{ old('type', $vehicule->type ?? '') == 'Remorque' ? 'selected' : '' }}>Remorque</option>
                        <option value="Motoculteur" {{ old('type', $vehicule->type ?? '') == 'Motoculteur' ? 'selected' : '' }}>Motoculteur</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Immatriculation --}}
                <div class="mb-5">
                    <label class="text-sm font-medium text-slate-700 flex items-center gap-1 mb-1.5">
                        <i data-lucide="key" class="w-4 h-4 text-slate-400"></i> Immatriculation *
                    </label>
                    <input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation ?? '') }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 transition"
                           placeholder="12345-A-67">
                    @error('immatriculation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Capacité de charge (kg) --}}
                <div class="mb-5">
                    <label class="text-sm font-medium text-slate-700 flex items-center gap-1 mb-1.5">
                        <i data-lucide="weight" class="w-4 h-4 text-slate-400"></i> Capacité de charge (kg) *
                    </label>
                    <input type="number" name="capacite_charge_kg" value="{{ old('capacite_charge_kg', $vehicule->capacite_charge_kg ?? '') }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 transition"
                           placeholder="1500" step="50" min="0">
                    @error('capacite_charge_kg')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Capacité volume (m³) --}}
                <div class="mb-5">
                    <label class="text-sm font-medium text-slate-700 flex items-center gap-1 mb-1.5">
                        <i data-lucide="box" class="w-4 h-4 text-slate-400"></i> Capacité de volume (m³) *
                    </label>
                    <input type="number" name="capacite_volume_m3" value="{{ old('capacite_volume_m3', $vehicule->capacite_volume_m3 ?? '') }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 transition"
                           placeholder="12" step="1" min="0">
                    @error('capacite_volume_m3')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Boutons --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-4 mt-2 border-t border-slate-100">
                    <a href="{{ route('driver.dashboard') }}"
                       class="flex-1 text-center py-3 border border-slate-200 rounded-xl font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold shadow-md transition-all flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .shadow-soft { box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02); }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush