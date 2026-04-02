@extends('layouts.dashboard')

@section('title', 'Tableau de bord Chauffeur')

@section('availability-toggle')
<div class="flex items-center gap-3 px-4 py-2 bg-slate-100 rounded-lg" x-data="{ isAvailable: true }">
    <div class="w-3 h-3 rounded-full" :class="isAvailable ? 'bg-green-500' : 'bg-red-500'"></div>
    <span class="text-sm font-medium text-slate-700" x-text="isAvailable ? 'Disponible' : 'Indisponible'"></span>
    <button 
        @click="isAvailable = !isAvailable"
        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
        :class="isAvailable ? 'bg-green-500' : 'bg-slate-300'"
    >
        <span 
            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
            :class="isAvailable ? 'translate-x-6' : 'translate-x-1'"
        ></span>
    </button>
</div>
@endsection

@section('sidebar')
<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white shadow-lg transition-all duration-300"
>
    <div class="p-4">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-8">
            <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center flex-shrink-0">
                <i data-lucide="truck" class="w-6 h-6 text-white"></i>
            </div>
            <span x-show="sidebarOpen" class="text-lg font-bold">
                <span class="text-primary-500">Wassel</span>
                <span class="text-slate-800">M3ak</span>
            </span>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="{{ route('driver.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-primary-500 text-white">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Tableau de bord</span>
            </a>
            <a href="{{ route('driver.available') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="clipboard-list" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Demandes disponibles</span>
            </a>
            {{-- {{ route('driver.trips') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="truck" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Mes courses</span>
            </a>
            {{-- {{ route('driver.vehicle') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Mon véhicule</span>
            </a>
            {{-- {{ route('driver.messages') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="message-square" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Messages</span>
            </a>
            {{-- {{ route('profile') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="user" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Profil</span>
            </a>
        </nav>

        <!-- Bottom Actions -->
        <div class="mt-auto pt-8 space-y-2">
            <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="home" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Retour au site</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all">
                    <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>
@endsection

@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">24</p>
                    <p class="text-sm text-slate-500">Courses ce mois</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-blue-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">2</p>
                    <p class="text-sm text-slate-500">En cours</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">8 500 DH</p>
                    <p class="text-sm text-slate-500">Gains ce mois</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="star" class="w-6 h-6 text-amber-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">4.8/5</p>
                    <p class="text-sm text-slate-500">Note moyenne</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Earnings -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Actions rapides</h3>
            </div>
            <div class="p-6 space-y-3">
                {{-- {{ route('driver.available') }} --}}
                <a href="" class="flex items-center gap-3 w-full px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                    Voir les demandes disponibles
                </a>
                {{-- {{ route('driver.trips') }} --}}
                <a href="" class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    Mes courses en cours
                </a>
                {{-- {{ route('driver.vehicle') }} --}}
                <a href="" class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    Gérer mon véhicule
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Évolution des gains</h3>
            </div>
            <div class="p-6">
                <div class="flex items-end gap-2 mb-4">
                    <span class="text-4xl font-bold text-slate-900">8 500 DH</span>
                    <span class="text-green-500 flex items-center text-sm mb-1">
                        <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                        +23%
                    </span>
                </div>
                <p class="text-slate-500 text-sm mb-4">Ce mois-ci</p>
                <div class="h-32 flex items-end gap-2">
                    @foreach([40, 65, 45, 80, 55, 90, 70, 85, 60, 75, 95, 88] as $height)
                    <div class="flex-1 bg-primary-200 rounded-t-sm hover:bg-primary-500 transition-colors" style="height: {{ $height }}%;"></div>
                    @endforeach
                </div>
                <div class="flex justify-between text-xs text-slate-400 mt-2">
                    <span>Jan</span>
                    <span>Déc</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-900">Demandes récentes près de vous</h3>
            {{-- {{ route('driver.available') }} --}}
            <a href="" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @foreach([
                    ['from' => 'Casablanca', 'to' => 'Rabat', 'date' => '2024-03-15', 'price' => '350 DH', 'type' => 'Meubles'],
                    ['from' => 'Marrakech', 'to' => 'Agadir', 'date' => '2024-03-16', 'price' => '450 DH', 'type' => 'Électroménager'],
                    ['from' => 'Tanger', 'to' => 'Tétouan', 'date' => '2024-03-17', 'price' => '200 DH', 'type' => 'Cartons'],
                ] as $request)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 text-primary-500"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">{{ $request['from'] }} → {{ $request['to'] }}</p>
                            <p class="text-sm text-slate-500">{{ $request['type'] }} • {{ $request['date'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="font-medium text-primary-500">{{ $request['price'] }}</p>
                        <button class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition-colors">
                            Accepter
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
