<header class="bg-white shadow-sm px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button 
                @click="sidebarOpen = !sidebarOpen"
                class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
            >
                <i data-lucide="menu" class="w-5 h-5 text-slate-600"></i>
            </button>
            <h1 class="text-xl font-semibold text-slate-900">
                @yield('page-title', 'Tableau de bord')
            </h1>
        </div>

        <div class="flex items-center gap-4">
            @hasSection('availability-toggle')
                @yield('availability-toggle')
            @endif
            
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input 
                    type="text" 
                    placeholder="Rechercher..." 
                    class="pl-10 pr-4 py-2 w-64 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                >
            </div>
            
            <button class="relative p-2 hover:bg-slate-100 rounded-lg transition-colors">
                <i data-lucide="bell" class="w-5 h-5 text-slate-600"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                        {{ substr(Auth::user()->name ?? 'User', 0, 2) }}
                    </div>
                </button>
                
                <div 
                    x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50"
                >
                {{-- {{ route('profile') }} --}}
                    <a href="" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                        Mon profil
                    </a>
                    {{-- {{ route('settings') }} --}}
                    <a href="" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                        Paramètres
                    </a>
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
