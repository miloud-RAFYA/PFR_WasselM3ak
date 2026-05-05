{{-- sections/features-driver.blade.php --}}
<section id="features-driver" class="py-12 sm:py-16 lg:py-20 xl:py-28 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-20 items-center">
            <div class="relative order-2 lg:order-1">
                <div class="relative group">
                    <img src="{{ asset('images/driver-illustration.png') }}" 
                         alt="Application mobile pour transporteurs"
                         class="w-full h-auto rounded-xl sm:rounded-2xl shadow-2xl transform transition-transform duration-700 group-hover:scale-[1.02]"
                         loading="lazy">
                    
                    <div class="absolute -bottom-3 sm:-bottom-6 -right-3 sm:-right-6 bg-white rounded-lg sm:rounded-xl shadow-2xl p-3 sm:p-4 animate-float">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center animate-pulse-slow">
                                <i data-lucide="dollar-sign" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xl sm:text-2xl font-bold text-slate-900">+40%</p>
                                <p class="text-[10px] sm:text-sm text-slate-500">Revenus supplémentaires</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -top-3 sm:-top-4 -left-3 sm:-left-4 bg-primary-500 rounded-lg sm:rounded-xl shadow-2xl p-3 sm:p-4 text-white transform transition-transform duration-300 active:scale-95 sm:hover:scale-105">
                        <div class="text-center">
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold">15K+</p>
                            <p class="text-[10px] sm:text-xs opacity-90">Transporteurs actifs</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <span class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-100 text-primary-600 rounded-full text-xs sm:text-sm font-medium mb-3 sm:mb-4">
                    Pour les transporteurs
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-slate-900 mb-3 sm:mb-4 leading-tight">
                    Rentabilisez vos trajets et optimisez votre activité
                </h2>
                <p class="text-base sm:text-lg text-slate-600 mb-6 sm:mb-8">
                    Professionnel ou particulier avec un véhicule, transformez vos kilomètres vides en revenus avec WasselM3ak.
                </p>
                
                <div class="space-y-4 sm:space-y-6">
                    @php
                        $driverFeatures = [
                            ['icon' => 'trending-up', 'title' => 'Gagnez plus', 'desc' => "Augmentez vos revenus en remplissant vos véhicules sur les trajets que vous effectuez déjà. Zéro kilomètre perdu."],
                            ['icon' => 'eye', 'title' => 'Visibilité totale', 'desc' => "Accédez à des milliers d'expéditeurs actifs. Votre profil visible 24/7 avec notation et avis clients."],
                            ['icon' => 'lock', 'title' => 'Paiement sécurisé', 'desc' => "Encaissez avant le départ. Notre système de paiement protège votre argent et garantit vos courses."],
                            ['icon' => 'zap', 'title' => 'Rapidité d\'action', 'desc' => "Trouvez des missions en quelques clics. Proposez vos tarifs et négociez directement avec les expéditeurs."],
                            ['icon' => 'clock', 'title' => 'Flexibilité maximale', 'desc' => "Choisissez vos trajets, vos horaires et vos tarifs. Travaillez quand vous voulez, où vous voulez."]
                        ];
                    @endphp
                    
                    @foreach($driverFeatures as $feature)
                    <div class="flex gap-3 sm:gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-primary-500 rounded-lg sm:rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <i data-lucide="{{ $feature['icon'] }}" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $feature['title'] }}</h3>
                            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-slate-200">
                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-slate-600 bg-slate-50 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full shadow-sm">
                            <i data-lucide="user-plus" class="w-3 h-3 sm:w-4 sm:h-4 text-green-500"></i>
                            Inscription gratuite
                        </div>
                        <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-slate-600 bg-slate-50 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full shadow-sm">
                            <i data-lucide="percent" class="w-3 h-3 sm:w-4 sm:h-4 text-green-500"></i>
                            Commission réduite
                        </div>
                        <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-slate-600 bg-slate-50 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full shadow-sm">
                            <i data-lucide="headphones" class="w-3 h-3 sm:w-4 sm:h-4 text-green-500"></i>
                            Support dédié
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>