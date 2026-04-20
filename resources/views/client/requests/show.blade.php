@extends('layouts.dashboard')

@section('title', 'Détails de la demande - ' . $demande->reference)

@section('sidebar')
    @include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('content')
    <div class="space-y-6">

        {{-- HEADER AVEC RETOUR INTELLIGENT --}}
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    @php
                        $statusConfig = [
                            'pending' => ['color' => 'amber', 'text' => 'En attente', 'icon' => 'clock'],
                            'in_progress' => ['color' => 'sky', 'text' => 'En cours', 'icon' => 'truck'],
                            'delivered' => ['color' => 'emerald', 'text' => 'Livrée', 'icon' => 'check-circle'],
                            'cancelled' => ['color' => 'red', 'text' => 'Annulée', 'icon' => 'x-circle'],
                        ];
                        $status = $statusConfig[$demande->status] ?? [
                            'color' => 'slate',
                            'text' => ucfirst($demande->status),
                            'icon' => 'circle',
                        ];
                    @endphp
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-700">
                        <i data-lucide="{{ $status['icon'] }}" class="w-3.5 h-3.5"></i>
                        {{ $status['text'] }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $demande->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3 flex-wrap">
                    {{ $demande->ville_depart }}
                    <i data-lucide="arrow-right" class="w-6 h-6 text-primary-500"></i>
                    {{ $demande->ville_arrive }}
                </h1>
                <div class="flex items-center gap-2 mt-2">
                    <i data-lucide="hash" class="w-4 h-4 text-slate-400"></i>
                    <p class="text-slate-500 font-mono text-sm">{{ $demande->reference }}</p>
                    <button onclick="copyToClipboard('{{ $demande->reference }}')"
                        class="text-slate-400 hover:text-primary-500 transition-colors">
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>

            {{-- Bouton retour intelligent --}}
            <a href="{{ route('client.index', request()->except(['from', 'page'])) }}"
                class="inline-flex items-center gap-2 px-5 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 font-medium text-slate-700">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Retour à mes demandes
                @if (request('page'))
                    <span class="ml-1 text-xs text-slate-400">(Page {{ request('page') }})</span>
                @endif
            </a>
        </div>

        {{-- ALERTE SI DEMANDE EN ATTENTE --}}
        @if ($demande->status === 'pending')
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-amber-800 font-medium">Votre demande est en attente de chauffeurs</p>
                    <p class="text-amber-700 text-sm mt-1">Vous recevrez une notification dès qu'un chauffeur fera une
                        offre.</p>
                </div>
            </div>
        @endif

        {{-- SECTION IMAGE MARCHANDISE AMÉLIORÉE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            {{-- En-tête de la section image --}}
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex justify-between items-center">
                <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="image" class="w-5 h-5 text-primary-500"></i>
                    Photo de la marchandise
                </h3>
                @if ($demande->image_marchandise)
                    <button onclick="openImageModal('{{ asset('storage/' . $demande->image_marchandise) }}')"
                        class="text-sm text-primary-500 hover:text-primary-600 flex items-center gap-1 transition-colors">
                        <i data-lucide="maximize-2" class="w-4 h-4"></i>
                        Agrandir
                    </button>
                @endif
            </div>

            {{-- Contenu image --}}
            <div class="p-6">
                @if ($demande->image_marchandise)
                    <div class="relative group">
                        {{-- Image principale --}}
                        <div class="overflow-hidden rounded-xl bg-slate-100 cursor-pointer"
                            onclick="openImageModal('{{ asset('storage/' . $demande->image_marchandise) }}')">
                            <img src="{{ asset('storage/' . $demande->image_marchandise) }}"
                                alt="Photo de la marchandise - {{ $demande->type_marchendise }}"
                                class="w-full h-auto max-h-96 object-contain transition-transform duration-500 group-hover:scale-105">
                        </div>

                        {{-- Overlay au hover --}}
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl flex items-center justify-center">
                            <button onclick="openImageModal('{{ asset('storage/' . $demande->image_marchandise) }}')"
                                class="bg-white text-slate-900 px-4 py-2 rounded-lg flex items-center gap-2 transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                <i data-lucide="search" class="w-5 h-5"></i>
                                Voir en grand
                            </button>
                        </div>

                        {{-- Badge info image --}}
                        <div
                            class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-lg flex items-center gap-1">
                            <i data-lucide="camera" class="w-3 h-3"></i>
                            <span>Cliquez pour agrandir</span>
                        </div>
                    </div>

                    {{-- Métadonnées image --}}
                    <div
                        class="mt-4 flex items-center justify-between text-xs text-slate-500 border-t border-slate-100 pt-4">
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-1">
                                <i data-lucide="file-image" class="w-3.5 h-3.5"></i>
                                Format: {{ pathinfo($demande->image_marchandise, PATHINFO_EXTENSION) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                Ajoutée le {{ $demande->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <button onclick="copyImageLink('{{ asset('storage/' . $demande->image_marchandise) }}')"
                            class="text-primary-500 hover:text-primary-600 flex items-center gap-1 transition-colors">
                            <i data-lucide="link" class="w-3.5 h-3.5"></i>
                            Copier le lien
                        </button>
                    </div>
                @else
                    {{-- Fallback quand aucune image --}}
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-slate-100 rounded-full mb-4">
                            <i data-lucide="package" class="w-12 h-12 text-slate-400"></i>
                        </div>
                        <h4 class="font-medium text-slate-700 mb-1">Aucune photo disponible</h4>
                        <p class="text-sm text-slate-500">Aucune image n'a été ajoutée pour cette marchandise</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- MODAL POUR AGRANDIR L'IMAGE --}}
        <div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4"
            onclick="closeImageModal()">
            <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
                {{-- Bouton fermeture --}}
                <button onclick="closeImageModal()"
                    class="absolute -top-12 right-0 text-white hover:text-slate-300 transition-colors">
                    <i data-lucide="x" class="w-8 h-8"></i>
                </button>

                {{-- Image --}}
                <img id="modalImage" src="" alt="Agrandissement" class="w-full h-auto rounded-xl shadow-2xl">

                {{-- Contrôles --}}
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-3">
                    <button onclick="zoomImage()"
                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                        <i data-lucide="zoom-in" class="w-4 h-4"></i>
                        Zoom
                    </button>
                    <button onclick="downloadImage()"
                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Télécharger
                    </button>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- COLONNE GAUCHE --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- INFORMATIONS DÉTAILLÉES --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i data-lucide="package" class="w-5 h-5 text-primary-500"></i>
                            Informations de la marchandise
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Type de
                                        marchandise</p>
                                    <p class="mt-1 font-medium text-slate-900">{{ $demande->type_marchendise }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Poids</p>
                                    <p class="mt-1 font-medium text-slate-900">{{ $demande->poids_kg }} kg</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Prix estimé
                                    </p>
                                    <p class="mt-1 text-2xl font-bold text-primary-600">
                                        {{ number_format($demande->prix_estime, 0, ',', ' ') }} DH</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Date de
                                        création</p>
                                    <p class="mt-1 text-slate-900">{{ $demande->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPTION --}}
                @if ($demande->description)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                            <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                                <i data-lucide="file-text" class="w-5 h-5 text-primary-500"></i>
                                Description
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-slate-600 leading-relaxed">{{ $demande->description }}</p>
                        </div>
                    </div>
                @endif

                {{-- OFFRES --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i data-lucide="gavel" class="w-5 h-5 text-primary-500"></i>
                            Offres reçues ({{ $demande->offres->count() }})
                        </h3>
                        @if ($demande->offres->count() > 0)
                            <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-full font-medium">
                                Meilleure offre: {{ number_format($demande->offres->min('montant_propose'), 0, ',', ' ') }}
                                DH
                            </span>
                        @endif
                    </div>
                    <div class="p-6">
                        {{-- {{dd($offres)}} --}}
                        @forelse($offres as $offre)
                            <div
                                class="border border-slate-200 rounded-xl p-5 mb-4 last:mb-0 hover:shadow-md transition-shadow">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    {{-- CHAUFFEUR --}}
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 text-white flex items-center justify-center rounded-full font-bold text-lg shadow-md">
                                            {{ strtoupper(substr($offre->chauffeur->user->prenom ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">
                                                {{ $offre->chauffeur->user->prenom ?? 'Chauffeur' }}
                                                {{ $offre->chauffeur->user->nom ?? '' }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                                    <i data-lucide="truck" class="w-3 h-3"></i>
                                                    {{ $offre->chauffeur->total_livraisons ?? 0 }} livraisons
                                                </span>
                                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                                    <i data-lucide="star" class="w-3 h-3 text-amber-500"></i>
                                                    {{ number_format($offre->chauffeur->note_moyenne ?? 0, 1) }}/5
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PRIX & ACTION --}}
                                    <div class="flex items-center gap-6">
                                        <div class="text-right">
                                            <p class="text-xs text-slate-500">Montant proposé</p>
                                            <p class="text-2xl font-bold text-primary-600">
                                                {{ number_format($offre->montant_propose, 0, ',', ' ') }} DH
                                            </p>
                                        </div>
                                
                                        {{-- {{ dd($demande->status) }} --}}
                                        @if ($demande->status === 'pending')
                                            <div class="flex items-center gap-2">
                                                <form method="POST"
                                                    action="{{ route('client.offre.accepte', $offre->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl transition-all duration-200 shadow-md hover:shadow-lg text-sm font-medium whitespace-nowrap">
                                                        <i data-lucide="check-circle" class="w-4 h-4 inline mr-1"></i>
                                                        Accepter
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($offre->status === 'acceptee')
                                            <form method="POST" action="{{ route('client.offre.refuse', $offre->id) }}"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette offre ?');">
                                                @csrf
                                                <button type="submit"
                                                    class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl transition-all duration-200 shadow-md hover:shadow-lg text-sm font-medium whitespace-nowrap">
                                                    <i data-lucide="x-circle" class="w-4 h-4 inline mr-1"></i>
                                                    Refuser
                                                </button>
                                            </form>
                                            {{-- <span
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-medium">
                                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                Offre acceptée
                                            </span> --}}
                                        @elseif($offre->status === 'refused')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-medium">
                                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                                Offre refusée
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- DÉTAILS DE L'OFFRE --}}
                                @if ($offre->message)
                                    <div class="mt-4 pt-4 border-t border-slate-100">
                                        <p class="text-sm text-slate-600">
                                            <i data-lucide="message-circle"
                                                class="w-3.5 h-3.5 inline mr-1 text-slate-400"></i>
                                            {{ $offre->message }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-full mb-4">
                                    <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <p class="text-slate-500">Aucune offre pour le moment</p>
                                <p class="text-slate-400 text-sm mt-1">Soyez patient, des chauffeurs vont bientôt proposer
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- COLONNE DROITE - RÉSUMÉ --}}
            <div class="space-y-6">
                {{-- CARTE RÉSUMÉ --}}
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 sticky top-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-primary-600"></i>
                        <h4 class="font-semibold text-primary-900">Résumé de la demande</h4>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-primary-200">
                            <span class="text-primary-800">📍 Départ</span>
                            <span class="font-semibold text-primary-900">{{ $demande->ville_depart }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-primary-200">
                            <span class="text-primary-800">🏁 Arrivée</span>
                            <span class="font-semibold text-primary-900">{{ $demande->ville_arrive }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-primary-200">
                            <span class="text-primary-800">📦 Type</span>
                            <span class="font-semibold text-primary-900">{{ $demande->type_marchendise }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-primary-200">
                            <span class="text-primary-800">⚖️ Poids</span>
                            <span class="font-semibold text-primary-900">{{ $demande->poids_kg }} kg</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-primary-200">
                            <span class="text-primary-800">💼 Offres reçues</span>
                            <span class="font-bold text-primary-600 text-lg">{{ $demande->offres->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-primary-800 font-semibold">💰 Meilleur prix</span>
                            <span class="text-xl font-bold text-primary-600">
                                {{ $demande->offres->min('montant_propose') ? number_format($demande->offres->min('montant_propose'), 0, ',', ' ') . ' DH' : '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- ACTION SUPPLEMENTAIRE --}}
                    @if ($demande->status === 'pending')
                        <div class="mt-6 pt-4 border-t border-primary-200">
                            <button onclick="shareRequest()"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-primary-600 rounded-xl transition-all duration-200 text-sm font-medium border border-primary-200">
                                <i data-lucide="share-2" class="w-4 h-4"></i>
                                Partager ma demande
                            </button>
                        </div>
                    @endif
                </div>

                {{-- INFORMATIONS SUPPLEMENTAIRES --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-primary-500"></i>
                        Besoin d'aide ?
                    </h4>
                    <p class="text-sm text-slate-600 mb-3">
                        Une question sur votre demande ? Notre équipe est là pour vous aider.
                    </p>
                    <a href="#"
                        class="text-primary-500 hover:text-primary-600 text-sm font-medium inline-flex items-center gap-1">
                        Contacter le support
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <script>
        let currentImageUrl = '';

        function openImageModal(imageUrl) {
            currentImageUrl = imageUrl;
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modalImg.src = imageUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            lucide.createIcons();
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function zoomImage() {
            const modalImg = document.getElementById('modalImage');
            const currentWidth = modalImg.style.width;
            if (currentWidth === '150%') {
                modalImg.style.width = '100%';
                modalImg.style.cursor = 'zoom-in';
            } else {
                modalImg.style.width = '150%';
                modalImg.style.cursor = 'zoom-out';
            }
        }

        function downloadImage() {
            if (currentImageUrl) {
                const link = document.createElement('a');
                link.href = currentImageUrl;
                link.download = 'marchandise_{{ $demande->reference }}.jpg';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                showToast('Image téléchargée', 'success');
            }
        }

        function copyImageLink(imageUrl) {
            navigator.clipboard.writeText(imageUrl).then(() => {
                showToast('Lien de l\'image copié !', 'success');
            });
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Référence copiée !', 'success');
            });
        }

        function shareRequest() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: 'Demande de transport',
                    text: 'Voici ma demande de transport',
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Lien copié dans le presse-papier !', 'success');
                });
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-5 py-3 rounded-xl shadow-lg text-white z-50 animate-in slide-in-from-right ${
        type === 'success' ? 'bg-emerald-500' : 'bg-red-500'
    }`;
            toast.innerHTML = `
        <div class="flex items-center gap-2">
            <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="w-5 h-5"></i>
            <span>${message}</span>
        </div>
    `;
            document.body.appendChild(toast);
            lucide.createIcons();
            setTimeout(() => toast.remove(), 3000);
        }

        // Fermer la modal avec Echap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    <style>
        @keyframes slide-in-from-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-in {
            animation: slide-in-from-right 0.3s ease-out;
        }

        /* Animation pour la modal */
        #imageModal {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection
