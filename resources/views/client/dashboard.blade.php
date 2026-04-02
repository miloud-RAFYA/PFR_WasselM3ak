@extends('layouts.dashboard')

@section('title', 'Tableau de bord Client')

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
            <a href="{{ route('client.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-primary-500 text-white">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Tableau de bord</span>
            </a>
            {{-- {{ route('client.requests') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Mes demandes</span>
            </a>
            {{-- {{ route('client.requests.create') }} --}}
            <a href="" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="plus-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Nouvelle demande</span>
            </a>
            {{-- {{ route('client.messages') }} --}}
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
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-blue-500"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">3</p>
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
                    <p class="text-2xl font-bold text-slate-900">12</p>
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
                    <p class="text-2xl font-bold text-slate-900">5</p>
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
                    <p class="text-2xl font-bold text-slate-900">4 250 DH</p>
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
                {{-- {{ route('client.requests.create') }} --}}
                <a href="" class="flex items-center gap-3 w-full px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Nouvelle demande de transport
                </a>
                {{-- {{ route('client.requests') }} --}}
                <a href="" class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    Voir mes demandes
                </a>
                {{-- {{ route('client.messages') }} --}}
                <a href="" class="flex items-center gap-3 w-full px-4 py-3 border border-slate-200 rounded-lg hover:border-primary-500 hover:text-primary-500 transition-colors">
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
                    @foreach([1, 2, 3] as $i)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                M{{ $i }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">Transporteur {{ $i }}</p>
                                <p class="text-sm text-slate-500">Camionnette • {{ 100 + $i * 50 }} courses</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center gap-1 text-amber-500">
                                <span class="text-sm font-medium">4.{{ 5 + $i }}</span>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            </div>
                            <p class="text-sm font-medium text-primary-500">{{ 300 + $i * 50 }} DH</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-900">Demandes récentes</h3>
            {{-- {{ route('client.requests') }} --}}
            <a href="" class="text-sm text-primary-500 hover:text-primary-600">Voir tout</a>
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
                    @foreach([
                        ['from' => 'Casablanca', 'to' => 'Rabat', 'type' => 'Meubles', 'date' => '2024-03-15', 'price' => '350 DH', 'status' => 'en_cours'],
                        ['from' => 'Marrakech', 'to' => 'Agadir', 'type' => 'Électroménager', 'date' => '2024-03-10', 'price' => '450 DH', 'status' => 'terminee'],
                        ['from' => 'Tanger', 'to' => 'Tétouan', 'type' => 'Cartons', 'date' => '2024-03-18', 'price' => '200 DH', 'status' => 'en_attente'],
                    ] as $request)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="py-3 px-6">
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-sm">{{ $request['from'] }} → {{ $request['to'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-sm">{{ $request['type'] }}</td>
                        <td class="py-3 px-6 text-sm">{{ $request['date'] }}</td>
                        <td class="py-3 px-6 text-sm font-medium">{{ $request['price'] }}</td>
                        <td class="py-3 px-6">
                            @if($request['status'] === 'terminee')
                                <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Terminée</span>
                            @elseif($request['status'] === 'en_cours')
                                <span class="px-2 py-1 bg-blue-500 text-white text-xs rounded-full">En cours</span>
                            @else
                                <span class="px-2 py-1 border border-primary-500 text-primary-500 text-xs rounded-full">En attente</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
