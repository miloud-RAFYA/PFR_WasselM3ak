@extends('layouts.dashboard')

@section('title', 'Mes demandes')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('page-title', 'Mes demandes de transport')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Mes demandes</h1>
            <p class="text-slate-500 mt-1">{{ $demandes->total() }} demande(s) au total</p>
        </div>
        <a href="{{ route('client.create') }}" class="flex items-center gap-2 px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Nouvelle demande
        </a>
    </div>

    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('client.index') }}" class="px-4 py-2 rounded-full border {{ request()->routeIs('client.index') ? 'bg-primary-500 text-white border-primary-500' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Toutes</a>
        <a href="{{ route('client.requests.in_progress') }}" class="px-4 py-2 rounded-full border {{ request()->routeIs('client.requests.in_progress') ? 'bg-primary-500 text-white border-primary-500' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">En cours</a>
        <a href="{{ route('client.requests.delivered') }}" class="px-4 py-2 rounded-full border {{ request()->routeIs('client.requests.delivered') ? 'bg-primary-500 text-white border-primary-500' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Terminées</a>
    </div>

    @include('client.requests.partials.list', ['demandes' => $demandes])
</div>
@endsection
