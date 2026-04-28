@extends('layouts.dashboard')

@section('title', 'Gestion des Demandes')

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'demandes'])
@endsection

@section('page-title', 'Liste des Demandes - WasselM3ak')

@section('content')
<div class="space-y-6">
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Référence</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Itinéraire</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Marchandise</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Poids (kg)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Prix (Est. / Final)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($demandes as $demande)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-primary-600">
                            {{ $demande->reference }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <span class="font-medium text-slate-700">{{ $demande->ville_depart }}</span>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="font-medium text-slate-700">{{ $demande->ville_arrive }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $demande->type_marchendise }}
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            <span class="bg-slate-100 px-2 py-1 rounded">{{ $demande->poids_kg }} kg</span>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="text-slate-400 line-through text-xs">{{ $demande->prix_estime }} DH</span>
                                <span class="text-slate-900 font-bold">{{ $demande->prix_final ?? '--' }} DH</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusMap = [
                                    'pending'     => ['label' => 'En attente', 'css' => 'bg-amber-100 text-amber-700'],
                                    'in_progress' => ['label' => 'En cours',   'css' => 'bg-blue-100 text-blue-700'],
                                    'delivered'   => ['label' => 'Livré',      'css' => 'bg-green-100 text-green-700'],
                                ];
                                $currentStatus = $statusMap[$demande->status] ?? ['label' => $demande->status, 'css' => 'bg-slate-100'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $currentStatus['css'] }}">
                                {{ $currentStatus['label'] }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button title="Modifier" class="p-2 text-slate-400 hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button title="Supprimer" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-400 italic">
                            Aucune demande de transport enregistrée pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection