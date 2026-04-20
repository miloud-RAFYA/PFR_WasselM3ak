@extends('layouts.dashboard')

@section('title', 'Détail de la demande')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('content')
<div class="space-y-6">
    <!-- Bouton retour -->
    <div class="flex items-center justify-between">
        <a href="{{ route('client.index', request()->except(['from', 'page'])) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Retour à mes demandes
        </a>
        
        <!-- Indicateur de page -->
        @if(request('page'))
        <div class="text-sm text-slate-500">
            Page {{ request('page') }}
        </div>
        @endif
    </div>

    <!-- Le reste du contenu de la page show -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <!-- Contenu de la demande -->
        <h1 class="text-2xl font-bold text-slate-900 mb-4">
            Demande #{{ $demande->reference }}
        </h1>
        
        <!-- Autres détails... -->
    </div>
</div>
@endsection