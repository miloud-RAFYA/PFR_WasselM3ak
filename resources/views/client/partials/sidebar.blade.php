<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white border-r border-slate-200 flex flex-col h-screen sticky top-0 transition-all duration-300 shadow-sm"
>

    @php
        $isDashboard = request()->routeIs('client.dashboard');
        $isRequests = request()->routeIs('client.index');
        $isAcceptedOffers = request()->routeIs('client.accepted_offers');
        $isGps = request()->routeIs('client.requests.suivi_gps');
        $isCreate = request()->routeIs('client.create');
        $isMessages = request()->routeIs('client.messages*');
        $isProfile = request()->routeIs('profile');
    @endphp

    {{-- Logo --}}
    <div class="p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center shadow-md">
            <i data-lucide="truck" class="w-5 h-5 text-white"></i>
        </div>
        <span x-show="sidebarOpen" class="text-lg font-bold">
            <span class="text-primary-500">Wassel</span>
            <span class="text-slate-800">M3ak</span>
        </span>
    </div>

    <div class="border-t border-slate-100"></div>

    <nav class="flex-1 p-4 space-y-6">

        {{-- MENU --}}
        <div>
            <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">
                Menu
            </p>
            <div class="space-y-1">

                {{-- Dashboard --}}
                <a href="{{ route('client.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isDashboard ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                </a>

                {{-- Mes demandes --}}
                <a href="{{ route('client.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isRequests ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Mes demandes</span>
                </a>

                {{-- Offres acceptées --}}
                <a href="{{ route('client.accepted_offers') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isAcceptedOffers ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="handshake" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Offres acceptées</span>
                </a>

                {{-- Suivi GPS --}}
                <a href="{{ route('client.requests.suivi_gps') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isGps ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Suivi GPS</span>
                </a>

                {{-- Nouvelle demande (bouton spécial) --}}
                <a href="{{ route('client.create') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isCreate ? 'bg-primary-500 text-white shadow-md' : 'bg-primary-50 text-primary-600 hover:bg-primary-100' }}">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Nouvelle demande</span>
                </a>
            </div>
        </div>

        {{-- COMMUNICATION --}}
        <div>
            <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">
                Communication
            </p>
            <div class="space-y-1">
                <a href="{{ route('client.messages') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isMessages ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Messages</span>
                </a>
            </div>
        </div>

        {{-- COMPTE --}}
        <div>
            <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">
                Compte
            </p>
            <div class="space-y-1">
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isProfile ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Mon profil</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Bas de sidebar --}}
    <div class="p-4 border-t border-slate-100 space-y-2">
        <a href="{{ route('home') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-50">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span x-show="sidebarOpen">Accueil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-red-500 hover:bg-red-50">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span x-show="sidebarOpen">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>