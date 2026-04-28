<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-slate-900 border-r border-slate-800 flex flex-col h-screen sticky top-0 transition-all duration-300"
>

@php
    $isDashboard = ($active ?? '') === 'dashboard';
    $isUsers = ($active ?? '') === 'users';
    $isDriverDocuments = ($active ?? '') === 'driver-documents';
    $isRequests = ($active ?? '') === 'requests';
    $isStatistics = ($active ?? '') === 'statistics';
    $isSettings = ($active ?? '') === 'settings';
@endphp

<div class="p-4 flex flex-col h-full">

    <!-- LOGO -->
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow">
            <i data-lucide="shield" class="w-5 h-5 text-white"></i>
        </div>

        <span x-show="sidebarOpen" class="text-lg font-bold text-white">
            Admin Panel
        </span>
    </div>

    <!-- NAVIGATION -->
    <nav class="flex-1 space-y-6">

        <!-- MENU PRINCIPAL -->
        <div>
            <p x-show="sidebarOpen" class="text-xs text-slate-500 uppercase mb-2">
                Menu
            </p>

            <div class="space-y-2">

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                    {{ $isDashboard ? 'bg-primary-500 text-white shadow' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                    {{ $isUsers ? 'bg-primary-500 text-white shadow' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Utilisateurs</span>
                </a>


                <a href="{{ route('admin.demandes') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                    {{ $isRequests ? 'bg-primary-500 text-white shadow' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                    <i data-lucide="clipboard-list" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Demandes</span>
                </a>

                <a href="{{ route('admin.statistics') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                    {{ $isStatistics ? 'bg-primary-500 text-white shadow' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                    <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="font-medium">Statistiques</span>
                </a>

            </div>
        </div>

        <!-- GESTION -->
        <div>
            <p x-show="sidebarOpen" class="text-xs text-slate-500 uppercase mb-2">
                Gestion
            </p>
           {{-- {{ route('admin.settings') }} --}}
            <a href=""
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                {{ $isSettings ? 'bg-primary-500 text-white shadow' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Paramètres</span>
            </a>
        </div>

    </nav>

    <!-- BOTTOM -->
    <div class="pt-6 border-t border-slate-800 space-y-2">

        <a href="{{ route('home') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">

            <i data-lucide="home" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="sidebarOpen" class="font-medium">Retour site</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-900/20 transition-all">

                <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Déconnexion</span>
            </button>
        </form>

    </div>

</div>

</aside>