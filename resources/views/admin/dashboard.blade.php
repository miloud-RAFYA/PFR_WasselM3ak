@extends('layouts.dashboard')

@section('title', 'Tableau de bord Administrateur')

@section('sidebar')
<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-slate-900 shadow-lg transition-all duration-300"
>
    <div class="p-4">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-8">
            <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center flex-shrink-0">
                <i data-lucide="shield" class="w-6 h-6 text-white"></i>
            </div>
            <span x-show="sidebarOpen" class="text-lg font-bold text-white">
                Admin
            </span>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-primary-500 text-white">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Vue d'ensemble</span>
            </a>
            {{-- {{ route('admin.users') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Gestion utilisateurs</span>
            </a>
            {{-- {{ route('admin.requests') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="clipboard-list" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Gestion demandes</span>
            </a>
            {{-- {{ route('admin.statistics') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Statistiques</span>
            </a>
            {{-- {{ route('admin.settings') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Paramètres</span>
            </a>
        </nav>

        <!-- Bottom Actions -->
        <div class="mt-auto pt-8 space-y-2">
            <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="home" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Retour au site</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-900/20 transition-all">
                    <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>
@endsection

@section('page-title', "Vue d'ensemble")

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Utilisateurs totaux', 'value' => '12 450', 'change' => '+12%', 'icon' => 'users', 'color' => 'blue'],
            ['label' => 'Transporteurs', 'value' => '8 320', 'change' => '+8%', 'icon' => 'truck', 'color' => 'green'],
            ['label' => 'Demandes ce mois', 'value' => '3 240', 'change' => '+23%', 'icon' => 'package', 'color' => 'primary'],
            ['label' => 'Revenus (MAD)', 'value' => '485K', 'change' => '+18%', 'icon' => 'dollar-sign', 'color' => 'purple'],
        ] as $stat)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-{{ $stat['color'] }}-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6 text-{{ $stat['color'] }}-500"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                        <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-sm text-green-500">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                    {{ $stat['change'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Activity -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Derniers utilisateurs</h3>
                {{-- {{ route('admin.users') }} --}}
                <a href="" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Ahmed Benali', 'email' => 'ahmed@email.com', 'type' => 'client', 'status' => 'active'],
                        ['name' => 'Mohamed Alami', 'email' => 'mohamed@email.com', 'type' => 'driver', 'status' => 'pending'],
                        ['name' => 'Sofia El Amrani', 'email' => 'sofia@email.com', 'type' => 'client', 'status' => 'active'],
                        ['name' => 'Karim Fassi', 'email' => 'karim@email.com', 'type' => 'driver', 'status' => 'suspended'],
                    ] as $user)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium {{ $user['type'] === 'driver' ? 'bg-blue-500' : 'bg-green-500' }}">
                                {{ substr($user['name'], 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ $user['name'] }}</p>
                                <p class="text-sm text-slate-500">{{ $user['email'] }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $user['status'] === 'active' ? 'bg-green-500 text-white' : ($user['status'] === 'pending' ? 'bg-amber-500 text-white' : 'bg-red-500 text-white') }}">
                            {{ $user['status'] === 'active' ? 'Actif' : ($user['status'] === 'pending' ? 'En attente' : 'Suspendu') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Dernières demandes</h3>
                {{-- {{ route('admin.requests') }} --}}
                <a href="" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach([
                        ['from' => 'Casablanca', 'to' => 'Rabat', 'client' => 'Ahmed Benali', 'status' => 'en_cours', 'price' => '350 DH'],
                        ['from' => 'Marrakech', 'to' => 'Agadir', 'client' => 'Sofia El Amrani', 'status' => 'terminee', 'price' => '450 DH'],
                        ['from' => 'Tanger', 'to' => 'Tétouan', 'client' => 'Karim Idrissi', 'status' => 'en_attente', 'price' => '200 DH'],
                    ] as $request)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div>
                            <p class="font-medium text-slate-900">{{ $request['from'] }} → {{ $request['to'] }}</p>
                            <p class="text-sm text-slate-500">{{ $request['client'] }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-primary-500">{{ $request['price'] }}</p>
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $request['status'] === 'terminee' ? 'bg-green-500 text-white' : ($request['status'] === 'en_cours' ? 'bg-blue-500 text-white' : 'border border-primary-500 text-primary-500') }}">
                                {{ $request['status'] === 'terminee' ? 'Terminée' : ($request['status'] === 'en_cours' ? 'En cours' : 'En attente') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
