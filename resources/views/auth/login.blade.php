@extends('layouts.app')

@section('title', 'Connexion - WasselM3ak')

@section('content')
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="min-h-screen flex bg-gray-50 font-sans" x-data="{ showPass: false }" x-cloak>

        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 items-center justify-center p-12 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1570646230254-1da7bc87636e?auto=format&fit=crop&w=1200&q=80"
                class="absolute inset-0 w-full h-full object-cover opacity-30" alt="Logistique Maroc">

            <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-slate-900/90"></div>

            <div class="relative z-10 max-w-md text-center">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-orange-500 rounded-[2rem] text-white shadow-2xl mb-8 transform -rotate-12">
                    <i data-lucide="log-in" class="w-10 h-10"></i>
                </div>
                <h1 class="text-5xl font-black text-white italic uppercase tracking-tighter mb-4">
                    Bon Retour <br><span class="text-orange-500">Parmi Nous</span>
                </h1>
                <p class="text-slate-300 text-lg leading-relaxed">
                    Connectez-vous pour gérer vos expéditions ou vos trajets en cours sur la plateforme N°1 au Maroc.
                </p>
            </div>

            <div
                class="absolute bottom-10 left-10 right-10 flex justify-between items-center border-t border-white/10 pt-6">
                <div class="text-white/40 text-xs uppercase tracking-widest font-bold">WasselM3ak v1</div>
                <div class="flex gap-4">
                    <i data-lucide="shield-check" class="text-orange-500 w-5 h-5"></i>
                    <i data-lucide="truck" class="text-white/20 w-5 h-5"></i>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 md:p-12">
            <div class="max-w-md w-full">

                <div class="lg:hidden flex items-center justify-center gap-2 mb-10">
                    <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i data-lucide="truck" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-black italic text-slate-800 uppercase">WASSEL<span
                            class="text-orange-500">M3AK</span></span>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-slate-200/60 border border-gray-100">
                    <div class="mb-10">
                        <h2 class="text-3xl font-black text-slate-800 uppercase italic tracking-tight">Connexion</h2>
                        <p class="text-slate-500 mt-2">Heureux de vous revoir !</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        @if ($errors->any())
                            <div
                                class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-500 rounded-r-xl flex gap-3 animate-fade-in">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-orange-500 shrink-0"></i>
                                <div>
                                    <h4 class="text-sm font-bold text-orange-800 uppercase tracking-tight">Oups ! Quelque
                                        chose ne va pas</h4>
                                    <ul class="mt-1 list-disc list-inside text-xs text-orange-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">E-mail
                                Professionnel</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="mail"
                                        class="w-5 h-5 text-slate-300 group-focus-within:text-orange-500 transition-colors"></i>
                                </div>
                                <input type="email" name="email" required autofocus
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all placeholder:text-slate-300"
                                    placeholder="exemple@wassel.ma">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between items-center ml-1">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Mot de
                                    passe</label>
                                <a href="#"
                                    class="text-[10px] font-bold text-orange-500 uppercase hover:underline">Oublié ?</a>
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="lock"
                                        class="w-5 h-5 text-slate-300 group-focus-within:text-orange-500 transition-colors"></i>
                                </div>
                                <input :type="showPass ? 'text' : 'password'" name="password" required
                                    class="w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all placeholder:text-slate-300"
                                    placeholder="••••••••">
                                <button type="button" @click="showPass = !showPass"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-orange-500 transition-colors">
                                    <i :data-lucide="showPass ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 ml-1">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                            <label for="remember"
                                class="text-sm font-medium text-slate-500 cursor-pointer select-none">Rester
                                connecté</label>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-orange-500/30 transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
                            Se connecter
                            <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>

                    <div class="mt-10 text-center">
                        <p class="text-slate-500 text-sm">Pas encore de compte ?</p>
                        <a href="/register"
                            class="inline-block mt-2 font-black text-slate-800 uppercase text-xs border-b-2 border-orange-500 pb-1 hover:text-orange-500 transition-colors">
                            Créer un profil gratuitement
                        </a>
                    </div>
                </div>

                <p class="text-center mt-8 text-slate-400 text-[10px] uppercase font-bold tracking-[0.2em]">
                    &copy; 2026 WasselM3ak Logistics Solutions.
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Animation douce pour le focus des inputs */
        input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endsection
