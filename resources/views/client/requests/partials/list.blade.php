@if($demandes->count())
<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
    @foreach($demandes as $demande)
    @php
        if ($demande->image_marchandise) {
            $imageUrl = asset('storage/' . $demande->image_marchandise);
        } else {
            $type = strtolower($demande->type_marchendise);
            if (str_contains($type, 'frais') || str_contains($type, 'alimentaire')) {
                $imageUrl = asset('images/image.png');
            } elseif (str_contains($type, 'électronique') || str_contains($type, 'electronique') || str_contains($type, 'tech')) {
                $imageUrl = asset('images/packages.png');
            } else {
                $imageUrl = asset('images/packages.png');
            }
        }
    @endphp
    <div class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
        <div class="relative h-56 overflow-hidden">
            <img src="{{ $imageUrl }}" alt="Image de {{ $demande->type_marchendise }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
            <div class="absolute inset-x-0 top-0 flex items-center justify-between px-5 py-4">
                <span class="rounded-full bg-primary-500/90 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-white">Marchandise</span>
                <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-800">{{ $demande->poids_kg }} kg</span>
            </div>
            <div class="absolute left-5 bottom-5 text-white">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-200/90">{{ $demande->type_marchendise }}</p>
                <h3 class="text-3xl font-semibold tracking-tight">{{ $demande->ville_depart }} → {{ $demande->ville_arrive }}</h3>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Référence</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $demande->reference }}</p>
                </div>
                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] {{ $demande->status === 'delivered' ? 'bg-emerald-500 text-white' : ($demande->status === 'in_progress' ? 'bg-sky-500 text-white' : ($demande->status === 'pending' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-700')) }}">
                    {{ $demande->status === 'delivered' ? 'Livrée' : ($demande->status === 'in_progress' ? 'En cours' : ($demande->status === 'pending' ? 'En attente' : ucfirst(str_replace('_', ' ', $demande->status)))) }}
                </span>
            </div>

            <div class="grid gap-4 sm:grid-cols-3 text-sm text-slate-600">
                <div class="rounded-[1.5rem] bg-slate-50 p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Montant</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $demande->prix_final ?? $demande->prix_estime }} DH</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Créé le</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $demande->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Offres</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $demande->offres->count() }}</p>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Destination</p>
                <p class="font-medium text-slate-700">{{ $demande->ville_arrive }}</p>
            </div>
            <a href="{{ route('client.requests.show', $demande) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-primary-500 hover:text-white">
                Voir
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $demandes->links() }}
</div>
@else
<div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-full mb-4">
        <i data-lucide="package" class="w-8 h-8 text-slate-400"></i>
    </div>
    <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $emptyTitle ?? 'Aucune demande trouvée' }}</h3>
    <p class="text-slate-500 mb-6">{{ $emptyText ?? 'Aucune demande ne correspond à ce filtre.' }}</p>
    <a href="{{ route('client.requests') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Voir toutes les demandes
    </a>
</div>
@endif
