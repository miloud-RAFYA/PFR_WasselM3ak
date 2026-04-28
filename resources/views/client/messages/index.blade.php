@extends('layouts.dashboard')

@section('title', 'Messages')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'messages'])
@endsection

@section('page-title', 'Mes Messages')

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="relative overflow-hidden rounded-[2rem] bg-slate-900 px-8 py-10 shadow-2xl">
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-primary-500/10 blur-3xl"></div>
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-primary-500/10 px-4 py-1 text-xs font-medium tracking-widest text-primary-400 uppercase">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    Messagerie Client
                </span>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-white">Vos échanges en temps réel</h1>
                <p class="mt-4 text-slate-400 leading-relaxed">Centralisez vos communications avec les transporteurs pour un suivi de livraison sans accroc.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-2xl font-bold text-white">{{ $conversations->count() }}</p>
                    <p class="text-xs uppercase tracking-tighter text-slate-500">Conversations</p>
                </div>
                <div class="h-12 w-[1px] bg-slate-800 mx-2 hidden sm:block"></div>
                <div class="rounded-2xl bg-white/5 p-3 backdrop-blur-md border border-white/10">
                    <i data-lucide="messages-square" class="h-6 w-6 text-primary-500"></i>
                </div>
            </div>
        </div>
    </div>

    @if(isset($conversations) && $conversations->count())
    <div class="grid gap-6 xl:grid-cols-2">
        @foreach($conversations as $conversation)
        <div class="group relative flex flex-col justify-between overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:shadow-xl hover:border-primary-200">
            
            {{-- Bouton Supprimer --}}
            <form action="{{ route('client.messages.destroy', $conversation) }}" method="POST" 
                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette conversation ? Cette action est irréversible.')"
                  class="absolute right-6 top-6 z-10">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-500 transition-all hover:bg-red-500 hover:text-white shadow-sm">
                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                </button>
            </form>

            <a href="{{ route('client.messages.show', $conversation) }}" class="block px-8 py-8">
                <div class="flex items-start gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 transition-colors group-hover:bg-primary-50 group-hover:text-primary-600">
                        <i data-lucide="user" class="h-7 w-7"></i>
                    </div>
                    <div class="min-w-0 pr-12">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Ref: {{ $conversation->demande->reference ?? '—' }}</p>
                        <h2 class="mt-1 text-xl font-bold text-slate-900 group-hover:text-primary-600 transition-colors truncate">
                            {{ $conversation->demande->ville_depart }} 
                            <i data-lucide="move-right" class="inline h-4 w-4 mx-1 text-slate-300"></i> 
                            {{ $conversation->demande->ville_arrive }}
                        </h2>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            <p class="text-sm font-medium text-slate-600">{{ $conversation->chauffeur->user->prenom }} {{ $conversation->chauffeur->user->nom }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 relative rounded-2xl bg-slate-50 p-5 transition-colors group-hover:bg-slate-100/50">
                    <div class="absolute -left-1 top-4 h-8 w-1 rounded-full bg-primary-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-2">Dernier message</p>
                    <p class="text-sm leading-relaxed text-slate-600 line-clamp-2 italic">
                        "{{ $conversation->last_message ?? 'Aucun message pour le moment.' }}"
                    </p>
                </div>
            </a>

            <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-8 py-4">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                        <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                        {{ $conversation->updated_at->diffForHumans() }}
                    </span>
                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                    <span class="flex items-center gap-1.5 text-xs font-bold text-primary-600">
                        <i data-lucide="layers" class="h-3.5 w-3.5"></i>
                        {{ $conversation->messages->count() }} messages
                    </span>
                </div>
                <div class="text-primary-500 opacity-0 transition-all translate-x-2 group-hover:opacity-100 group-hover:translate-x-0">
                    <i data-lucide="chevron-right" class="h-5 w-5"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    {{-- Empty State (Inchangé mais stylisé) --}}
    <div class="flex flex-col items-center justify-center rounded-[3rem] border-2 border-dashed border-slate-200 bg-white p-20 text-center">
        <div class="rounded-3xl bg-slate-50 p-6">
            <i data-lucide="message-square-off" class="h-12 w-12 text-slate-300"></i>
        </div>
        <h3 class="mt-6 text-xl font-bold text-slate-900">Silence radio...</h3>
        <p class="mt-2 max-w-sm text-slate-500">Vos conversations apparaîtront ici dès qu'un transporteur vous contactera pour une offre.</p>
    </div>
    @endif
</div>
@endsection