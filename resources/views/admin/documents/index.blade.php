@extends('layouts.dashboard')

@section('title', 'Documents - WasselM3ak')

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'documents'])
@endsection

@section('page-title', 'Gestion des Documents')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Documents</h2>
                <p class="text-slate-500">Gérez les documents KYC des chauffeurs</p>
            </div>
            
            {{-- Filtres --}}
            <form method="GET" class="flex gap-3">
                <select name="status" onchange="this.form.submit()" 
                    class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="approuve" {{ request('status') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                    <option value="rejete" {{ request('status') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                </select>
                
                <select name="type" onchange="this.form.submit()"
                    class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                    <option value="">Tous les types</option>
                    <option value="permis" {{ request('type') == 'permis' ? 'selected' : '' }}>Permis</option>
                    <option value="carte_grise" {{ request('type') == 'carte_grise' ? 'selected' : '' }}>Carte Grise</option>
                    <option value="assurance" {{ request('type') == 'assurance' ? 'selected' : '' }}>Assurance</option>
                </select>
            </form>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Documents Grid --}}
        @if ($documents->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="folder-open" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                <p class="text-slate-500">Aucun document trouvé</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($documents as $document)
                    @php
                        $fileUrl = asset('storage/' . $document->chemin);
                        $fileExists = Storage::disk('public')->exists($document->chemin);
                        $extension = strtolower(pathinfo($document->chemin, PATHINFO_EXTENSION));
                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                        $isPdf = $extension === 'pdf';
                    @endphp

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                        {{-- Preview --}}
                        <div class="aspect-video bg-slate-100 relative group">
                            @if ($fileExists)
                                @if ($isImage)
                                    <img src="{{ $fileUrl }}" alt="{{ $document->type }}" 
                                        class="w-full h-full object-cover cursor-pointer"
                                        onclick="openFileModal('{{ $fileUrl }}', 'image')">
                                @elseif ($isPdf)
                                    <div class="w-full h-full flex items-center justify-center cursor-pointer"
                                        onclick="openFileModal('{{ $fileUrl }}', 'pdf')">
                                        <div class="text-center">
                                            <i data-lucide="file-text" class="w-12 h-12 text-red-500 mx-auto"></i>
                                            <p class="text-sm text-slate-600 mt-2">PDF</p>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $fileUrl }}" target="_blank"
                                        class="w-full h-full flex items-center justify-center">
                                        <div class="text-center">
                                            <i data-lucide="file" class="w-12 h-12 text-slate-400 mx-auto"></i>
                                            <p class="text-sm text-slate-600 mt-2">{{ strtoupper($extension) }}</p>
                                        </div>
                                    </a>
                                @endif
                                
                                {{-- Type Badge --}}
                                <span class="absolute top-2 left-2 px-2 py-1 bg-slate-800/70 text-white text-xs rounded-md">
                                    {{ strtoupper($extension) }}
                                </span>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center text-red-500">
                                        <i data-lucide="alert-triangle" class="w-8 h-8 mx-auto"></i>
                                        <p class="text-xs mt-1">Fichier manquant</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-4">
                            {{-- Type & Chauffeur --}}
                            <div class="mb-3">
                                <h3 class="font-semibold text-slate-800 capitalize">
                                    {{ str_replace('_', ' ', $document->type) }}
                                </h3>
                                <p class="text-sm text-slate-500">
                                    {{ $document->chauffeur?->user?->nom ?? 'N/A' }}
                                </p>
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                @php
                                    $statusConfig = [
                                        'en_attente' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'En attente'],
                                        'approuve' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Approuvé'],
                                        'rejete' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Rejeté'],
                                    ];
                                    $status = $statusConfig[$document->status] ?? $statusConfig['en_attente'];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                    @if($document->status == 'en_attente')
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                    @elseif($document->status == 'approuve')
                                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    @else
                                        <i data-lucide="x-circle" class="w-3 h-3"></i>
                                    @endif
                                    {{ $status['label'] }}
                                </span>
                            </div>

                            {{-- Actions --}}
                            <div class="grid grid-cols-2 gap-2">
                                @if ($document->status !== 'approuve')
                                    <form action="{{ route('admin.documents.verify', $document) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="w-full px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-500 hover:text-white transition text-sm font-medium flex items-center justify-center gap-1">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                            Valider
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm font-medium flex items-center justify-center gap-1 opacity-50 cursor-not-allowed">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                        Validé
                                    </button>
                                @endif

                                @if ($document->status !== 'rejete')
                                    <button onclick="openRejectModal('{{ route('admin.documents.verify', $document) }}')"
                                        class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-500 hover:text-white transition text-sm font-medium flex items-center justify-center gap-1">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                        Rejeter
                                    </button>
                                @else
                                    <button disabled class="px-3 py-2 bg-red-500 text-white rounded-lg text-sm font-medium flex items-center justify-center gap-1 opacity-50 cursor-not-allowed">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                        Rejeté
                                    </button>
                                @endif
                            </div>

                            {{-- Download Button --}}
                            @if ($fileExists)
                                <a href="{{ $fileUrl }}" download 
                                    class="mt-2 w-full px-3 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition text-sm font-medium flex items-center justify-center gap-1">
                                    <i data-lucide="download" class="w-4 h-4"></i>
                                    Télécharger
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $documents->links() }}
            </div>
        @endif
    </div>

    {{-- File Preview Modal --}}
    <div id="fileModal" class="fixed inset-0 bg-black/80 hidden z-50" onclick="closeFileModal(event)">
        <div class="absolute inset-0 flex items-center justify-center p-4" onclick="event.stopPropagation()">
            <div class="bg-white rounded-xl max-w-5xl w-full max-h-[90vh] overflow-hidden relative">
                {{-- Close Button --}}
                <button onclick="closeFileModal()" 
                    class="absolute top-3 right-3 z-10 w-10 h-10 bg-slate-800/70 hover:bg-slate-900 text-white rounded-full flex items-center justify-center transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

                {{-- Content --}}
                <div id="fileModalContent" class="w-full h-[90vh] flex items-center justify-center bg-slate-100">
                    {{-- Content injected via JS --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="fixed inset-0 bg-black/80 hidden z-50" onclick="closeRejectModal(event)">
        <div class="absolute inset-0 flex items-center justify-center p-4" onclick="event.stopPropagation()">
            <div class="bg-white rounded-xl max-w-md w-full p-6 relative">
                <button onclick="closeRejectModal()" 
                    class="absolute top-3 right-3 text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

                <h3 class="text-lg font-bold text-slate-800 mb-4">Rejeter le document</h3>
                
                <form id="rejectForm" method="POST">
                    @csrf
                    <input type="hidden" name="reject" value="1">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Motif du rejet <span class="text-red-500">*</span>
                        </label>
                        <textarea name="commentaire" rows="4" required
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none resize-none"
                            placeholder="Expliquez pourquoi ce document est rejeté..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="flex-1 px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                            Confirmer le rejet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // File Modal Functions
    function openFileModal(url, type) {
        const modal = document.getElementById('fileModal');
        const content = document.getElementById('fileModalContent');
        
        if (type === 'image') {
            content.innerHTML = `<img src="${url}" class="max-w-full max-h-full object-contain">`;
        } else if (type === 'pdf') {
            content.innerHTML = `<iframe src="${url}" class="w-full h-full" frameborder="0"></iframe>`;
        } else {
            content.innerHTML = `<a href="${url}" download class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                <i data-lucide="download" class="w-5 h-5 inline mr-2"></i>
                Télécharger le fichier
            </a>`;
            if (typeof lucide !== 'undefined') {
                setTimeout(() => lucide.createIcons(), 100);
            }
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeFileModal(event) {
        if (event && event.target !== event.currentTarget) return;
        
        const modal = document.getElementById('fileModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Reject Modal Functions
    function openRejectModal(route) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        
        form.action = route;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRejectModal(event) {
        if (event && event.target !== event.currentTarget) return;
        
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modals on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFileModal();
            closeRejectModal();
        }
    });
</script>
@endsection