{{-- sections/hero.blade.php --}}
<section id="hero" class="relative min-h-[85vh] sm:min-h-[90vh] pt-20 sm:pt-24 lg:pt-28 flex items-center bg-white overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 24px sm:32px; opacity: 0.2;"></div>
        <div class="absolute top-0 right-0 w-[300px] sm:w-[400px] lg:w-[600px] h-[300px] sm:h-[400px] lg:h-[600px] bg-red-50/60 rounded-full blur-[80px] sm:blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[250px] sm:w-[350px] lg:w-[400px] h-[250px] sm:h-[350px] lg:h-[400px] bg-green-50/50 rounded-full blur-[80px] sm:blur-[100px] translate-y-1/4 -translate-x-1/4"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-24 relative z-10">
        <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16 items-center">
            <div class="space-y-6 sm:space-y-8 lg:space-y-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-green-600"></span>
                    <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-[0.2em] text-slate-500">Logistique Digitale Maroc</span>
                </div>
                
                <div class="space-y-4 sm:space-y-6">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] sm:leading-[1.05] lg:leading-[0.95]">
                        Vos expéditions<br>
                        <span class="text-primary-600">sans limites.</span>
                    </h1>
                    <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-lg leading-relaxed font-medium">
                        Connectez vos marchandises aux meilleurs transporteurs certifiés. Une solution <span class="text-slate-900 font-bold">WasselM3ak</span> pour une logistique sans friction à travers tout le Royaume.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    @auth
                        @if(auth()->user()->isClient())
                            <a href="{{ route('client.dashboard') }}" 
                               class="px-6 sm:px-8 py-3 sm:py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold text-sm sm:text-base shadow-xl shadow-primary-600/20 active:scale-95 transition-transform text-center">
                                Mon Espace Client
                                <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2"></i>
                            </a>
                        @elseif(auth()->user()->isDriver())
                            <a href="{{ route('driver.dashboard') }}" 
                               class="px-6 sm:px-8 py-3 sm:py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold text-sm sm:text-base shadow-xl shadow-primary-600/20 active:scale-95 transition-transform text-center">
                                Mon Espace Chauffeur
                                <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2"></i>
                            </a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-6 sm:px-8 py-3 sm:py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold text-sm sm:text-base shadow-xl shadow-primary-600/20 active:scale-95 transition-transform text-center">
                                Espace Admin
                                <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('signup') }}" 
                           class="px-6 sm:px-8 py-3 sm:py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold text-sm sm:text-base shadow-xl shadow-primary-600/20 active:scale-95 transition-transform text-center">
                            Expédier un colis
                            <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2"></i>
                        </a>
                    @endauth
                    <a href="{{ route('showLogin') }}" 
                       class="px-6 sm:px-8 py-3 sm:py-4 border-2 border-slate-900 text-slate-900 hover:bg-slate-900 hover:text-white rounded-xl font-bold text-sm sm:text-base active:scale-95 transition-all text-center">
                        Se connecter
                    </a>
                </div>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-8 pt-4">
                    <div class="flex -space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[8px] sm:text-[10px] font-bold">JD</div>
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-white bg-red-100 flex items-center justify-center text-[8px] sm:text-[10px] font-bold text-red-600">WM</div>
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-white bg-green-100 flex items-center justify-center text-[8px] sm:text-[10px] font-bold text-green-600">MA</div>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-slate-200"></div>
                    <div class="text-xs sm:text-sm font-medium text-slate-500">
                        Rejoint par plus de <span class="text-slate-900 font-bold">{{ number_format($stats['total_users'] ?? 0) }}</span> utilisateurs ce mois.
                    </div>
                </div>
            </div>
            
            <div class="relative mt-8 lg:mt-0">
                <div class="relative z-10">
                    <div class="relative p-3 sm:p-4 bg-slate-50 rounded-2xl sm:rounded-[2.5rem] border border-slate-100 shadow-inner group">
                        <img src="{{ asset('images/hero-delivery.png') }}" 
                             alt="Logistique"
                             class="w-full h-auto rounded-xl sm:rounded-[2rem] shadow-2xl"
                             loading="lazy">
                        
                        <div class="absolute -top-3 sm:-top-6 -right-3 sm:-right-6 bg-white p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-xl border border-slate-100">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                    <i data-lucide="check-circle" class="w-4 h-4 sm:w-6 sm:h-6 text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-[8px] sm:text-[10px] font-bold text-slate-400 uppercase">Livraison</p>
                                    <p class="text-xs sm:text-sm font-black text-slate-900">100% Terminée</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute -bottom-3 sm:-bottom-4 -left-4 sm:-left-8 bg-slate-900 text-white p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-2xl max-w-[160px] sm:max-w-[200px] hidden md:block">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-primary-600 rounded-full flex-shrink-0 flex items-center justify-center">
                                    <i data-lucide="navigation" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                                </div>
                                <p class="text-[10px] sm:text-xs font-medium leading-tight">Nouveau transporteur disponible à Casablanca.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>