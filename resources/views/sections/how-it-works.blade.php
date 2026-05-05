{{-- sections/how-it-works.blade.php --}}
<section id="how-it-works" class="py-12 sm:py-16 lg:py-20 xl:py-28 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16">
            <span class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-100 text-primary-600 rounded-full text-xs sm:text-sm font-medium mb-3 sm:mb-4">
                Processus simple
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-slate-900 mb-3 sm:mb-4">
                Comment ça marche ?
            </h2>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto px-4">
                3 étapes simples pour expédier vos marchandises en toute confiance
            </p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16 items-center">
            <div class="grid sm:grid-cols-2 lg:grid-cols-1 gap-6 sm:gap-8">
                @php
                    $steps = [
                        ['step' => '01', 'icon' => 'file-text', 'title' => 'Publiez votre demande', 'desc' => "Détaillez votre annonce avec l'adresse, les dimensions, le poids et les détails de l'expédition. C'est simple et rapide !"],
                        ['step' => '02', 'icon' => 'message-circle', 'title' => 'Recevez des propositions', 'desc' => "Les transporteurs vous contacteront. Mettez-vous d'accord sur les détails d'enlèvement et de livraison."],
                        ['step' => '03', 'icon' => 'check-circle', 'title' => 'Validez et suivez', 'desc' => "Réglez en ligne pour bénéficier d'une assurance et suivez votre colis en temps réel jusqu'à destination."]
                    ];
                @endphp
                
                @foreach($steps as $step)
                <div class="relative text-center sm:text-left group">
                    <div class="relative inline-flex flex-col sm:flex-row items-center sm:items-start gap-3 sm:gap-4 mb-3 sm:mb-4">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-primary-500 rounded-xl sm:rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transform transition-transform duration-300 group-hover:scale-110">
                            <i data-lucide="{{ $step['icon'] }}" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                        </div>
                        <span class="text-4xl sm:text-5xl font-bold text-slate-100 absolute -z-10 -top-3 sm:-top-4 left-0 sm:left-12 select-none">{{ $step['step'] }}</span>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-2 sm:mt-0">{{ $step['title'] }}</h3>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        {{ $step['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
            
            <div class="relative mt-8 sm:mt-12 lg:mt-0">
                <div class="relative rounded-xl sm:rounded-2xl lg:rounded-3xl overflow-hidden shadow-xl group">
                    <img src="{{ asset('images/map-illustration.png') }}" 
                         alt="Carte de livraison interactive"
                         class="w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-4 sm:bottom-6 lg:bottom-8 left-4 sm:left-6 lg:left-8 right-4 sm:right-6 lg:right-8 text-white">
                        <p class="text-[10px] sm:text-xs font-medium uppercase tracking-wide opacity-80 mb-1">Suivi en temps réel</p>
                        <h3 class="text-base sm:text-lg lg:text-xl font-bold leading-tight">Voyez chaque étape de votre livraison</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8 sm:mt-12 lg:mt-16">
            <p class="text-slate-500 mb-3 sm:mb-4 text-sm sm:text-base">Prêt à expédier vos marchandises ?</p>
            <button @click="$dispatch('open-register')" 
                    class="inline-flex items-center px-5 sm:px-6 py-2.5 sm:py-3 bg-primary-500 text-white font-semibold rounded-full text-sm sm:text-base hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all active:scale-95 shadow-lg shadow-primary-500/30"
                    type="button">
                Commencer maintenant
                <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5 ml-2 transform transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>
    </div>
</section>