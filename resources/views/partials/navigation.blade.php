{{-- partials/navigation.blade.php --}}
<nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
     @scroll.window="scrolled = window.pageYOffset > 20"
     :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100' : 'bg-white/80 backdrop-blur-md border-b border-gray-100'"
     class="fixed w-full z-50 transition-all duration-300 safe-top"
     style="top: env(safe-area-inset-top, 0);">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 sm:h-24">
            <!-- Logo agrandi 2x -->
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 sm:gap-4 group">
                <div class="h-20 w-20 sm:h-24 sm:w-24 md:h-32 md:w-32 lg:h-36 lg:w-36 transition-all duration-300 group-hover:scale-105">
                    <img src="{{ asset('images/ideogram-v3.0_Modern_minimalist_logo_for_WasselM3ak_Moroccan_transport_and_logistics_company._-0-removebg-preview.png') }}" 
                         alt="WasselM3ak - Transport de marchandises au Maroc"
                         class="w-full h-full object-contain" />
                </div>
                
                <div class="flex flex-col">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tighter uppercase">
                        <span class="text-primary-500">Wassel</span><span class="text-gray-800">m3ak</span>
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-gray-500 hidden sm:block">Transport & Logistique</p>
                </div>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                <a href="#hero" class="text-gray-600 hover:text-primary-500 font-medium transition text-base xl:text-lg">Accueil</a>
                <a href="#how-it-works" class="text-gray-600 hover:text-primary-500 font-medium transition text-base xl:text-lg">Comment ça marche</a>
                <a href="#features-client" class="text-gray-600 hover:text-primary-500 font-medium transition text-base xl:text-lg">Expédier</a>
                <a href="#features-driver" class="text-gray-600 hover:text-primary-500 font-medium transition text-base xl:text-lg">Devenir Transporteur</a>
            </div>
            
            <!-- Desktop Auth Buttons -->
            <div class="hidden lg:flex items-center gap-3 xl:gap-4">
                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.dashboard') }}" 
                           class="text-gray-600 hover:text-primary-500 font-medium px-3 py-2 text-base xl:text-lg transition">
                            Tableau de bord
                        </a>
                    @elseif(auth()->user()->isDriver())
                        <a href="{{ route('driver.dashboard') }}" 
                           class="text-gray-600 hover:text-primary-500 font-medium px-3 py-2 text-base xl:text-lg transition">
                            Tableau de bord
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="text-gray-600 hover:text-primary-500 font-medium px-3 py-2 text-base xl:text-lg transition">
                            Tableau de bord
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="border border-gray-200 text-gray-600 hover:border-primary-500 hover:text-primary-500 px-5 sm:px-6 py-2.5 rounded-full font-medium transition text-sm">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('showLogin') }}" 
                       class="text-gray-600 hover:text-primary-500 font-medium px-3 py-2 text-base xl:text-lg transition">
                        Connexion
                    </a>
                    <a href="/signup" 
                       class="bg-primary-500 hover:bg-primary-600 text-white px-5 sm:px-7 py-2.5 rounded-full font-semibold shadow-lg shadow-primary-500/30 transition transform hover:scale-105 text-base">
                        S'inscrire
                    </a>
                @endauth
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-600 hover:text-primary-500 focus:outline-none p-2 active:scale-95 transition-transform"
                        aria-label="Menu">
                    <i class="fa-solid text-2xl sm:text-3xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4" 
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white border-t border-gray-100 shadow-xl safe-bottom"
         style="display: none;">
        
        <div class="px-4 py-4 sm:px-6 sm:py-6 space-y-3">
            <a href="#hero" @click="mobileMenuOpen = false" 
               class="block py-3 text-gray-700 font-medium hover:text-primary-500 text-base active:bg-gray-50 rounded-lg px-3 transition">
                <i class="fa-solid fa-home mr-3 text-primary-500 w-5"></i>
                Accueil
            </a>
            <a href="#how-it-works" @click="mobileMenuOpen = false" 
               class="block py-3 text-gray-700 font-medium hover:text-primary-500 text-base active:bg-gray-50 rounded-lg px-3 transition">
                <i class="fa-solid fa-question-circle mr-3 text-primary-500 w-5"></i>
                Comment ça marche
            </a>
            <a href="#features-client" @click="mobileMenuOpen = false" 
               class="block py-3 text-gray-700 font-medium hover:text-primary-500 text-base active:bg-gray-50 rounded-lg px-3 transition">
                <i class="fa-solid fa-box mr-3 text-primary-500 w-5"></i>
                Expédier
            </a>
            <a href="#features-driver" @click="mobileMenuOpen = false" 
               class="block py-3 text-gray-700 font-medium hover:text-primary-500 text-base active:bg-gray-50 rounded-lg px-3 transition">
                <i class="fa-solid fa-truck mr-3 text-primary-500 w-5"></i>
                Devenir Transporteur
            </a>
            
            <hr class="border-gray-100 my-4">
            
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full text-center py-3 bg-gray-50 text-gray-600 rounded-xl font-bold text-base active:bg-gray-100 transition">
                        <i class="fa-solid fa-sign-out-alt mr-2"></i>
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('showLogin') }}" 
                   class="block text-center w-full py-3 border border-gray-200 rounded-xl font-bold text-gray-700 active:bg-gray-50 transition">
                    <i class="fa-solid fa-sign-in-alt mr-2"></i>
                    Connexion
                </a>
                <a href="/signup" 
                   class="block text-center w-full py-3 bg-primary-500 text-white rounded-xl font-bold shadow-lg shadow-primary-500/20 active:scale-95 transition-transform">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Inscription
                </a>
            @endauth
        </div>
    </div>
</nav>