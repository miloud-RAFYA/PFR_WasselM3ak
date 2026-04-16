<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white border-r border-slate-200 flex flex-col h-screen sticky top-0 transition-all duration-300">

    @php
        $isDashboard = isset($active) ? $active === 'dashboard' : request()->routeIs('client.dashboard');
        $isRequests = isset($active) ? $active === 'requests' : (
            request()->routeIs('client.requests') ||
            request()->routeIs('client.requests.in_progress') ||
            request()->routeIs('client.requests.delivered') ||
            request()->routeIs('client.requests.show')
        );
        $isSuivi = isset($active) ? $active === 'suivi' : request()->routeIs('client.requests.suivi');
        $isSuiviGps = isset($active) ? $active === 'suivi-gps' : request()->routeIs('client.requests.suivi_gps');
        $isCreateRequest = isset($active) ? $active === 'create-request' : request()->routeIs('client.requests.create');
        $isMessages = isset($active) ? $active === 'messages' : request()->routeIs('client.messages');
        $isProfile = isset($active) ? $active === 'profile' : request()->routeIs('profile');
    @endphp

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
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ $isDashboard ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">

                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <!-- Demandes -->
                <a href="{{ route('client.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ $isRequests ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">

                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Mes demandes</span>
                </a>

                <a href="{{ route('client.requests.suivi') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ $isSuivi ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">

                    <i data-lucide="map" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Suivi</span>
                </a>

                <a href="{{ route('client.requests.suivi_gps') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ $isSuiviGps ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">

                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen">Suivi GPS</span>
                </a>

                <!-- Create -->
                <a href="{{ route('client.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ $isCreateRequest ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-primary-50 hover:text-primary-500' }}">

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
