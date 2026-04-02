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
            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'dashboard' ? 'bg-primary-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-all">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Vue d'ensemble</span>
            </a>
            <a href="{{ route('admin.users') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'users' ? 'bg-primary-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-all">
                <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Gestion utilisateurs</span>
            </a>
            <a href="{{ route('admin.requests') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'requests' ? 'bg-primary-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-all">
                <i data-lucide="clipboard-list" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Gestion demandes</span>
            </a>
            <a href="{{ route('admin.statistics') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'statistics' ? 'bg-primary-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-all">
                <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Statistiques</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'settings' ? 'bg-primary-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-all">
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
