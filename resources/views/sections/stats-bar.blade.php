<section class="bg-slate-900 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-primary-500"></i>
                </div>
                <div class="text-left">
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ number_format($stats['transporteurs_verifies'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Transporteurs vérifiés</p>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6 text-primary-500"></i>
                </div>
                <div class="text-left">
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ number_format($stats['expeditions_realisees'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Expéditions réalisées</p>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center">
                    <i data-lucide="thumbs-up" class="w-6 h-6 text-primary-500"></i>
                </div>
                <div class="text-left">
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ number_format($stats['total_users'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Utilisateurs actifs</p>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center">
                    <i data-lucide="trending-down" class="w-6 h-6 text-primary-500"></i>
                </div>
                <div class="text-left">
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ number_format($stats['demandes_en_cours'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Expéditions en cours</p>
                </div>
            </div>
        </div>
    </div>
</section>
