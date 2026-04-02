<section id="cta" class="py-20 lg:py-28 bg-slate-900 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse" style="animation-duration: 10s; animation-delay: 2s;"></div>
    </div>

    <!-- Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500/20 text-primary-400 rounded-full text-sm font-medium mb-6">
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                Rejoignez-nous dès maintenant
            </div>

            <!-- Title -->
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                Prêt à expédier vos marchandises ?
            </h2>

            <!-- Description -->
            <p class="text-lg sm:text-xl text-slate-400 mb-10 max-w-2xl mx-auto">
                Rejoignez la communauté WasselM3ak et découvrez une nouvelle façon de transporter vos marchandises, plus simple et plus économique.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button 
                    @click="$dispatch('open-register')"
                    class="inline-flex items-center justify-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 text-lg font-semibold rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5"
                >
                    Créer un compte gratuit
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
                <a 
                    href="#how-it-works"
                    class="inline-flex items-center justify-center gap-2 border-2 border-slate-600 text-white hover:border-primary-500 hover:text-primary-400 px-8 py-4 text-lg font-semibold rounded-xl transition-all hover:-translate-y-0.5"
                >
                    En savoir plus
                </a>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-12 flex flex-wrap justify-center gap-8">
                <div class="text-center">
                    <p class="text-2xl font-bold text-white">Gratuit</p>
                    <p class="text-sm text-slate-500">Inscription</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-white">2 min</p>
                    <p class="text-sm text-slate-500">Pour s'inscrire</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-white">24/7</p>
                    <p class="text-sm text-slate-500">Support client</p>
                </div>
            </div>
        </div>
    </div>
</section>
