@extends('layouts.dashboard')

@section('title', 'Historique des paiements')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'paiements'])
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Historique des paiements</h1>
            <p class="text-slate-500 mt-1">Toutes vos transactions</p>
        </div>
        <a href="{{ route('client.paiements.index') }}" class="text-primary-500 hover:text-primary-600 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour
        </a>
    </div>

    @if($paiements->count())
        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Réf. demande</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Montant</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Mode</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Statut</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Date</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Facture</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($paiements as $paiement)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-mono text-sm">{{ $paiement->demande->reference }}</td>
                            <td class="py-3 px-4 font-semibold text-primary-600">{{ number_format($paiement->montant_total, 0, ',', ' ') }} DH</td>
                            <td class="py-3 px-4 capitalize">{{ str_replace('_', ' ', $paiement->mode_paiement) }}</td>
                            <td class="py-3 px-4">
                                @if($paiement->status == 'paid')
                                    <span class="px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">Payé</span>
                                @elseif($paiement->status == 'confirmed')
                                    <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">Confirmé</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">En attente</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm">{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4">
                                <a href="#" class="text-primary-500 hover:text-primary-600 text-sm">Télécharger</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $paiements->links() }}</div>
    @else
        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-12 text-center">
            <i data-lucide="receipt" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
            <p class="text-slate-500">Aucun paiement enregistré.</p>
        </div>
    @endif
</div>
@endsection