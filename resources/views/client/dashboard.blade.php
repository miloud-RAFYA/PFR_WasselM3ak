@extends('layouts.dashboard')

@section('title', 'Tableau de bord Client')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'dashboard'])
@endsection

@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-8">
    
    <!-- Stats Cards améliorées -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Demandes en cours -->
        <div class="group bg-white rounded-2xl shadow-soft hover:shadow-primary transition-all duration-300 p-6 border border-slate-100 hover:border-primary-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Demandes en cours</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $demandes->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="clock" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                <span class="text-emerald-500">+{{ rand(0, 20) }}%</span> vs mois dernier
            </div>
        </div>

        <!-- Livraisons effectuées -->
        <div class="group bg-white rounded-2xl shadow-soft hover:shadow-primary transition-all duration-300 p-6 border border-slate-100 hover:border-primary-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Livraisons effectuées</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['demandes_delivered'] }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Taux de satisfaction : 98%
            </div>
        </div>

        <!-- Messages non lus -->
        <div class="group bg-white rounded-2xl shadow-soft hover:shadow-primary transition-all duration-300 p-6 border border-slate-100 hover:border-primary-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Messages non lus</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['messages_non_lus'] }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="message-square" class="w-6 h-6 text-amber-600"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                <a href="{{ route('client.messages') }}" class="text-primary-500 hover:underline">Consulter →</a>
            </div>
        </div>

        <!-- Économies réalisées -->
        <div class="group bg-gradient-to-br from-primary-50 to-white rounded-2xl shadow-soft hover:shadow-primary transition-all duration-300 p-6 border border-primary-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Économies réalisées</p>
                    <p class="text-3xl font-bold text-primary-600">{{ number_format($stats['economies_realisees'], 0) }} DH</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-primary-600"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Grâce à WasselM3ak
            </div>
        </div>
    </div>

    <!-- Quick Actions & Available Drivers -->
    <div class="grid lg:grid-cols-2 gap-6">
        
        <!-- Actions rapides -->
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden hover:border-primary-100 transition-all">
            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="zap" class="w-5 h-5 text-primary-500"></i>
                    Actions rapides
                </h3>
                <p class="text-sm text-slate-500 mt-1">Gagnez du temps avec ces raccourcis</p>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('client.create') }}" 
                   class="flex items-center justify-between gap-3 w-full px-5 py-3.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition-all duration-200 shadow-primary hover:shadow-lg group">
                    <span class="flex items-center gap-3 font-medium">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Nouvelle demande de transport
                    </span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="{{ route('client.index') }}" 
                   class="flex items-center justify-between gap-3 w-full px-5 py-3.5 border border-slate-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-all duration-200 group">
                    <span class="flex items-center gap-3 font-medium text-slate-700 group-hover:text-primary-600">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        Voir mes demandes
                    </span>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:text-primary-500 group-hover:translate-x-1 transition-all"></i>
                </a>
                <a href="{{ route('client.messages') }}" 
                   class="flex items-center justify-between gap-3 w-full px-5 py-3.5 border border-slate-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-all duration-200 group">
                    <span class="flex items-center gap-3 font-medium text-slate-700 group-hover:text-primary-600">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        Consulter mes messages
                        @if($stats['messages_non_lus'] > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $stats['messages_non_lus'] }}</span>
                        @endif
                    </span>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:text-primary-500 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>

        <!-- Transporteurs disponibles -->
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden hover:border-primary-100 transition-all">
            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="truck" class="w-5 h-5 text-primary-500"></i>
                            Transporteurs disponibles
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">À proximité de votre zone</p>
                    </div>
                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">{{ $chauffeursDisponibles->count() }} actifs</span>
                </div>
            </div>
            <div class="p-6 max-h-[400px] overflow-y-auto space-y-3">
                @forelse($chauffeursDisponibles as $chauffeur)
                <div class="group flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-white hover:shadow-md transition-all duration-200 border border-transparent hover:border-primary-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center text-white font-semibold shadow-md">
                            {{ strtoupper(substr($chauffeur->user->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($chauffeur->user->nom ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $chauffeur->user->prenom }} {{ $chauffeur->user->nom }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-slate-500">{{ $chauffeur->vehicule->type ?? 'Camionnette' }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                    <i data-lucide="award" class="w-3 h-3"></i>
                                    {{ $chauffeur->total_livraisons ?? 0 }} courses
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center gap-1 text-amber-500">
                            <span class="text-sm font-bold">{{ number_format($chauffeur->note_moyenne ?? 4.5, 1) }}</span>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                        </div>
                        <p class="text-sm font-bold text-primary-600 mt-1">{{ rand(250, 500) }} DH</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i data-lucide="truck" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                    <p class="text-slate-500">Aucun transporteur disponible pour le moment</p>
                    <p class="text-xs text-slate-400 mt-1">Revenez plus tard ou publiez une demande</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Demandes récentes -->
    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gradient-to-r from-slate-50 to-white">
            <div>
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-primary-500"></i>
                    Demandes récentes
                </h3>
                <p class="text-sm text-slate-500 mt-1">Vos 5 dernières demandes</p>
            </div>
            <a href="{{ route('client.index') }}" class="inline-flex items-center gap-1 text-sm text-primary-500 hover:text-primary-600 font-medium transition-colors">
                Voir toutes mes demandes
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Trajet</th>
                        <th class="text-left py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="text-left py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="text-left py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Prix</th>
                        <th class="text-left py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                        <th class="text-right py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($demandesRecentes as $demande)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-sm font-medium text-slate-700">{{ $demande->ville_depart }}</span>
                                <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300"></i>
                                <span class="text-sm text-slate-700">{{ $demande->ville_arrive }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                                <i data-lucide="box" class="w-4 h-4 text-slate-400"></i>
                                {{ $demande->type_marchendise }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600">{{ $demande->created_at->format('d/m/Y') }}</td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-semibold text-slate-900">{{ number_format($demande->prix_final ?? $demande->prix_estime, 0) }} DH</span>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusConfig = [
                                    'delivered' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Livrée', 'icon' => 'check-circle'],
                                    'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'En cours', 'icon' => 'truck'],
                                    'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'En attente', 'icon' => 'clock'],
                                    'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Annulée', 'icon' => 'x-circle'],
                                ];
                                $config = $statusConfig[$demande->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'label' => ucfirst($demande->status), 'icon' => 'circle'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                <i data-lucide="{{ $config['icon'] }}" class="w-3 h-3"></i>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('client.requests.show', $demande) }}" 
                               class="inline-flex items-center gap-1 text-primary-500 hover:text-primary-600 text-sm font-medium transition-colors opacity-0 group-hover:opacity-100">
                                Détails
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="package" class="w-16 h-16 text-slate-200 mb-4"></i>
                                <p class="text-slate-500 font-medium">Aucune demande trouvée</p>
                                <a href="{{ route('client.create') }}" class="mt-3 inline-flex items-center gap-2 text-primary-500 hover:text-primary-600">
                                    Créer votre première demande
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
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
    /* Animations personnalisées */
    .shadow-soft {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
    }
    .shadow-primary {
        box-shadow: 0 12px 24px rgba(2,124,177,0.12);
    }
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    .hover\:shadow-primary:hover {
        box-shadow: 0 20px 30px -12px rgba(2,124,177,0.2);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation supplémentaire pour les cartes stats
        const statCards = document.querySelectorAll('.group');
        statCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush