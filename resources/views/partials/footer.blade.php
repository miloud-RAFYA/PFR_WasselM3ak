<footer class="bg-slate-50 text-slate-700 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="space-y-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-3xl overflow-hidden bg-primary-500 shadow-soft transition-all hover:bg-primary-600">
                        <img src="{{ asset('images/image.png') }}" alt="WasselM3ak" class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <p class="text-xl font-bold tracking-tight text-slate-900">WasselM3ak</p>
                        <p class="text-sm text-slate-500">Transport de marchandises au Maroc</p>
                    </div>
                </a>
                <p class="text-sm leading-7 text-slate-600 max-w-sm">La marketplace logistique qui connecte exp�diteurs et transporteurs fiables avec des devis transparents et un suivi clair.</p>
                <div class="flex items-center gap-3">
                    <a href="#" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-700 shadow-sm hover:bg-primary-500 hover:text-white transition">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 mb-6">Exp�diteurs</h3>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li><a href="#how-it-works" class="hover:text-primary-600 transition">Comment �a marche</a></li>
                    <li><a href="#object-types" class="hover:text-primary-600 transition">Types d'envois</a></li>
                    <li><a href="#faq" class="hover:text-primary-600 transition">FAQ</a></li>
                    <li><a href="#testimonials" class="hover:text-primary-600 transition">Avis clients</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 mb-6">Transporteurs</h3>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li><a href="#features-driver" class="hover:text-primary-600 transition">Devenir transporteur</a></li>
                    <li><a href="#features-driver" class="hover:text-primary-600 transition">Avantages</a></li>
                    <li><a href="#testimonials" class="hover:text-primary-600 transition">T�moignages</a></li>
                    <li><a href="#" class="hover:text-primary-600 transition">Support</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 mb-6">Contact</h3>
                <div class="space-y-4 text-sm text-slate-600">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-primary-500"></i>
                        <a href="mailto:contact@wasselm3ak.ma" class="hover:text-primary-600 transition">contact@wasselm3ak.ma</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-primary-500"></i>
                        <a href="tel:+212522123456" class="hover:text-primary-600 transition">+212 524 000 000</a>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-map-pin text-primary-500 mt-1 shrink-0"></i>
                        <p>Quartier Industriel, Marrakech, Maroc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
            <p>� {{ date('Y') }} WasselM3ak. Tous droits r�serv�s.</p>
            <div class="flex flex-wrap gap-6">
                <a href="#" class="hover:text-primary-600 transition">CGU</a>
                <a href="#" class="hover:text-primary-600 transition">Confidentialit�</a>
                <a href="#" class="hover:text-primary-600 transition">Cookies</a>
            </div>
        </div>
    </div>
</footer>
