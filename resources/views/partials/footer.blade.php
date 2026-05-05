{{-- partials/footer.blade.php --}}
<footer class="bg-slate-50 text-slate-700 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12 lg:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10">
            <!-- Brand Column -->
            <div class="space-y-4 sm:space-y-6 text-center sm:text-left">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center sm:justify-start gap-2 sm:gap-3 group">
                    <div class="h-12 w-12 sm:h-14 sm:w-14 transition-all duration-300 group-hover:scale-105">
                        <img src="{{ asset('images/Gemini_Generated_Image_cxfmz7cxfmz7cxfm-removebg-preview.png') }}" 
                             alt="WasselM3ak"
                             class="w-full h-full object-contain" />
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tighter uppercase">
                            <span class="text-primary-500">Wassel</span><span class="text-gray-800">m3ak</span>
                        </h1>
                    </div>
                </a>
                <p class="text-xs sm:text-sm leading-6 sm:leading-7 text-slate-600 max-w-sm mx-auto sm:mx-0">
                    La marketplace logistique qui connecte expéditeurs et transporteurs fiables avec des devis transparents et un suivi clair.
                </p>
                <div class="flex items-center justify-center sm:justify-start gap-2 sm:gap-3">
                    <a href="#" class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-lg sm:rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition active:scale-95">
                        <i class="fa-brands fa-facebook-f text-sm sm:text-base"></i>
                    </a>
                    <a href="#" class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-lg sm:rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition active:scale-95">
                        <i class="fa-brands fa-instagram text-sm sm:text-base"></i>
                    </a>
                    <a href="#" class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-lg sm:rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition active:scale-95">
                        <i class="fa-brands fa-linkedin-in text-sm sm:text-base"></i>
                    </a>
                    <a href="#" class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-lg sm:rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition active:scale-95">
                        <i class="fa-brands fa-x-twitter text-sm sm:text-base"></i>
                    </a>
                </div>
            </div>
            
            <!-- Expéditeurs Column -->
            <div class="text-center sm:text-left">
                <h3 class="text-xs sm:text-sm font-semibold uppercase tracking-[0.25em] text-primary-500 mb-4 sm:mb-6">Expéditeurs</h3>
                <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-slate-600">
                    <li><a href="#how-it-works" class="hover:text-primary-500 transition">Comment ça marche</a></li>
                    <li><a href="#object-types" class="hover:text-primary-500 transition">Types d'envois</a></li>
                    <li><a href="#faq" class="hover:text-primary-500 transition">FAQ</a></li>
                    <li><a href="#testimonials" class="hover:text-primary-500 transition">Avis clients</a></li>
                </ul>
            </div>
            
            <!-- Transporteurs Column -->
            <div class="text-center sm:text-left">
                <h3 class="text-xs sm:text-sm font-semibold uppercase tracking-[0.25em] text-primary-500 mb-4 sm:mb-6">Transporteurs</h3>
                <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-slate-600">
                    <li><a href="#features-driver" class="hover:text-primary-500 transition">Devenir transporteur</a></li>
                    <li><a href="#features-driver" class="hover:text-primary-500 transition">Avantages</a></li>
                    <li><a href="#testimonials" class="hover:text-primary-500 transition">Témoignages</a></li>
                    <li><a href="#" class="hover:text-primary-500 transition">Support</a></li>
                </ul>
            </div>
            
            <!-- Contact Column -->
            <div class="text-center sm:text-left">
                <h3 class="text-xs sm:text-sm font-semibold uppercase tracking-[0.25em] text-primary-500 mb-4 sm:mb-6">Contact</h3>
                <div class="space-y-3 sm:space-y-4 text-xs sm:text-sm text-slate-600">
                    <div class="flex items-center justify-center sm:justify-start gap-2 sm:gap-3">
                        <i class="fa-solid fa-envelope text-primary-500 text-sm sm:text-base"></i>
                        <a href="mailto:contact@wasselm3ak.ma" class="hover:text-primary-500 transition break-all">contact@wasselm3ak.ma</a>
                    </div>
                    <div class="flex items-center justify-center sm:justify-start gap-2 sm:gap-3">
                        <i class="fa-solid fa-phone text-primary-500 text-sm sm:text-base"></i>
                        <a href="tel:+212522123456" class="hover:text-primary-500 transition">+212 524 000 000</a>
                    </div>
                    <div class="flex items-start justify-center sm:justify-start gap-2 sm:gap-3">
                        <i class="fa-solid fa-map-pin text-primary-500 mt-0.5 sm:mt-1 shrink-0 text-sm sm:text-base"></i>
                        <p class="text-xs sm:text-sm">Quartier Industriel, Marrakech, Maroc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom Bar -->
    <div class="border-t border-slate-200 bg-slate-50 safe-bottom">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-4 text-xs sm:text-sm text-slate-500">
            <p class="text-center sm:text-left">© {{ date('Y') }} WasselM3ak. Tous droits réservés.</p>
            <div class="flex flex-wrap justify-center gap-4 sm:gap-6">
                <a href="#" class="hover:text-primary-500 transition">CGU</a>
                <a href="#" class="hover:text-primary-500 transition">Confidentialité</a>
                <a href="#" class="hover:text-primary-500 transition">Cookies</a>
                <a href="#" class="hover:text-primary-500 transition">Mentions légales</a>
            </div>
        </div>
    </div>
</footer>