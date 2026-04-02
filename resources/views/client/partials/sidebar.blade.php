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
            <a href="{{ route('client.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'dashboard' ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }} transition-all">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Tableau de bord</span>
            </a>
            <a href="{{ route('client.requests') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'requests' ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }} transition-all">
                <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Mes demandes</span>
            </a>
            <a href="{{ route('client.requests.create') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'requests.create' ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }} transition-all">
                <i data-lucide="plus-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Nouvelle demande</span>
            </a>
            <a href="{{ route('client.messages') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'messages' ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }} transition-all">
                <i data-lucide="message-square" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="sidebarOpen" class="font-medium">Messages</span>
            </a>
            <a href="{{ route('profile') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ ($active ?? '') === 'profile' ? 'bg-primary-500 text-white' : 'text-slate-600 hover:bg-slate-100' }} transition-all">
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
