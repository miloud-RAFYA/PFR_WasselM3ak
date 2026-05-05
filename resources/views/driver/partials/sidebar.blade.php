<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white border-r border-slate-200 flex flex-col h-screen sticky top-0 transition-all duration-300 shadow-sm">

    @php
        $isDashboard = request()->routeIs('driver.dashboard');
        $isRequests = request()->routeIs('driver.available');
        $isGains = request()->routeIs('driver.paiements.statistiques');
        $isTrips = request()->routeIs('driver.trips');
        $isVehicle = request()->routeIs('driver.vehicle');
        $isMessages = request()->routeIs('driver.messages');
        $isProfile = request()->routeIs('profileChauffeur');
    @endphp

    <!-- Logo -->
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

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-6">

        <!-- MAIN -->
        <div>
            <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Menu</p>
            <div class="space-y-1">

                <!-- Dashboard -->
                <a href="{{ route('driver.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isDashboard ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Tableau de bord</span>
                </a>

                <!-- Demandes disponibles -->
                <a href="{{ route('driver.available') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isRequests ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Demandes disponibles</span>
                </a>

                <!-- Mes gains -->
                <a href="{{ route('driver.paiements.statistiques') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isGains ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Mes gains</span>
                </a>

                <!-- Mes courses -->
                <a href="{{ route('driver.trips') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isTrips ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Mes courses</span>
                </a>

                <!-- Mon véhicule -->
                <a href="{{ route('driver.vehicle') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isVehicle ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="car" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Mon véhicule</span>
                </a>
            </div>
        </div>

        <!-- COMMUNICATION -->
        <div>
            <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Communication</p>
            <div class="space-y-1">
                <a href="{{ route('driver.messages') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isMessages ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Messages</span>
                </a>
            </div>
        </div>

        <!-- COMPTE -->
        <div>
            <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Compte</p>
            <div class="space-y-1">
                <a href="{{ route('profileChauffeur') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ $isProfile ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="font-medium">Mon profil</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Bottom -->
    <div class="p-4 border-t border-slate-100 space-y-2">
        <a href="{{ route('home') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-50">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span x-show="sidebarOpen">Accueil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-red-500 hover:bg-red-50">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span x-show="sidebarOpen">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>