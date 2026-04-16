<nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20) ? true : false"
     :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100' : 'bg-white/80 backdrop-blur-md border-b border-gray-100'"
     class="fixed w-full z-50 transition-all duration-300" id="navbar">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 group">
                <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-primary-500/30 transition-transform group-hover:rotate-12">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-900 tracking-tight">Wasselm3ak</span>
                    <span class="text-xs text-primary-600 font-medium -mt-1 tracking-wider">واسلمعك</span>
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#hero" class="text-gray-600 hover:text-primary-600 font-medium transition">Accueil</a>
                <a href="#how-it-works" class="text-gray-600 hover:text-primary-600 font-medium transition">Comment ça marche</a>
                <a href="#features-client" class="text-gray-600 hover:text-primary-600 font-medium transition">Expédier</a>
                <a href="#features-driver" class="text-gray-600 hover:text-primary-600 font-medium transition">Devenir Transporteur</a>
            </div>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.dashboard') }}" class="text-gray-600 hover:text-primary-600 font-medium px-4 py-2">Tableau de bord</a>
                    @elseif(auth()->user()->isDriver())
                        <a href="{{ route('driver.dashboard') }}" class="text-gray-600 hover:text-primary-600 font-medium px-4 py-2">Tableau de bord</a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-primary-600 font-medium px-4 py-2">Tableau de bord</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="border border-gray-200 text-gray-600 hover:border-primary-500 hover:text-primary-600 px-5 py-2 rounded-full font-medium transition">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('showLogin') }}" class="text-gray-600 hover:text-primary-600 font-medium px-4 py-2">Connexion</a>
                    <a href="/signup" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-full font-semibold shadow-lg shadow-primary-500/30 transition transform hover:scale-105">
                        S'inscrire
                    </a>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-primary-600 focus:outline-none p-2">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'" style="font-size: 1.5rem;"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-white border-t border-gray-100 shadow-xl">
        <div class="px-4 py-6 space-y-4">
            <a href="#hero" class="block py-2 text-gray-700 font-medium hover:text-primary-600">Accueil</a>
            <a href="#how-it-works" class="block py-2 text-gray-700 font-medium hover:text-primary-600">Comment ça marche</a>
            <a href="#features-client" class="block py-2 text-gray-700 font-medium hover:text-primary-600">Expédier</a>
            <a href="#features-driver" class="block py-2 text-gray-700 font-medium hover:text-primary-600">Devenir Transporteur</a>
            
            <hr class="border-gray-100">
            
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center py-3 bg-gray-50 text-gray-600 rounded-xl font-bold">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('showLogin') }}" class="block text-center w-full py-3 border border-gray-200 rounded-xl font-bold text-gray-700">
                    Connexion
                </a>
                <a href="/signup" class="block text-center w-full py-3 bg-primary-500 text-white rounded-xl font-bold shadow-lg shadow-primary-500/20">
                    Inscription
                </a>
            @endauth
        </div>
    </div>
</nav>