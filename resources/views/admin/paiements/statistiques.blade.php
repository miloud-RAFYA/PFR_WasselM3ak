@extends('layouts.dashboard')

@section('title', 'Statistiques des paiements')
@section('sidebar')
@include('admin.partials.sidebar', ['active' => 'statistiques'])
@endsection
@section('content')
<div class="space-y-8">

    {{-- En-tête --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Statistiques des paiements</h1>
            <p class="text-slate-500 mt-1">Analysez les transactions et les commissions perçues</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-slate-600">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Exporter PDF
            </button>
            <form method="GET" class="flex items-center gap-2">
                <select name="year" onchange="this.form.submit()" 
                        class="px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                    @foreach(range(date('Y'), 2023) as $year)
                        <option value="{{ $year }}" {{ ($selectedYear ?? date('Y')) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    {{-- Cartes KPI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Montant total versé</p>
                    <p class="text-2xl font-bold text-primary-600 mt-1">{{ number_format($totalVerse, 0, ',', ' ') }} DH</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                    <i data-lucide="credit-card" class="w-6 h-6 text-primary-600"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-slate-400">
                {{ $nbTransactions }} transaction(s)
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Commission totale</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($totalCommission, 0, ',', ' ') }} DH</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                    <i data-lucide="percent" class="w-6 h-6 text-amber-600"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-slate-400">
                Taux moyen: {{ round(($totalCommission / max($totalVerse,1)) * 100, 2) }}%
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Paiements confirmés</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $nbConfirmed }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-slate-400">
                En attente: {{ $nbEnAttente }}
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Gain net plateforme</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalCommission, 0, ',', ' ') }} DH</p>
                </div>
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6 text-slate-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Évolution mensuelle --}}
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
            <h3 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="line-chart" class="w-5 h-5 text-primary-500"></i>
                Évolution mensuelle ({{ $selectedYear ?? date('Y') }})
            </h3>
            <canvas id="monthlyChart" height="200" class="w-full"></canvas>
        </div>

        {{-- Répartition par mode de paiement --}}
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
            <h3 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-primary-500"></i>
                Répartition par mode de paiement
            </h3>
            <canvas id="paymentModeChart" height="200" class="w-full"></canvas>
            <div class="mt-4 space-y-2" id="paymentModeLegend"></div>
        </div>
    </div>

    {{-- Top chauffeurs --}}
    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                Top 10 chauffeurs (commission générée)
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">#</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Chauffeur</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Livraisons</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Montant total</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Commission</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Net perçu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($topChauffeurs as $index => $chauffeur)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-4 text-sm font-medium">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-xs font-bold">
                                    {{ strtoupper(substr($chauffeur->chauffeur_nom, 0, 1)) }}
                                </div>
                                <span class="font-medium">{{ $chauffeur->chauffeur_nom }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm">{{ $chauffeur->nb_livraisons ?? 0 }}</td>
                        <td class="py-3 px-4 text-sm font-semibold">{{ number_format($chauffeur->total_montant ?? 0, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 text-sm font-semibold text-amber-600">{{ number_format($chauffeur->total_commission, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 text-sm font-semibold text-emerald-600">{{ number_format(($chauffeur->total_montant ?? 0) - $chauffeur->total_commission, 0, ',', ' ') }} DH</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-500">Aucune donnée disponible</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Dernières transactions --}}
    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-primary-500"></i>
                Dernières transactions
            </h3>
            {{-- {{ route('admin.paiements.index') }} --}}
            <a href="" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Réf. demande</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Client</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Chauffeur</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Montant</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Commission</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Mode</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Statut</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentPayments as $paiement)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-4 font-mono text-sm">{{ $paiement->demande->reference ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm">{{ $paiement->demande->expediteur->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm">{{ $paiement->demande->chauffeur->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 font-semibold">{{ number_format($paiement->montant_total, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 text-amber-600 font-medium">{{ number_format($paiement->commission, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 capitalize">{{ str_replace('_', ' ', $paiement->mode_paiement) }}</td>
                        <td class="py-3 px-4">
                            @if($paiement->status == 'confirmed')
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Confirmé
                                </span>
                            @elseif($paiement->status == 'paid')
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                    <i data-lucide="clock" class="w-3 h-3"></i> Payé
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> En attente
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm">{{ $paiement->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-slate-500">Aucune transaction trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .shadow-soft {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // Graphique mensuel
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Montant total (DH)',
                    data: @json($monthlyData),
                    borderColor: '#027cb1',
                    backgroundColor: 'rgba(2,124,177,0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#027cb1',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }, {
                    label: 'Commission (DH)',
                    data: @json($monthlyCommissionData),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#f59e0b',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${ctx.raw.toLocaleString()} DH` } },
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: (val) => val.toLocaleString() + ' DH' } }
                }
            }
        });

        // Graphique par mode de paiement
        const modeCtx = document.getElementById('paymentModeChart').getContext('2d');
        const modeData = @json($paymentModeData);
        new Chart(modeCtx, {
            type: 'doughnut',
            data: {
                labels: modeData.map(m => m.mode_paiement),
                datasets: [{
                    data: modeData.map(m => m.total),
                    backgroundColor: ['#027cb1', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw.toLocaleString()} DH` } }
                }
            }
        });
    });
</script>
@endpush