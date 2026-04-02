@extends('layouts.dashboard')

@section('title', 'Gestion des utilisateurs')

@section('sidebar')
@include('admin.partials.sidebar', ['active' => 'users'])
@endsection

@section('page-title', 'Gestion des utilisateurs')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="flex items-center justify-between">
        <div class="relative w-96">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input type="text" placeholder="Rechercher un utilisateur..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Exporter</button>
            <button class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">Ajouter</button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="border-b border-slate-200">
            <nav class="flex -mb-px">
                <a href="#" class="px-6 py-4 border-b-2 border-primary-500 text-primary-600 font-medium">Tous</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">Clients</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">Transporteurs</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">En attente</a>
            </nav>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Utilisateur</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Type</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Date d'inscription</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Statut</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['name' => 'Ahmed Benali', 'email' => 'ahmed@email.com', 'type' => 'client', 'status' => 'active', 'date' => '2024-03-15'],
                        ['name' => 'Mohamed Alami', 'email' => 'mohamed@email.com', 'type' => 'driver', 'status' => 'pending', 'date' => '2024-03-14'],
                        ['name' => 'Sofia El Amrani', 'email' => 'sofia@email.com', 'type' => 'client', 'status' => 'active', 'date' => '2024-03-13'],
                        ['name' => 'Karim Fassi', 'email' => 'karim@email.com', 'type' => 'driver', 'status' => 'suspended', 'date' => '2024-03-12'],
                    ] as $user)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="py-3 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium {{ $user['type'] === 'driver' ? 'bg-blue-500' : 'bg-green-500' }}">
                                    {{ substr($user['name'], 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $user['name'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $user['email'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            <span class="px-2 py-1 text-xs rounded-full border {{ $user['type'] === 'driver' ? 'border-blue-500 text-blue-500' : 'border-green-500 text-green-500' }}">
                                {{ $user['type'] === 'driver' ? 'Transporteur' : 'Client' }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-sm">{{ $user['date'] }}</td>
                        <td class="py-3 px-6">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $user['status'] === 'active' ? 'bg-green-500 text-white' : ($user['status'] === 'pending' ? 'bg-amber-500 text-white' : 'bg-red-500 text-white') }}">
                                {{ $user['status'] === 'active' ? 'Actif' : ($user['status'] === 'pending' ? 'En attente' : 'Suspendu') }}
                            </span>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex gap-2">
                                <button class="p-2 hover:bg-slate-100 rounded-lg text-green-500">
                                    <i data-lucide="user-check" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 hover:bg-slate-100 rounded-lg text-red-500">
                                    <i data-lucide="user-x" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 hover:bg-slate-100 rounded-lg text-slate-400">
                                    <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
