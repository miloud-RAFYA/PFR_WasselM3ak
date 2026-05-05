{{-- sections/faq.blade.php --}}
<section id="faq" class="py-12 sm:py-16 lg:py-20 xl:py-28 bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
            <span class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-100 text-primary-600 rounded-full text-xs sm:text-sm font-medium mb-3 sm:mb-4">
                FAQ
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-slate-900 mb-3 sm:mb-4">
                Questions fréquentes
            </h2>
            <p class="text-base sm:text-lg text-slate-600 px-4">
                Trouvez les réponses aux questions les plus courantes
            </p>
        </div>
        
        <div class="space-y-3 sm:space-y-4" x-data="{ openIndex: null }">
            @php
                $faqs = [
                    ['q' => 'Comment fonctionne WasselM3ak ?', 'a' => "WasselM3ak est une plateforme de mise en relation entre expéditeurs et transporteurs. Vous publiez votre demande de transport, les transporteurs vous font des propositions, et vous choisissez celle qui vous convient le mieux. Le paiement est sécurisé et le transporteur n'est payé qu'après la livraison."],
                    ['q' => 'Mes marchandises sont-elles assurées ?', 'a' => "Oui, tous les envois effectués via WasselM3ak sont automatiquement assurés contre le vol et la casse pendant le transport. Cette assurance est incluse dans le prix de la prestation sans frais supplémentaires."],
                    ['q' => 'Comment sont vérifiés les transporteurs ?', 'a' => "Tous nos transporteurs passent par un processus de vérification rigoureux : vérification d'identité, des documents du véhicule, et de l'assurance. De plus, chaque transporteur est noté et évalué par les clients après chaque course."],
                    ['q' => 'Quels types de marchandises puis-je transporter ?', 'a' => "Vous pouvez transporter pratiquement tout type de marchandises : meubles, électroménager, vélos, cartons de déménagement, palettes, et bien d'autres objets. Les marchandises dangereuses ou illégales sont strictement interdites."],
                    ['q' => 'Comment se fait le paiement ?', 'a' => "Le paiement s'effectue en ligne de manière sécurisée par carte bancaire ou virement. Votre paiement est conservé en sécurité et n'est versé au transporteur qu'une fois la livraison confirmée. En cas de problème, nous garantissons un remboursement."],
                    ['q' => 'Puis-je annuler ma demande ?', 'a' => "Oui, vous pouvez annuler votre demande gratuitement tant qu'aucun transporteur n'a accepté la course. Si un transporteur a déjà accepté, l'annulation peut être soumise à des conditions selon l'avancement de la prestation."]
                ];
            @endphp
            
            @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-lg sm:rounded-xl overflow-hidden shadow-sm">
                <button @click="openIndex = openIndex === {{ $index + 1 }} ? null : {{ $index + 1 }}"
                        class="w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-slate-50 transition-colors active:bg-slate-50 touch-manipulation">
                    <span class="font-semibold text-slate-900 pr-4 text-sm sm:text-base">{{ $faq['q'] }}</span>
                    <i data-lucide="chevron-down" 
                       class="w-4 h-4 sm:w-5 sm:h-5 text-slate-500 flex-shrink-0 transition-transform duration-300"
                       :class="openIndex === {{ $index + 1 }} ? 'rotate-180' : ''"></i>
                </button>
                <div class="overflow-hidden transition-all duration-300"
                     :style="openIndex === {{ $index + 1 }} ? 'max-height: 500px' : 'max-height: 0'">
                    <div class="px-4 pb-4 sm:px-5 sm:pb-5 text-slate-600 leading-relaxed text-sm sm:text-base">
                        {{ $faq['a'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8 sm:mt-12 text-center">
            <p class="text-slate-500 mb-3 sm:mb-4 text-sm sm:text-base">Vous ne trouvez pas la réponse à votre question ?</p>
            <a href="#" class="inline-flex items-center px-5 sm:px-6 py-2.5 sm:py-3 bg-primary-500 text-white rounded-lg sm:rounded-xl font-medium text-sm sm:text-base hover:bg-primary-600 transition-colors active:scale-95">
                Contactez-nous
                <i data-lucide="mail" class="w-4 h-4 ml-2"></i>
            </a>
        </div>
    </div>
</section>