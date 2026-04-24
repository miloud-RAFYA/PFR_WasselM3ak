<section id="how-it-works" class="py-20 lg:py-28 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-medium mb-4">
                Processus simple
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-4">
                Comment ça marche ?
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                3 étapes simples pour expédier vos marchandises en toute confiance
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Steps -->
            <div class="relative">
                <!-- Connection Line - Desktop -->
                <div class="hidden lg:block absolute top-24 left-[16.67%] right-[16.67%] h-0.5 bg-gradient-to-r from-primary-200 via-primary-400 to-primary-200"></div>

                <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                    <!-- Step 1 -->
                    <div class="relative text-center group">
                        <div class="relative inline-flex flex-col items-center mb-6">
                            <div class="w-16 h-16 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    <path d="M9 12h.01"/>
                                    <path d="M13 12h.01"/>
                                    <path d="M17 12h.01"/>
                                </svg>
                            </div>
                            <span class="text-6xl font-bold text-slate-100 absolute -z-10 -top-4 select-none">01</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Publiez votre demande</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Détaillez votre annonce avec l'adresse, les dimensions, le poids et les détails de l'expédition. C'est simple et rapide !
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-center group">
                        <div class="relative inline-flex flex-col items-center mb-6">
                            <div class="w-16 h-16 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                                </svg>
                            </div>
                            <span class="text-6xl font-bold text-slate-100 absolute -z-10 -top-4 select-none">02</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Recevez des propositions</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Les transporteurs vous contacteront. Mettez-vous d'accord sur les détails d'enlèvement et de livraison.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-center group">
                        <div class="relative inline-flex flex-col items-center mb-6">
                            <div class="w-16 h-16 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </div>
                            <span class="text-6xl font-bold text-slate-100 absolute -z-10 -top-4 select-none">03</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Validez et suivez</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Réglez en ligne pour bénéficier d'une assurance et suivez votre colis en temps réel jusqu'à destination.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Image Side -->
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden shadow-xl group">
                    <img
                        src="{{ asset('images/map-illustration.png') }}"
                        alt="Carte de livraison interactive montrant le suivi en temps réel"
                        class="w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-105"
                        loading="lazy"
                        width="600"
                        height="400"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-8 left-8 right-8 text-white">
                        <p class="text-sm font-medium uppercase tracking-wide opacity-80 mb-1">Suivi en temps réel</p>
                        <h3 class="text-2xl font-bold leading-tight">Voyez chaque étape de votre livraison</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-16">
            <p class="text-slate-500 mb-4">Prêt à expédier vos marchandises ?</p>
            <button 
                @click="$dispatch('open-register')" 
                class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-full hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary-500/30"
                type="button"
            >
                Commencer maintenant
                <svg class="w-5 h-5 ml-2 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>