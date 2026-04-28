@extends('layouts.dashboard')

@section('title', 'Statistiques')

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'statistics'])
@endsection

@section('page-title', 'Statistiques')

@section('content')
<div class="space-y-8">

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Utilisateurs</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($clientsCount + $driversCount) }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Demandes (Ce mois)</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($newDemandes) }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Revenus (Ce mois)</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalRevenue, 0, '.', ' ') }} DH</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Satisfaction</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $averageRating }}/5</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-semibold text-slate-900">Évolution des inscriptions</h3>
                <span class="text-xs text-slate-400">{{ now()->year }}</span>
            </div>

            <div class="p-6">
                <div class="h-64 flex items-end gap-3">
                    @php 
                        $maxInscriptions = max($monthlyData) > 0 ? max($monthlyData) : 1; 
                    @endphp
                    @foreach($monthlyData as $count)
                        <div class="flex-1 group relative">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-slate-800 text-white text-[10px] px-2 py-1 rounded z-10">
                                {{ $count }}
                            </div>
                            <div class="bg-blue-400/70 group-hover:bg-blue-600 transition-all rounded-t-md"
                                 style="height: {{ ($count / $maxInscriptions) * 100 }}%;"></div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between text-xs text-slate-400 mt-3">
                    <span>Jan</span><span>Fév</span><span>Mar</span><span>Avr</span>
                    <span>Mai</span><span>Juin</span><span>Juil</span><span>Août</span>
                    <span>Sep</span><span>Oct</span><span>Nov</span><span>Déc</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-semibold text-slate-900 mb-6">Répartition utilisateurs</h3>

            <div class="space-y-2 mb-5">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Expéditeurs</span>
                    <span class="font-medium">{{ $clientsPercent }}%</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width:{{ $clientsPercent }}%"></div>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Chauffeurs</span>
                    <span class="font-medium">{{ $driversPercent }}%</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width:{{ $driversPercent }}%"></div>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-slate-50 text-center text-xs text-slate-400">
                Total : {{ $clientsCount }} Clients | {{ $driversCount }} Chauffeurs
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-semibold text-slate-900 mb-6">Activité de {{ now()->translatedFormat('F') }}</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="p-4 bg-slate-50 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Demandes traitées</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">{{ $completedRides }}</p>
                </div>
                <div class="text-green-600 bg-green-100 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            
            <div class="p-4 bg-slate-50 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Chiffre d'affaires estimé</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">{{ number_format($totalRevenue) }} DH</p>
                </div>
                <div class="text-blue-600 bg-blue-100 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection