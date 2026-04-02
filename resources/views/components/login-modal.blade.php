<div 
    x-data="{ open: false, activeTab: 'client' }"
    x-show="open"
    @open-login.window="open = true"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    <!-- Backdrop -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
    ></div>
    
    <!-- Modal -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
    >
        <!-- Close Button -->
        <button
            @click="open = false"
            class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors z-10"
        >
            <i data-lucide="x" class="w-5 h-5 text-slate-500"></i>
        </button>

        <!-- Header -->
        <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-8 text-white text-center">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="truck" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold mb-2">Bienvenue sur WasselM3ak</h2>
            <p class="text-white/80">Connectez-vous pour accéder à votre compte</p>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Tabs -->
            {{-- <div class="flex rounded-lg bg-slate-100 p-1 mb-6">
                <button 
                    @click="activeTab = 'client'"
                    :class="activeTab === 'client' ? 'bg-white shadow-sm text-primary-600' : 'text-slate-600 hover:text-slate-800'"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition-all"
                >
                    <i data-lucide="user" class="w-4 h-4"></i>
                    Client
                </button>
                <button 
                    @click="activeTab = 'driver'"
                    :class="activeTab === 'driver' ? 'bg-white shadow-sm text-primary-600' : 'text-slate-600 hover:text-slate-800'"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition-all"
                >
                    <i data-lucide="truck" class="w-4 h-4"></i>
                    Chauffeur
                </button>
                <button 
                    @click="activeTab = 'admin'"
                    :class="activeTab === 'admin' ? 'bg-white shadow-sm text-primary-600' : 'text-slate-600 hover:text-slate-800'"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition-all"
                >
                    <i data-lucide="shield" class="w-4 h-4"></i>
                    Admin
                </button>
            </div> --}}

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="user_type" x-model="activeTab">
                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input 
                            type="email" 
                            name="email"
                            placeholder="votre@email.com"
                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            required
                        >
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Mot de passe</label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input 
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            required
                        >
                        <button 
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                        >
                            <i data-lucide="eye" class="w-5 h-5" x-show="!showPassword"></i>
                            <i data-lucide="eye-off" class="w-5 h-5" x-show="showPassword"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300">
                        <span class="text-slate-600">Se souvenir de moi</span>
                    </label>
                    <a href="" class="text-primary-500 hover:text-primary-600">
                        {{-- {{ route('password.request') }} --}}
                        Mot de passe oublié ?
                    </a>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-medium transition-colors shadow-xl shadow-primary-500/20"
                >
                    Se connecter
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-slate-500">Ou continuez avec</span>
                </div>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-3">
                {{-- {{ route('auth.google') }} --}}
                <a href="" class="flex items-center justify-center gap-2 px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </a>
                {{-- {{ route('auth.facebook') }} --}}
                <a href="" class="flex items-center justify-center gap-2 px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
            </div>

            <!-- Register Link -->
            <p class="text-center mt-6 text-sm text-slate-600">
                Vous n'avez pas de compte ?
                <button @click="open = false; $dispatch('open-register')" class="text-primary-500 hover:text-primary-600 font-medium">
                    Inscrivez-vous
                </button>
            </p>
        </div>
    </div>
</div>
