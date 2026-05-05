<aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0 md:w-20'"
    class="fixed inset-y-0 left-0 z-40 w-64 transform bg-white border-r border-slate-200 flex flex-col h-screen transition-all duration-300 md:static md:translate-x-0 md:w-64 shadow-sm">

    @php
        $isDashboard = request()->routeIs('admin.dashboard');
        $isUsers = request()->routeIs('admin.users');
        $isDriverDocuments = request()->routeIs('admin.driver.documents');
        $isRequests = request()->routeIs('admin.demandes');
        $isPaiementsStats = request()->routeIs('admin.paiements.statistiques');
        $isStatistics = request()->routeIs('admin.statistics');
        $isSettings = request()->routeIs('admin.settings');
    @endphp

    <div class="p-4 flex flex-col h-full">

        <!-- LOGO -->
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                <i data-lucide="shield" class="w-5 h-5 text-white"></i>
            </div>
            <span x-show="sidebarOpen" class="text-lg font-bold">
                <span class="text-primary-500">Wassel</span>
                <span class="text-slate-800">M3ak</span>
            </span>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 space-y-6">

            <!-- MENU PRINCIPAL -->
            <div>
                <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">
                    Menu
                </p>
                <div class="space-y-1">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ $isDashboard ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ $isUsers ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="font-medium">Utilisateurs</span>
                    </a>

                    <a href="{{ route('admin.demandes') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ $isRequests ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i data-lucide="clipboard-list" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="font-medium">Demandes</span>
                    </a>

                    <a href="{{ route('admin.paiements.statistiques') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ $isPaiementsStats ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="font-medium">Paiements</span>
                    </a>

                    <a href="{{ route('admin.statistics') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ $isStatistics ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i data-lucide="trending-up" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="font-medium">Statistiques</span>
                    </a>
                </div>
            </div>

            <!-- GESTION -->
            <div>
                <p x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">
                    Gestion
                </p>
                <div class="space-y-1">
                    {{-- {{ route('admin.settings') }} --}}
                    <a href=""
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ $isSettings ? 'bg-primary-500 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="font-medium">Paramètres</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- BOTTOM -->
        <div class="pt-6 border-t border-slate-100 space-y-2">
            <a href="{{ route('home') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-50">
                <i data-lucide="home" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Retour au site</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-red-500 hover:bg-red-50">
                    <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>