@extends('layouts.dashboard')

@section('title', 'Statistiques')

@section('sidebar')
@include('admin.partials.sidebar', ['active' => 'statistics'])
@endsection

@section('page-title', 'Statistiques')

@section('content')

<div class="space-y-8">

    <!-- KPI CARDS -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Utilisateurs</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">12 450</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Demandes</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">3 240</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Revenus</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">485K DH</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Satisfaction</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">4.8/5</p>
        </div>

    </div>

    <!-- CHART + DISTRIBUTION -->
    <div class="grid lg:grid-cols-3 gap-6">

        <!-- CHART -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-semibold text-slate-900">Évolution des inscriptions</h3>
                <span class="text-xs text-slate-400">2026</span>
            </div>

            <div class="p-6">
                <div class="h-64 flex items-end gap-3">
                    @foreach([30,45,35,55,40,60,50,70,65,80,75,90] as $value)
                        <div class="flex-1 group">
                            <div class="bg-primary-400/70 group-hover:bg-primary-500 transition-all rounded-t-md"
                                style="height: {{ $value * 2 }}px;"></div>
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

        <!-- DISTRIBUTION -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

            <h3 class="font-semibold text-slate-900 mb-6">Répartition utilisateurs</h3>

            <!-- Clients -->
            <div class="space-y-2 mb-5">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Clients</span>
                    <span class="font-medium">33%</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width:33%"></div>
                </div>
            </div>

            <!-- Transporteurs -->
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Transporteurs</span>
                    <span class="font-medium">67%</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width:67%"></div>
                </div>
            </div>

        </div>

    </div>

    <!-- EXTRA STATS -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <h3 class="font-semibold text-slate-900 mb-6">Performance mensuelle</h3>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-sm text-slate-500">Nouvelles demandes</p>
                <p class="text-xl font-bold text-slate-900 mt-1">3 240</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-sm text-slate-500">Livraisons</p>
                <p class="text-xl font-bold text-slate-900 mt-1">2 890</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-sm text-slate-500">Revenus</p>
                <p class="text-xl font-bold text-slate-900 mt-1">485K DH</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-sm text-slate-500">Satisfaction</p>
                <p class="text-xl font-bold text-slate-900 mt-1">4.8/5</p>
            </div>

        </div>

    </div>

</div>

@endsection