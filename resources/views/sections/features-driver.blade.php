<section id="features-driver" class="py-20 lg:py-28 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left Content - Image (inversé) -->
            <div class="relative reveal-left order-2 lg:order-1">
                <div class="relative group">
                    <img 
                        src="{{ asset('images/driver-illustration.png') }}" 
                        alt="Application mobile pour transporteurs avec tableau de bord"
                        class="w-full h-auto rounded-2xl shadow-2xl transform transition-transform duration-700 group-hover:scale-[1.02]"
                        loading="lazy"
                        width="600"
                        height="500"
                    >
                    
                    <!-- Floating Earnings Card -->
                    <div class="absolute -bottom-6 -right-6 bg-white rounded-xl shadow-2xl p-4 animate-float">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center animate-pulse-slow">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-slate-900">+40%</p>
                                <p class="text-sm text-slate-500">Revenus supplémentaires</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Trips Badge -->
                    <div class="absolute -top-4 -left-4 bg-primary-500 rounded-xl shadow-2xl p-4 text-white transform transition-transform duration-300 hover:scale-105 hover:-rotate-2">
                        <div class="text-center">
                            <p class="text-3xl font-bold">15K+</p>
                            <p class="text-sm opacity-90">Transporteurs actifs</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content - Text (inversé) -->
            <div class="reveal-right order-1 lg:order-2">
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-medium mb-4 animate-fade-in">
                    Pour les transporteurs
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-4 leading-tight">
                    Rentabilisez vos trajets et optimisez votre activité
                </h2>
                <p class="text-lg text-slate-600 mb-8">
                    Professionnel ou particulier avec un véhicule, transformez vos kilomètres vides en revenus avec WasselM3ak.
                </p>

                <!-- Features List -->
                <div class="space-y-6">
                    <!-- Feature 1 -->
                    <div class="flex gap-4 group feature-item" style="--delay: 0ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"/>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">Gagnez plus</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Augmentez vos revenus en remplissant vos véhicules sur les trajets que vous effectuez déjà. Zéro kilomètre perdu.</p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex gap-4 group feature-item" style="--delay: 100ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">Visibilité totale</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Accédez à des milliers d'expéditeurs actifs. Votre profil visible 24/7 avec notation et avis clients.</p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex gap-4 group feature-item" style="--delay: 200ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">Paiement sécurisé</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Encaissez avant le départ. Notre système de paiement protège votre argent et garantit vos courses.</p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="flex gap-4 group feature-item" style="--delay: 300ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">Rapidité d'action</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Trouvez des missions en quelques clics. Proposez vos tarifs et négociez directement avec les expéditeurs.</p>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="flex gap-4 group feature-item" style="--delay: 400ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">Flexibilité maximale</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Choisissez vos trajets, vos horaires et vos tarifs. Travaillez quand vous voulez, où vous voulez.</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Benefits -->
                <div class="mt-8 pt-8 border-t border-slate-200">
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-1.5 rounded-full shadow-sm">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Inscription gratuite
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-1.5 rounded-full shadow-sm">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Commission réduite
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-1.5 rounded-full shadow-sm">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Support dédié
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Animations d'entrée */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .reveal-left {
        animation: fadeInLeft 0.8s ease-out forwards;
    }

    .reveal-right {
        animation: fadeInRight 0.8s ease-out 0.3s forwards;
        opacity: 0;
    }

    .feature-item {
        opacity: 0;
        animation: fadeInRight 0.6s ease-out forwards;
        animation-delay: var(--delay);
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
    }

    /* Intersection Observer pour révéler au scroll */
    @media (prefers-reduced-motion: no-preference) {
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .reveal-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Respect des préférences de réduction de mouvement */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>