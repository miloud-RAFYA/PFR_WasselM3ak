<section id="faq" class="py-20 lg:py-28 bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-medium mb-4">
                FAQ
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-4">
                Questions fréquentes
            </h2>
            <p class="text-lg text-slate-600">
                Trouvez les réponses aux questions les plus courantes
            </p>
        </div>

        <!-- FAQ List -->
        <div class="space-y-4" x-data="{ openIndex: null }">
            <!-- Question 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <button
                    @click="openIndex = openIndex === 1 ? null : 1"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
                >
                    <span class="font-semibold text-slate-900 pr-4">Comment fonctionne WasselM3ak ?</span>
                    <i 
                        data-lucide="chevron-down" 
                        class="w-5 h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                        :class="openIndex === 1 ? 'rotate-180' : ''"
                    ></i>
                </button>
                <div 
                    class="overflow-hidden transition-all duration-300"
                    :style="openIndex === 1 ? 'max-height: 500px' : 'max-height: 0'"
                >
                    <div class="px-5 pb-5 text-slate-600 leading-relaxed">
                        WasselM3ak est une plateforme de mise en relation entre expéditeurs et transporteurs. Vous publiez votre demande de transport, les transporteurs vous font des propositions, et vous choisissez celle qui vous convient le mieux. Le paiement est sécurisé et le transporteur n'est payé qu'après la livraison.
                    </div>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <button
                    @click="openIndex = openIndex === 2 ? null : 2"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
                >
                    <span class="font-semibold text-slate-900 pr-4">Mes marchandises sont-elles assurées ?</span>
                    <i 
                        data-lucide="chevron-down" 
                        class="w-5 h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                        :class="openIndex === 2 ? 'rotate-180' : ''"
                    ></i>
                </button>
                <div 
                    class="overflow-hidden transition-all duration-300"
                    :style="openIndex === 2 ? 'max-height: 500px' : 'max-height: 0'"
                >
                    <div class="px-5 pb-5 text-slate-600 leading-relaxed">
                        Oui, tous les envois effectués via WasselM3ak sont automatiquement assurés contre le vol et la casse pendant le transport. Cette assurance est incluse dans le prix de la prestation sans frais supplémentaires.
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <button
                    @click="openIndex = openIndex === 3 ? null : 3"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
                >
                    <span class="font-semibold text-slate-900 pr-4">Comment sont vérifiés les transporteurs ?</span>
                    <i 
                        data-lucide="chevron-down" 
                        class="w-5 h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                        :class="openIndex === 3 ? 'rotate-180' : ''"
                    ></i>
                </button>
                <div 
                    class="overflow-hidden transition-all duration-300"
                    :style="openIndex === 3 ? 'max-height: 500px' : 'max-height: 0'"
                >
                    <div class="px-5 pb-5 text-slate-600 leading-relaxed">
                        Tous nos transporteurs passent par un processus de vérification rigoureux : vérification d'identité, des documents du véhicule, et de l'assurance. De plus, chaque transporteur est noté et évalué par les clients après chaque course.
                    </div>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <button
                    @click="openIndex = openIndex === 4 ? null : 4"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
                >
                    <span class="font-semibold text-slate-900 pr-4">Quels types de marchandises puis-je transporter ?</span>
                    <i 
                        data-lucide="chevron-down" 
                        class="w-5 h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                        :class="openIndex === 4 ? 'rotate-180' : ''"
                    ></i>
                </button>
                <div 
                    class="overflow-hidden transition-all duration-300"
                    :style="openIndex === 4 ? 'max-height: 500px' : 'max-height: 0'"
                >
                    <div class="px-5 pb-5 text-slate-600 leading-relaxed">
                        Vous pouvez transporter pratiquement tout type de marchandises : meubles, électroménager, vélos, cartons de déménagement, palettes, et bien d'autres objets. Les marchandises dangereuses ou illégales sont strictement interdites.
                    </div>
                </div>
            </div>

            <!-- Question 5 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <button
                    @click="openIndex = openIndex === 5 ? null : 5"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
                >
                    <span class="font-semibold text-slate-900 pr-4">Comment se fait le paiement ?</span>
                    <i 
                        data-lucide="chevron-down" 
                        class="w-5 h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                        :class="openIndex === 5 ? 'rotate-180' : ''"
                    ></i>
                </button>
                <div 
                    class="overflow-hidden transition-all duration-300"
                    :style="openIndex === 5 ? 'max-height: 500px' : 'max-height: 0'"
                >
                    <div class="px-5 pb-5 text-slate-600 leading-relaxed">
                        Le paiement s'effectue en ligne de manière sécurisée par carte bancaire ou virement. Votre paiement est conservé en sécurité et n'est versé au transporteur qu'une fois la livraison confirmée. En cas de problème, nous garantissons un remboursement.
                    </div>
                </div>
            </div>

            <!-- Question 6 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <button
                    @click="openIndex = openIndex === 6 ? null : 6"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
                >
                    <span class="font-semibold text-slate-900 pr-4">Puis-je annuler ma demande ?</span>
                    <i 
                        data-lucide="chevron-down" 
                        class="w-5 h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                        :class="openIndex === 6 ? 'rotate-180' : ''"
                    ></i>
                </button>
                <div 
                    class="overflow-hidden transition-all duration-300"
                    :style="openIndex === 6 ? 'max-height: 500px' : 'max-height: 0'"
                >
                    <div class="px-5 pb-5 text-slate-600 leading-relaxed">
                        Oui, vous pouvez annuler votre demande gratuitement tant qu'aucun transporteur n'a accepté la course. Si un transporteur a déjà accepté, l'annulation peut être soumise à des conditions selon l'avancement de la prestation.
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="mt-12 text-center">
            <p class="text-slate-500 mb-4">Vous ne trouvez pas la réponse à votre question ?</p>
            <a href="" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">
                {{-- {{ route('contact') }} --}}
                Contactez-nous
            </a>
        </div>
    </div>
</section>
