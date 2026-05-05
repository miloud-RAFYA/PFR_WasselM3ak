@extends('layouts.dashboard')

@section('title', 'Messages')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'messages'])
@endsection

@section('content')
<div class="space-y-8">

    {{-- En-tête --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 px-6 py-8 shadow-soft">
        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-primary-500/10 blur-3xl"></div>
        <div class="relative flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-primary-500/10 px-3 py-1 text-xs font-medium text-primary-400">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    Messagerie client
                </div>
                <h1 class="mt-3 text-2xl font-bold text-white">Vos échanges en temps réel</h1>
                <p class="mt-1 text-slate-300 text-sm">Centralisez vos communications avec les transporteurs</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-2xl font-bold text-white">{{ $conversations->count() }}</p>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Conversations</p>
                </div>
                <div class="h-10 w-px bg-slate-700"></div>
                <div class="rounded-xl bg-white/5 p-2.5 backdrop-blur-sm border border-white/10">
                    <i data-lucide="messages-square" class="h-5 w-5 text-primary-400"></i>
                </div>
            </div>
        </div>
    </div>

    @if($conversations->count())
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($conversations as $conversation)
                @php
                    $demande = $conversation->demande;
                    $chauffeur = $conversation->chauffeur;
                    $lastMessage = $conversation->last_message ?? $conversation->messages->last()?->content;
                @endphp
                <div class="group relative bg-white rounded-2xl shadow-soft border border-slate-200 hover:shadow-primary transition-all duration-300 hover:-translate-y-1 overflow-hidden">

                    {{-- Bouton supprimer --}}
                    <form action="{{ route('client.messages.destroy', $conversation) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette conversation ? Cette action est irréversible.')"
                          class="absolute top-4 right-4 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-500 transition-all hover:bg-red-500 hover:text-white shadow-sm">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                        </button>
                    </form>

                    <a href="{{ route('client.messages.show', $conversation) }}" class="block p-5">
                        <div class="flex items-start gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition-colors group-hover:bg-primary-50 group-hover:text-primary-600">
                                <i data-lucide="user" class="h-6 w-6"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                        Réf: {{ $demande->reference ?? '—' }}
                                    </p>
                                    <span class="text-xs text-slate-400">{{ $conversation->updated_at->diffForHumans() }}</span>
                                </div>
                                <h2 class="mt-1 text-lg font-bold text-slate-900 group-hover:text-primary-600 transition-colors truncate">
                                    {{ $demande->ville_depart }}
                                    <i data-lucide="arrow-right" class="inline w-4 h-4 mx-0.5 text-slate-300"></i>
                                    {{ $demande->ville_arrive }}
                                </h2>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    <p class="text-sm font-medium text-slate-600">
                                        {{ $chauffeur->user->prenom ?? 'Chauffeur' }} {{ $chauffeur->user->nom ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Prévisualisation du dernier message --}}
                        <div class="mt-4 relative rounded-xl bg-slate-50 p-3 transition-colors group-hover:bg-slate-100">
                            <div class="absolute -left-1 top-3 h-6 w-1 rounded-full bg-primary-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Dernier message</p>
                            <p class="text-sm text-slate-600 line-clamp-2 italic">
                                "{{ $lastMessage ?? 'Aucun message pour le moment.' }}"
                            </p>
                        </div>
                    </a>

                    <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50 px-5 py-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center gap-1 text-xs text-slate-500">
                                <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                                {{ $conversation->created_at->format('d/m/Y') }}
                            </span>
                            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                            <span class="flex items-center gap-1 text-xs font-semibold text-primary-600">
                                <i data-lucide="message-circle" class="h-3.5 w-3.5"></i>
                                {{ $conversation->messages->count() }} message(s)
                            </span>
                        </div>
                        <div class="text-primary-500 opacity-0 transition-all translate-x-1 group-hover:opacity-100 group-hover:translate-x-0">
                            <i data-lucide="chevron-right" class="h-5 w-5"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination si nécessaire --}}
        @if(method_exists($conversations, 'links'))
            <div class="mt-6">
                {{ $conversations->links('pagination::tailwind') }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-5">
                <i data-lucide="message-square-off" class="w-10 h-10 text-slate-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">Aucune conversation</h3>
            <p class="text-slate-500 max-w-md mx-auto">
                Vos échanges avec les chauffeurs apparaîtront ici dès qu’ils vous contacteront.
            </p>
        </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .shadow-soft {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
    }
    .shadow-primary:hover {
        box-shadow: 0 20px 30px -12px rgba(2,124,177,0.2);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush