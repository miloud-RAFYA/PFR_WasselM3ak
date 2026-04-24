@extends('layouts.dashboard')

@section('title', 'Messages')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'messages'])
@endsection

@section('page-title', 'Mes Messages')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-800 px-6 py-8 text-white shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Messagerie client</p>
                <h1 class="mt-3 text-4xl font-semibold tracking-tight">Vos conversations sont maintenant plus simples à gérer</h1>
                <p class="mt-4 text-sm text-slate-300">Suivez chaque échange avec votre transporteur dans un espace clair et responsive, inspiré des meilleures interfaces de chat.</p>
            </div>
            <div class="inline-flex items-center rounded-full bg-white/10 px-5 py-3 text-sm font-semibold text-slate-200">
                {{ $conversations->count() ?? 0 }} conversation{{ isset($conversations) && $conversations->count() > 1 ? 's' : '' }}
            </div>
        </div>
    </div>

    @if(isset($conversations) && $conversations->count())
    <div class="grid gap-5 xl:grid-cols-2">
        @foreach($conversations as $conversation)
        <a href="{{ route('client.messages.show', $conversation) }}" class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="px-6 py-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-slate-100 text-slate-700">
                        <i data-lucide="message-circle" class="w-6 h-6"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Demande {{ $conversation->demande->reference ?? '—' }}</p>
                        <h2 class="mt-2 text-lg font-semibold text-slate-900 truncate">{{ $conversation->demande->ville_depart }} → {{ $conversation->demande->ville_arrive }}</h2>
                        <p class="mt-2 text-sm text-slate-500">Transporteur : {{ $conversation->chauffeur->user->prenom ?? '' }} {{ $conversation->chauffeur->user->nom ?? '' }}</p>
                    </div>
                </div>

                <div class="mt-5 rounded-3xl bg-slate-50 p-4 text-sm text-slate-600">
                    <p class="font-semibold text-slate-900">Dernier message</p>
                    <p class="mt-2 leading-6">{{ $conversation->last_message ?? 'Aucun message pour le moment.' }}</p>
                </div>
            </div>
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-xs text-slate-500">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1"> <i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $conversation->updated_at->diffForHumans() }}</span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-primary-100 px-3 py-1 text-primary-700">{{ $conversation->messages->count() }} message{{ $conversation->messages->count() > 1 ? 's' : '' }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-12 text-center shadow-sm">
        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-white shadow-sm mx-auto mb-5">
            <i data-lucide="message-square" class="w-8 h-8 text-slate-400"></i>
        </div>
        <h3 class="text-2xl font-semibold text-slate-900 mb-2">Aucune conversation pour le moment</h3>
        <p class="mx-auto max-w-2xl text-sm text-slate-500">Les messages s’afficheront ici dès qu’un transporteur prendra contact avec vous. Le design reste propre et facile à lire sur mobile.</p>
    </div>
    @endif
</div>
@endsection
