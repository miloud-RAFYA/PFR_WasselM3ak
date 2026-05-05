@extends('layouts.dashboard')

@section('title', 'Messages')

@section('sidebar')
    @include('driver.partials.sidebar', ['active' => 'messages'])
@endsection

@section('page-title', 'Mes Messages')

@section('content')
    <div class="space-y-6">
        <div
            class="rounded-3xl border border-slate-200 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-800 px-6 py-8 text-white shadow-lg">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Messagerie chauffeur</p>
                    <h1 class="mt-3 text-4xl font-semibold tracking-tight">Vos conversations avec les expéditeurs</h1>
                    <p class="mt-4 text-sm text-slate-300">Accédez rapidement aux échanges importants et retrouvez vos
                        conversations dans un tableau clair.</p>
                </div>
                <div
                    class="inline-flex items-center gap-3 rounded-full bg-white/10 px-5 py-3 text-sm font-semibold text-slate-200">
                    <span>{{ $conversations->count() }} conversation{{ $conversations->count() > 1 ? 's' : '' }}</span>
                </div>
            </div>
        </div>
       
        @if (auth()->user()->chauffeur && auth()->user()->chauffeur->commentaire_admin)
            <div class="rounded-3xl border-l-8 border-amber-500 bg-amber-50 p-6 shadow-sm flex gap-4 items-start">
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 shadow-sm">
                    <i data-lucide="shield-alert" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-amber-600 font-bold">Instruction de
                            l'administration</p>
                        <span class="text-[10px] text-slate-400 font-medium">Réception :
                            {{ auth()->user()->chauffeur->updated_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="mt-1 text-lg font-bold text-slate-900">Remarque sur votre compte</h3>

                    <div class="mt-3 relative">
                        <div class="absolute -left-2 top-0 bottom-0 w-1 bg-amber-200 rounded-full"></div>
                        <p class="text-sm leading-relaxed text-slate-700 pl-4 italic">
                            "{{ auth()->user()->chauffeur->commentaire_admin }}"
                        </p>
                    </div>

                    <div
                        class="mt-4 flex items-center gap-2 text-[11px] text-amber-700 bg-amber-200/30 w-fit px-3 py-1 rounded-full">
                        <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                        <span>Veuillez appliquer ces consignes pour vos prochaines livraisons.</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Rechercher</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Rechercher une conversation</h2>
                </div>
                <div class="w-full lg:w-96">
                    <label for="search" class="sr-only">Recherche</label>
                    <div class="relative">
                        <input id="search" type="search" placeholder="Ville, référence, expéditeur"
                            class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" />
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($conversations->count())
            <div class="grid gap-5 xl:grid-cols-2">
                @foreach ($conversations as $conversation)
                    <a href="{{ route('driver.messages.show', $conversation) }}"
                        class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="px-6 py-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-3xl bg-white text-primary-600 shadow-sm">
                                    <i data-lucide="message-circle" class="w-6 h-6"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs uppercase tracking-[0.28em] text-slate-500">Demande
                                        {{ $conversation->demande->reference ?? '—' }}</p>
                                    <h2 class="mt-2 text-lg font-semibold text-slate-900 truncate">
                                        {{ $conversation->demande->ville_depart }} →
                                        {{ $conversation->demande->ville_arrive }}</h2>
                                    <p class="mt-2 text-sm text-slate-600">Expéditeur :
                                        {{ $conversation->expediteur->user->prenom ?? '' }}
                                        {{ $conversation->expediteur->user->nom ?? '' }}</p>
                                </div>
                            </div>

                            <div class="mt-5 rounded-3xl bg-white p-4 text-sm text-slate-600 shadow-sm">
                                <p class="font-semibold text-slate-900">Dernier message</p>
                                <p class="mt-2 leading-6">
                                    {{ $conversation->last_message ?? 'Aucun message pour le moment.' }}</p>
                            </div>
                        </div>
                        <div class="border-t border-slate-200 bg-white px-6 py-4">
                            <div
                                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-xs text-slate-500">
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1"> <i
                                        data-lucide="clock" class="w-3.5 h-3.5"></i>
                                    {{ $conversation->updated_at->diffForHumans() }}</span>
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-primary-100 px-3 py-1 text-primary-700">{{ $conversation->messages->count() }}
                                    message{{ $conversation->messages->count() > 1 ? 's' : '' }}</span>
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
                <h3 class="text-2xl font-semibold text-slate-900 mb-2">Aucune conversation encore</h3>
                <p class="mx-auto max-w-2xl text-sm text-slate-500">Les conversations s’afficheront ici dès qu’un expéditeur
                    prendra contact avec vous. Le design est pensé pour rester clair et efficace.</p>
            </div>
        @endif
    </div>
@endsection
