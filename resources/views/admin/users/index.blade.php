@extends('layouts.dashboard')

@section('title', 'Gestion des utilisateurs')

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'users'])
@endsection

@section('page-title', 'Gestion des utilisateurs')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">

        {{-- SEARCH --}}
        <form action="{{ route('admin.users') }}" method="GET" class="relative w-full lg:w-96">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Rechercher utilisateur..."
                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary-500 outline-none shadow-sm">
        </form>

        {{-- ACTIONS --}}
        <div class="flex gap-3 w-full lg:w-auto">
            <button class="flex-1 lg:flex-none px-5 py-3 border rounded-xl bg-white hover:bg-slate-50 shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export
            </button>

            <button class="flex-1 lg:flex-none px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-md flex items-center justify-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Ajouter utilisateur
            </button>
        </div>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">

        {{-- TABS --}}
        <div class="border-b bg-slate-50 px-4">
            <nav class="flex gap-2 overflow-x-auto">
                @php
                    $tabs = [
                        ['label' => 'Tous', 'role' => null, 'est_verifie' => null],
                        ['label' => 'Clients', 'role' => 'expediteur', 'est_verifie' => null],
                        ['label' => 'Transporteurs', 'role' => 'chauffeur', 'est_verifie' => null],
                        ['label' => 'En attente', 'role' => null, 'est_verifie' => 0],
                    ];
                @endphp

                @foreach ($tabs as $tab)
                    @php
                        $isActive = request('role') == $tab['role'] && request('est_verifie') == $tab['est_verifie'];
                        $url = route('admin.users', array_merge(request()->except(['page']), [
                            'role' => $tab['role'],
                            'est_verifie' => $tab['est_verifie'],
                        ]));
                    @endphp

                    <a href="{{ $url }}"
                        class="px-5 py-3 text-sm font-semibold whitespace-nowrap rounded-lg transition-all
                        {{ $isActive
                            ? 'bg-white shadow text-primary-600'
                            : 'text-slate-500 hover:bg-white hover:shadow-sm' }}">
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Utilisateur</th>
                        <th class="px-6 py-4 text-left">Rôle</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-left">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- USER --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-primary-500 to-indigo-500 text-white flex items-center justify-center font-bold shadow">
                                    {{ strtoupper(substr($user->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $user->nom }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- ROLE --}}
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                {{ $user->role->type === 'admin'
                                    ? 'bg-purple-100 text-purple-600'
                                    : ($user->role->type === 'chauffeur'
                                        ? 'bg-blue-100 text-blue-600'
                                        : 'bg-indigo-100 text-indigo-600') }}">
                                {{ $user->role->type === 'admin' ? 'Admin' : ($user->role->type === 'chauffeur' ? 'Transporteur' : 'Client') }}
                            </span>
                        </td>

                        {{-- DATE --}}
                        <td class="px-6 py-4 text-slate-500">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                {{ $user->est_actif ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $user->est_actif ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">

                                {{-- @if (!$user->est_verifie)
                                <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="p-2 rounded-lg bg-green-100 hover:bg-green-500 hover:text-white transition" title="Vérifier">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif --}}

                                @if ($user->role->type === 'chauffeur')
                                <a href="{{ route('admin.users.documents', $user) }}" 
                                    class="p-2 rounded-lg bg-blue-100 hover:bg-blue-500 hover:text-white transition" 
                                    title="Voir les documents">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                                @endif
                                <button class="p-2 rounded-lg bg-slate-100 hover:bg-slate-300 transition" title="Modifier">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Confirmer suppression ?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 rounded-lg bg-red-100 hover:bg-red-500 hover:text-white transition" title="Supprimer">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center text-slate-400">
                            Aucun utilisateur trouvé
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($users->hasPages())
        <div class="p-4 border-t bg-slate-50">
            {{ $users->links() }}
        </div>
        @endif

    </div>
</div>

@endsection