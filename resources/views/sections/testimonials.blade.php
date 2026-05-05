{{-- sections/testimonials.blade.php --}}
<section id="testimonials" class="py-12 sm:py-16 lg:py-20 xl:py-28 bg-gradient-to-br from-primary-500 to-primary-600 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-full"></div>
        <div class="absolute bottom-20 right-20 w-32 h-32 sm:w-48 sm:h-48 bg-white rounded-full"></div>
        <div class="absolute top-1/2 left-1/3 w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-full"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16">
            <span class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-white/20 text-white rounded-full text-xs sm:text-sm font-medium mb-3 sm:mb-4">
                Témoignages
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 sm:mb-4">
                Ils nous font confiance
            </h2>
            <p class="text-base sm:text-lg text-white/80 max-w-2xl mx-auto px-4">
                +350 000 expéditeurs satisfaits à travers le Maroc
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @php
                $testimonials = [
                    ['initials' => 'AB', 'name' => 'Ahmed Benali', 'role' => 'Particulier', 'text' => "Service excellent ! J'ai pu déménager mes meubles de Casablanca à Rabat pour 3 fois moins cher qu'avec un déménageur traditionnel."],
                    ['initials' => 'SE', 'name' => 'Sofia El Amrani', 'role' => 'Propriétaire de boutique', 'text' => "J'utilise WasselM3ak pour mes livraisons de marchandises depuis 6 mois. Rapide, fiable et économique. Je recommande vivement !"],
                    ['initials' => 'KI', 'name' => 'Karim Idrissi', 'role' => 'Transporteur', 'text' => "En tant que transporteur, cette plateforme m'a permis de rentabiliser mes trajets et de gagner un revenu complémentaire."],
                    ['initials' => 'FZ', 'name' => 'Fatima Zahra', 'role' => 'Particulier', 'text' => "J'ai envoyé un vélo à mon fils à Marrakech. Le prix était imbattable et la livraison s'est faite en 24h. Super expérience !"]
                ];
            @endphp
            
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-xl">
                <i data-lucide="quote" class="w-8 h-8 sm:w-10 sm:h-10 text-primary-200 mb-3 sm:mb-4"></i>
                <div class="flex gap-0.5 sm:gap-1 mb-3 sm:mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <i data-lucide="star" class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400 fill-amber-400"></i>
                    @endfor
                </div>
                <p class="text-slate-700 mb-4 sm:mb-6 leading-relaxed text-sm sm:text-base">{{ $testimonial['text'] }}</p>
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-500 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                        {{ $testimonial['initials'] }}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 text-sm sm:text-base">{{ $testimonial['name'] }}</p>
                        <p class="text-xs sm:text-sm text-slate-500">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>