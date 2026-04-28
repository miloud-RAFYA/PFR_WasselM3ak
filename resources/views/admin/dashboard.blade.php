@extends('layouts.dashboard')

@section('title', 'Tableau de bord Administrateur')

@section('sidebar')
@include('admin.partials.sidebar', ['active' => 'dashboard'])
@endsection

@section('page-title', "Vue d'ensemble")

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $statsCards = [
                [
                    'label' => 'Utilisateurs totaux',
                    'value' => number_format($stats['total_users']),
                    'icon' => 'users',
                    'color' => 'blue',
                    'sub' => $stats['total_chauffeurs'] . ' transporteurs / ' . $stats['total_expediteurs'] . ' clients'
                ],
                [
                    'label' => 'Demandes',
                    'value' => number_format($stats['total_demandes']),
                    'icon' => 'package',
                    'color' => 'primary',
                    'sub' => $stats['demandes_en_cours'] . ' en cours / ' . $stats['demandes_terminees'] . ' terminées'
                ],
                [
                    'label' => 'Offres',
                    'value' => number_format($stats['total_offres']),
                    'icon' => 'file-text',
                    'color' => 'purple',
                    'sub' => 'Total des offres'
                ],
                [
                    'label' => 'Revenus',
                    'value' => number_format($stats['revenus_totaux'], 0, ',', ' ') . ' DH',
                    'icon' => 'dollar-sign',
                    'color' => 'green',
                    'sub' => number_format($stats['revenus_mois'], 0, ',', ' ') . ' DH ce mois'
                ],
            ];
        @endphp

        @foreach($statsCards as $stat)
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-{{ $stat['color'] }}-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6 text-{{ $stat['color'] }}-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                        <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-3">{{ $stat['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- Chart & User Distribution -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Monthly Registrations Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-slate-900">Inscriptions mensuelles</h3>
                <span class="text-sm text-slate-500">12 derniers mois</span>
            </div>
            <div class="relative h-64">
                <canvas id="registrationsChart"></canvas>
            </div>
        </div>

        <!-- User Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-slate-900 mb-6">Répartition utilisateurs</h3>
            
            <div class="space-y-6">
                <!-- Clients -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-slate-600">Clients</span>
                        </div>
                        <span class="text-sm font-medium text-slate-900">{{ $stats['clients_percent'] }}%</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full transition-all duration-500" 
                             style="width: {{ $stats['clients_percent'] }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">{{ number_format($usersByRole['expediteur'] ?? 0) }} utilisateurs</p>
                </div>

                <!-- Transporteurs -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-slate-600">Transporteurs</span>
                        </div>
                        <span class="text-sm font-medium text-slate-900">{{ $stats['drivers_percent'] }}%</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full transition-all duration-500" 
                             style="width: {{ $stats['drivers_percent'] }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">{{ number_format($usersByRole['chauffeur'] ?? 0) }} utilisateurs</p>
                </div>
            </div>

            <!-- Total -->
            <div class="mt-6 pt-6 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Total utilisateurs</span>
                    <span class="text-lg font-bold text-slate-900">{{ number_format($stats['total_users']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Derniers utilisateurs</h3>
                <a href="{{ route('admin.users') }}" class="text-sm text-orange-500 hover:text-orange-600 font-medium">Voir tout</a>
            </div>
            <div class="p-6">
                @if($recentUsers->isEmpty())
                    <p class="text-slate-500 text-center py-4">Aucun utilisateur</p>
                @else
                    <div class="space-y-3">
                        @foreach($recentUsers as $user)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium 
                                    {{ $user->role?->type === 'chauffeur' ? 'bg-blue-500' : 'bg-green-500' }}">
                                    {{ strtoupper(substr($user->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $user->nom }} {{ $user->prenom ?? '' }}</p>
                                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $user->est_verifie ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $user->est_verifie ? 'Vérifié' : 'En attente' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Dernières demandes</h3>
                <a href="{{ route('admin.statistics') }}" class="text-sm text-orange-500 hover:text-orange-600 font-medium">Voir tout</a>
            </div>
            <div class="p-6">
                @if($recentDemandes->isEmpty())
                    <p class="text-slate-500 text-center py-4">Aucune demande</p>
                @else
                    <div class="space-y-3">
                        @foreach($recentDemandes as $demande)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                            <div>
                                <p class="font-medium text-slate-900">{{ $demande->lieu_enlevement }} → {{ $demande->lieu_livraison }}</p>
                                <p class="text-sm text-slate-500">{{ $demande->expediteur?->user?->nom ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($demande->prix_estime)
                                <p class="font-medium text-orange-600">{{ number_format($demande->prix_estime) }} DH</p>
                                @endif
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $demande->status === 'delivered' ? 'bg-green-100 text-green-700' : 
                                       ($demande->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ match($demande->status) {
                                        'delivered' => 'Terminée',
                                        'in_progress' => 'En cours',
                                        'pending' => 'En attente',
                                        default => $demande->status
                                    } }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Chart.js - Monthly Registrations
        const chartData = @json($chartDataJson);
        
        const ctx = document.getElementById('registrationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Inscriptions',
                    data: chartData.data,
                    backgroundColor: 'rgba(249, 115, 22, 0.8)',
                    borderColor: 'rgb(249, 115, 22)',
                    borderWidth: 1,
                    borderRadius: 6,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgb(30, 41, 59)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' inscriptions';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgb(148, 163, 184)',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgb(241, 245, 249)'
                        },
                        ticks: {
                            color: 'rgb(148, 163, 184)',
                            font: {
                                size: 11
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
