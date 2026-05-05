{{-- sections/object-types.blade.php --}}
<section class="py-12 sm:py-16 lg:py-20 xl:py-28 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16">
            <span class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-100 text-primary-600 rounded-full text-xs sm:text-sm font-medium mb-3 sm:mb-4">
                Tous types de marchandises
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-slate-900 mb-3 sm:mb-4">
                Que souhaitez-vous transporter ?
            </h2>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto px-4">
                De l'encombrant à la palette, nous transportons tous types de marchandises partout au Maroc.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @php
                $objectTypes = [
                    ['name' => 'Meubles', 'icon' => 'sofa', 'color' => 'amber', 'description' => 'Canapés, armoires, tables, chaises...'],
                    ['name' => 'Électroménager', 'icon' => 'refrigerator', 'color' => 'orange', 'description' => 'Frigo, lave-linge, TV, four...'],
                    ['name' => 'Vélos / 2 roues', 'icon' => 'bike', 'color' => 'green', 'description' => 'Vélos, scooters, motos...'],
                    ['name' => 'Cartons', 'icon' => 'box', 'color' => 'orange', 'description' => 'Déménagement, archives...'],
                    ['name' => 'Palettes', 'icon' => 'palette', 'color' => 'rose', 'description' => 'Marchandises en vrac...'],
                    ['name' => 'Divers', 'icon' => 'package', 'color' => 'primary', 'description' => 'Tout type de marchandises...']
                ];
            @endphp
            
            @foreach($objectTypes as $type)
            <div class="group bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 active:scale-98 cursor-pointer touch-manipulation">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-{{ $type['color'] }}-100 text-{{ $type['color'] }}-600 rounded-lg sm:rounded-xl flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="{{ $type['icon'] }}" class="w-6 h-6 sm:w-8 sm:h-8"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-1 sm:mb-2">{{ $type['name'] }}</h3>
                <p class="text-slate-600 text-xs sm:text-sm">{{ $type['description'] }}</p>
                <div class="mt-3 sm:mt-4 flex items-center text-primary-500 text-xs sm:text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                    En savoir plus
                    <i data-lucide="arrow-right" class="w-3 h-3 sm:w-4 sm:h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8 sm:mt-12 text-center">
            <p class="text-slate-500 mb-3 sm:mb-4 text-sm sm:text-base">Vous ne trouvez pas votre type de marchandise ?</p>
            <a href="#" class="inline-flex items-center px-5 sm:px-6 py-2.5 sm:py-3 bg-white border-2 border-slate-200 rounded-xl text-slate-700 font-medium text-sm sm:text-base hover:border-primary-500 hover:text-primary-500 transition-colors active:scale-95">
                Contactez-nous
                <i data-lucide="mail" class="w-4 h-4 ml-2"></i>
            </a>
        </div>
    </div>
</section>