@extends('layouts.dashboard')

@section('title', 'Demandes en cours')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('page-title', 'Demandes en cours')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Demandes en cours</h1>
            <p class="text-slate-500 mt-1">Suivez les demandes actuellement en cours de livraison.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('client.requests') }}" class="px-4 py-2 rounded-full border bg-white text-slate-600 border-slate-200 hover:bg-slate-50">Toutes</a>
            <a href="{{ route('client.requests.delivered') }}" class="px-4 py-2 rounded-full border bg-white text-slate-600 border-slate-200 hover:bg-slate-50">Terminées</a>
        </div>
    </div>

    @include('client.requests.partials.list', [
        'demandes' => $demandes,
        'emptyTitle' => 'Aucune demande en cours',
        'emptyText' => 'Vous n’avez actuellement aucune demande en cours de livraison.'
    ])
</div>
@endsection
