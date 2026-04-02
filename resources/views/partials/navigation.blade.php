<nav x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20) ? true : false"
    :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm border-b border-red-50' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-12 h-12 transform transition-transform group-hover:rotate-12 duration-300">
                    <circle cx="25" cy="25" r="23" stroke="#e2e8f0" stroke-width="1.5"
                        stroke-dasharray="4 4" />

                    <path d="M12 18L18.5 34L25 25L31.5 34L38 18" stroke="#E31D1C" stroke-width="4.5"
                        stroke-linecap="round" stroke-linejoin="round" class="drop-shadow-sm" />

                    <path d="M38 18C41 22 42 28 38 34M12 18C9 22 8 28 12 34" stroke="#006233" stroke-width="2.5"
                        stroke-linecap="round" />

                    <path d="M25 10L26.2 13.5H30L27 15.5L28.2 19L25 17L21.8 19L23 15.5L20 13.5H23.8L25 10Z"
                        fill="#006233" />

                    <circle cx="12" cy="18" r="2" fill="#006233" />
                    <circle cx="38" cy="18" r="2" fill="#006233" />
                </svg>

                <div class="flex flex-col leading-tight">
                    <span class="text-2xl font-black tracking-tighter italic">
                        <span class="text-red-600">WASSEL</span>
                        <span class="text-slate-800">M3AK</span>
                    </span>
                    <span class="text-[9px] font-bold text-green-700 tracking-[0.2em] uppercase">Logistics
                        Morocco</span>
                </div>

            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#hero"
                    class="text-slate-600 hover:text-red-600 transition-colors font-medium relative group">
                    Accueil
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="#how-it-works"
                    class="text-slate-600 hover:text-red-600 transition-colors font-medium relative group">
                    Comment ça marche
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="#features-client"
                    class="text-slate-600 hover:text-red-600 transition-colors font-medium relative group">
                    Pour les clients
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="#features-driver"
                    class="text-slate-600 hover:text-red-600 transition-colors font-medium relative group">
                    Pour les chauffeurs
                </a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                {{-- {{ route('dashboard') }} --}}
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.dashboard') }}"
                            class="px-4 py-2 text-slate-600 hover:text-red-600 transition-colors font-semibold">
                            Tableau de bord
                        </a>
                    @elseif(auth()->user()->isDriver())
                        <a href="{{ route('driver.dashboard') }}"
                            class="px-4 py-2 text-slate-600 hover:text-red-600 transition-colors font-semibold">
                            Tableau de bord
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 text-slate-600 hover:text-red-600 transition-colors font-semibold">
                            Tableau de bord
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 border-2 border-slate-200 rounded-xl hover:border-red-600 hover:text-red-600 transition-all font-bold text-sm">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 text-slate-600 hover:text-red-600 transition-colors font-bold text-sm">
                        Connexion
                    </a>
                    <a href="signup"
                        class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl shadow-md shadow-red-500/20 transition-all transform hover:-translate-y-0.5 flex items-center gap-2 font-bold text-sm">
                        <i data-lucide="user-plus" class="w-4 h-4 text-green-300"></i>
                        Inscription
                    </a>
                @endauth
            </div>

            <button class="md:hidden p-2 rounded-lg bg-slate-50 border border-slate-200"
                @click="mobileMenuOpen = !mobileMenuOpen">
                <i data-lucide="menu" class="w-6 h-6 text-red-600" x-show="!mobileMenuOpen"></i>
                <i data-lucide="x" class="w-6 h-6 text-red-600" x-show="mobileMenuOpen"></i>
            </button>
        </div>
    </div>

    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden bg-white border-t border-red-50 shadow-xl"
        @click.away="mobileMenuOpen = false">
        <div class="px-4 py-6 space-y-4">
            <a href="#hero" class="block py-2 text-slate-700 font-bold hover:text-red-600">Accueil</a>
            <a href="#how-it-works" class="block py-2 text-slate-700 font-bold hover:text-red-600">Comment ça marche</a>
            <a href="#features-client" class="block py-2 text-slate-700 font-bold hover:text-red-600">Pour les
                clients</a>
            <a href="#features-driver" class="block py-2 text-slate-700 font-bold hover:text-red-600">Pour les
                chauffeurs</a>
            <hr class="border-red-50">
            @auth
            {{-- {{ route('dashboard') }} --}}
                @if(auth()->user()->isClient())
                    <a href="{{ route('client.dashboard') }}" class="block py-2 text-red-600 font-bold">Tableau de bord</a>
                @elseif(auth()->user()->isDriver())
                    <a href="{{ route('driver.dashboard') }}" class="block py-2 text-red-600 font-bold">Tableau de bord</a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-red-600 font-bold">Tableau de bord</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-center py-3 border-2 border-red-600 rounded-xl text-red-600 font-bold">
                        Déconnexion
                    </button>
                </form>
            @else
                {{-- {{ route('signup') }} --}}
                <a href="{{ route('login') }}" class="w-full py-3 border-2 border-slate-200 rounded-xl font-bold text-slate-700">
                    Connexion
                </a>
                {{-- {{ route('signup') }} --}}
                <button @click="$dispatch('open-register')"
                    class="block text-center w-full mt-3 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg hover:bg-red-700 transition-colors">
                    Inscription
                </button>
            @endauth
        </div>
    </div>
</nav>
