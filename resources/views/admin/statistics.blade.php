@extends('layouts.dashboard')

@section('title', 'Statistiques')

@section('sidebar')
@include('admin.partials.sidebar', ['active' => 'statistics'])
@endsection

@section('page-title', 'Statistiques')

@section('content')
<div class="space-y-6">
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Registration Chart -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Évolution des inscriptions</h3>
            </div>
            <div class="p-6">
                <div class="h-64 flex items-end gap-2">
                    @foreach([30, 45, 35, 55, 40, 60, 50, 70, 65, 80, 75, 90] as $height)
                    <div class="flex-1 flex flex-col gap-1">
                        <div class="bg-primary-200 rounded-t-sm hover:bg-primary-500 transition-colors" style="height: {{ $height * 2 }}px;"></div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between text-xs text-slate-400 mt-2">
                    <span>Jan</span>
                    <span>Fév</span>
                    <span>Mar</span>
                    <span>Avr</span>
                    <span>Mai</span>
                    <span>Juin</span>
                    <span>Juil</span>
                    <span>Août</span>
                    <span>Sep</span>
                    <span>Oct</span>
                    <span>Nov</span>
                    <span>Déc</span>
                </div>
            </div>
        </div>

        <!-- User Distribution -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Répartition des utilisateurs</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-slate-600">Clients</span>
                            <span class="text-sm font-medium">4 130 (33%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: 33%;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-slate-600">Transporteurs</span>
                            <span class="text-sm font-medium">8 320 (67%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 67%;"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h4 class="font-medium text-slate-900 mb-4">Statistiques mensuelles</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">3 240</p>
                            <p class="text-sm text-slate-500">Nouvelles demandes</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">2 890</p>
                            <p class="text-sm text-slate-500">Courses terminées</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">485K DH</p>
                            <p class="text-sm text-slate-500">Revenus générés</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">4.8/5</p>
                            <p class="text-sm text-slate-500">Satisfaction client</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
