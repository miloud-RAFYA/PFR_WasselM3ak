@extends('layouts.dashboard')

@section('title', 'Mes gains')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'paiements'])
@endsection

@section('content')
<div class="space-y-6">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Mes gains</h1>
        <p class="text-slate-500 mt-1">Suivez vos revenus et transactions</p>
    </div>

    {{-- Filtres --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex gap-2">
            <button data-period="month" class="period-btn px-4 py-2 rounded-xl text-sm font-medium bg-primary-500 text-white shadow-sm">Ce mois</button>
            <button data-period="year" class="period-btn px-4 py-2 rounded-xl text-sm font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">Cette année</button>
            <button data-period="all" class="period-btn px-4 py-2 rounded-xl text-sm font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">Tout</button>
        </div>
        <div class="relative">
            <input type="text" id="dateRange" placeholder="Choisir une période personnalisée" class="px-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 w-64">
            <i data-lucide="calendar" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
        </div>
    </div>

    {{-- Cartes statistiques --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total gagné (brut)</p>
                    <p class="text-2xl font-bold text-primary-600 mt-1">{{ number_format($stats['total_gagne'], 0, ',', ' ') }} <span class="text-sm font-normal">DH</span></p>
                </div>
                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                    <i data-lucide="wallet" class="w-5 h-5 text-primary-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Commission prélevée</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($stats['commission_prelevee'], 0, ',', ' ') }} <span class="text-sm font-normal">DH</span></p>
                </div>
                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                    <i data-lucide="percent" class="w-5 h-5 text-amber-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Net perçu</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats['net'], 0, ',', ' ') }} <span class="text-sm font-normal">DH</span></p>
                </div>
                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                    <i data-lucide="banknote" class="w-5 h-5 text-emerald-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft border border-slate-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Livraisons payées</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['nombre_livraisons'] }}</p>
                </div>
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                    <i data-lucide="truck" class="w-5 h-5 text-slate-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphique --}}
    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
        <h3 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
            <i data-lucide="trending-up" class="w-5 h-5 text-primary-500"></i>
            Évolution de vos gains
        </h3>
        <canvas id="earningsChart" height="100" class="w-full"></canvas>
    </div>

    {{-- Transactions récentes --}}
    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-primary-500"></i>
                Derniers paiements
            </h3>
            {{-- {{ route('driver.paiements.historique') }} --}}
            <a href="" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-500 uppercase">Référence</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-500 uppercase">Trajet</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-500 uppercase">Montant brut</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-500 uppercase">Commission</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-500 uppercase">Net</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($paiementsRecents ?? [] as $paiement)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-4 font-mono text-sm">{{ $paiement->demande->reference ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm">{{ $paiement->demande->ville_depart ?? '' }} → {{ $paiement->demande->ville_arrive ?? '' }}</td>
                        <td class="py-3 px-4 text-sm font-medium">{{ number_format($paiement->montant_total, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 text-sm text-amber-600">{{ number_format($paiement->commission, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 text-sm font-bold text-emerald-600">{{ number_format($paiement->montant_total - $paiement->commission, 0, ',', ' ') }} DH</td>
                        <td class="py-3 px-4 text-sm text-slate-500">{{ $paiement->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-500">Aucune transaction trouvée</td>
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
    .shadow-soft { box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02); }
    .period-btn.active { background-color: #027cb1; color: white; border-color: #027cb1; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // Correction ici : utilisation de json_encode pour éviter l'erreur de fermeture
        const chartData = @json($chartData ?? array_fill(0, 12, 0));

        const ctx = document.getElementById('earningsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Gains nets (DH)',
                    data: chartData,
                    borderColor: '#027cb1',
                    backgroundColor: 'rgba(2,124,177,0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#027cb1',
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.raw.toLocaleString()} DH` } }
                },
                scales: {
                    y: { ticks: { callback: (val) => val.toLocaleString() + ' DH' }, beginAtZero: true }
                }
            }
        });

        // Gestion des périodes
        const periodBtns = document.querySelectorAll('.period-btn');
        periodBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                periodBtns.forEach(b => b.classList.remove('active', 'bg-primary-500', 'text-white'));
                btn.classList.add('active', 'bg-primary-500', 'text-white');
                // Ici, faire une requête AJAX pour mettre à jour les stats et le graphique
            });
        });
        document.querySelector('.period-btn[data-period="month"]').classList.add('active', 'bg-primary-500', 'text-white');
    });
</script>
@endpush