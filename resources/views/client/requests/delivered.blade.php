@extends('layouts.dashboard')

@section('title', 'Demandes terminées')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('page-title', 'Demandes terminées')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Demandes terminées</h1>
            <p class="text-slate-500 mt-1">Retrouvez vos demandes de transport livrées.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('client.requests') }}" class="px-4 py-2 rounded-full border bg-white text-slate-600 border-slate-200 hover:bg-slate-50">Toutes</a>
            <a href="{{ route('client.requests.in_progress') }}" class="px-4 py-2 rounded-full border bg-white text-slate-600 border-slate-200 hover:bg-slate-50">En cours</a>
        </div>
    </div>

    @include('client.requests.partials.list', [
        'demandes' => $demandes,
        'emptyTitle' => 'Aucune demande terminée',
        'emptyText' => 'Vous n’avez aucune demande terminée pour le moment.'
    ])
</div>
@endsection
