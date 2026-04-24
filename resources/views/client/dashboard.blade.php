@extends('layouts.dashboard')

@section('title', 'Tableau de bord Client')

@section('sidebar')
<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white border-r border-slate-200 flex flex-col h-screen transition-all duration-300"
>

    <!-- Logo -->
    <div class="p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
            <i data-lucide="truck" class="w-5 h-5 text-white"></i>
        </div>

        <span x-show="sidebarOpen" class="text-lg font-bold">
            <span class="text-primary-500">Wassel</span>
            <span class="text-slate-800">M3ak</span>
        </span>
    </div>

    <!-- Divider -->
    <div class="border-t border-slate-100"></div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-6">

        <!-- MAIN -->
        <div>
            <p x-show="sidebarOpen" class="text-xs text-slate-400 mb-2 uppercase">
                Menu
            </p>

            <div class="space-y-1">

                <!-- Dashboard -->
                <a href="{{ route('client.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                   {{ request()->routeIs('client.dashboard') ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <!-- Demandes -->
                <a href="{{ route('client.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                   {{ request()->routeIs('client.requests*') ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Mes demandes</span>
                </a>

                <a href="{{ route('client.requests.suivi_gps') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                   {{ request()->routeIs('client.requests.suivi_gps') ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Suivi GPS</span>
                </a>

                <!-- Create -->
                <a href="{{ route('client.create') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                   text-slate-600 hover:bg-primary-50 hover:text-primary-500">
                    
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Nouvelle demande</span>
                </a>

            </div>
        </div>

        <!-- COMMUNICATION -->
        <div>
            <p x-show="sidebarOpen" class="text-xs text-slate-400 mb-2 uppercase">
                Communication
            </p>

            <a href="{{ route('client.messages') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('client.messages') ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                
                <i data-lucide="message-square" class="w-5 h-5"></i>
                <span x-show="sidebarOpen">Messages</span>
            </a>
        </div>

        <!-- PROFILE -->
        <div>
            <p x-show="sidebarOpen" class="text-xs text-slate-400 mb-2 uppercase">
                Compte
            </p>

            <a href="{{ route('profile') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               text-slate-600 hover:bg-slate-100">
                
                <i data-lucide="user" class="w-5 h-5"></i>
                <span x-show="sidebarOpen">Profil</span>
            </a>
        </div>

    </nav>

    <!-- Bottom -->
    <div class="p-4 border-t border-slate-100 space-y-2">

        <a href="{{ route('home') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 transition">
            
            <i data-lucide="home" class="w-5 h-5"></i>
            <span x-show="sidebarOpen">Accueil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-500 hover:bg-red-50 transition">
                
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span x-show="sidebarOpen">Déconnexion</span>
            </button>
        </form>

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
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-blue-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{$demandes->count()}}</p>
                    <p class="text-sm text-slate-500">Demandes en cours</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{$stats['demandes_delivered']}}</p>
                    <p class="text-sm text-slate-500">Livraisons effectuées</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="message-square" class="w-6 h-6 text-primary-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['messages_non_lus'] }}</p>
                    <p class="text-sm text-slate-500">Messages non lus</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['economies_realisees'], 0) }} DH</p>
                    <p class="text-sm text-slate-500">Économies réalisées</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Available Drivers -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Actions rapides</h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('client.create') }}" class="flex items-center gap-3 w-full px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Nouvelle demande de transport
                </a>
                <a href="{{ route('client.index') }}" class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    Voir mes demandes
                </a>
                <a href="{{ route('client.messages') }}" class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    Consulter mes messages
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Transporteurs disponibles</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($chauffeursDisponibles as $chauffeur)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ strtoupper(substr($chauffeur->user->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($chauffeur->user->nom ?? '', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ $chauffeur->user->prenom }} {{ $chauffeur->user->nom }}</p>
                                <p class="text-sm text-slate-500">{{ $chauffeur->vehicule->type ?? 'Camionnette' }} • {{ $chauffeur->total_livraisons }} courses</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center gap-1 text-amber-500">
                                <span class="text-sm font-medium">{{ $chauffeur->note_moyenne ?? '4.5' }}</span>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            </div>
                            <p class="text-sm font-medium text-primary-500">{{ rand(250, 500) }} DH</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-500 text-sm py-4">Aucun transporteur disponible</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-900">Demandes récentes</h3>
            <a href="{{ route('client.index') }}" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Trajet</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Type</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Date</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Prix</th>
                        <th class="text-left py-3 px-6 text-sm font-medium text-slate-500">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandesRecentes as $demande)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="py-3 px-6">
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-sm">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-sm">{{ $demande->type_marchendise }}</td>
                        <td class="py-3 px-6 text-sm">{{ $demande->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-6 text-sm font-medium">{{ $demande->prix_final ?? $demande->prix_estime }} DH</td>
                        <td class="py-3 px-6">
                            @if($demande->status === 'delivered')
                                <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Livrée</span>
                            @elseif($demande->status === 'in_progress')
                                <span class="px-2 py-1 bg-blue-500 text-white text-xs rounded-full">En cours</span>
                            @elseif($demande->status === 'pending')
                                <span class="px-2 py-1 border border-primary-500 text-primary-500 text-xs rounded-full">En attente</span>
                            @else
                                <span class="px-2 py-1 border border-slate-300 text-slate-600 text-xs rounded-full">{{ ucfirst(str_replace('_', ' ', $demande->status)) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-slate-500">
                            <p>Aucune demande trouvée</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
