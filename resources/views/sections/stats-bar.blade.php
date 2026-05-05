{{-- sections/stats-bar.blade.php --}}
<section class="bg-slate-900 py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
            <div class="flex flex-col sm:flex-row items-center justify-center text-center sm:text-left gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-500/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6 text-primary-500"></i>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['transporteurs_verifies'] ?? 0) }}</p>
                    <p class="text-xs sm:text-sm text-slate-400">Transporteurs vérifiés</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center text-center sm:text-left gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-500/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="package" class="w-5 h-5 sm:w-6 sm:h-6 text-primary-500"></i>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['expeditions_realisees'] ?? 0) }}</p>
                    <p class="text-xs sm:text-sm text-slate-400">Expéditions réalisées</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center text-center sm:text-left gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-500/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="thumbs-up" class="w-5 h-5 sm:w-6 sm:h-6 text-primary-500"></i>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['total_users'] ?? 0) }}</p>
                    <p class="text-xs sm:text-sm text-slate-400">Utilisateurs actifs</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center text-center sm:text-left gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-500/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="trending-down" class="w-5 h-5 sm:w-6 sm:h-6 text-primary-500"></i>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['demandes_en_cours'] ?? 0) }}</p>
                    <p class="text-xs sm:text-sm text-slate-400">Expéditions en cours</p>
                </div>
            </div>
        </div>
    </div>
</section>