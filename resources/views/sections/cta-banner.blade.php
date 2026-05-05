{{-- sections/cta-banner.blade.php --}}
<section id="cta" class="py-12 sm:py-16 lg:py-20 xl:py-28 bg-slate-900 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96 bg-primary-500/10 rounded-full blur-2xl sm:blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-0 right-1/4 w-56 h-56 sm:w-72 sm:h-72 lg:w-80 lg:h-80 bg-primary-500/10 rounded-full blur-2xl sm:blur-3xl animate-pulse" style="animation-duration: 10s; animation-delay: 2s;"></div>
    </div>
    
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px sm:40px;"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-500/20 text-primary-400 rounded-full text-xs sm:text-sm font-medium mb-4 sm:mb-6">
                <i data-lucide="sparkles" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                Rejoignez-nous dès maintenant
            </div>
            
            <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 sm:mb-6 px-4">
                Prêt à expédier vos marchandises ?
            </h2>
            
            <p class="text-base sm:text-lg lg:text-xl text-slate-400 mb-6 sm:mb-10 max-w-2xl mx-auto px-4">
                Rejoignez la communauté WasselM3ak et découvrez une nouvelle façon de transporter vos marchandises, plus simple et plus économique.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <button @click="$dispatch('open-register')"
                        class="inline-flex items-center justify-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base lg:text-lg font-semibold rounded-lg sm:rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 transition-all active:scale-95">
                    Créer un compte gratuit
                    <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </button>
                <a href="#how-it-works"
                   class="inline-flex items-center justify-center gap-2 border-2 border-slate-600 text-white hover:border-primary-500 hover:text-primary-400 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base lg:text-lg font-semibold rounded-lg sm:rounded-xl transition-all active:scale-95">
                    En savoir plus
                </a>
            </div>
            
            <div class="mt-8 sm:mt-12 flex flex-wrap justify-center gap-6 sm:gap-8 px-4">
                <div class="text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">Gratuit</p>
                    <p class="text-xs sm:text-sm text-slate-500">Inscription</p>
                </div>
                <div class="text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">2 min</p>
                    <p class="text-xs sm:text-sm text-slate-500">Pour s'inscrire</p>
                </div>
                <div class="text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">24/7</p>
                    <p class="text-xs sm:text-sm text-slate-500">Support client</p>
                </div>
            </div>
        </div>
    </div>
</section>