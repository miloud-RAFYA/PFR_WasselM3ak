@extends('layouts.dashboard')

@section('title', 'Documents des chauffeurs')

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'driver-documents'])
@endsection

@section('page-title', 'Documents des chauffeurs')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">

        {{-- FILTERS --}}
        <form action="{{ route('admin.driver-documents') }}" method="GET" class="relative w-full lg:w-96">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Rechercher par nom de chauffeur..."
                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary-500 outline-none shadow-sm">
        </form>

        {{-- FILTERS --}}
        <div class="flex gap-3 w-full lg:w-auto">
            <select name="status" onchange="this.form.submit()" class="px-4 py-3 border rounded-xl bg-white shadow-sm">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="approuve" {{ request('status') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                <option value="rejete" {{ request('status') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
            </select>

            <select name="type" onchange="this.form.submit()" class="px-4 py-3 border rounded-xl bg-white shadow-sm">
                <option value="">Tous les types</option>
                <option value="permis" {{ request('type') == 'permis' ? 'selected' : '' }}>Permis de conduire</option>
                <option value="carte_grise" {{ request('type') == 'carte_grise' ? 'selected' : '' }}>Carte grise</option>
                <option value="assurance" {{ request('type') == 'assurance' ? 'selected' : '' }}>Assurance</option>
                <option value="identite" {{ request('type') == 'identite' ? 'selected' : '' }}>Pièce d'identité</option>
            </select>
        </div>

    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Chauffeur</th>
                        <th class="px-6 py-4 text-left">Type de document</th>
                        <th class="px-6 py-4 text-left">Document</th>
                        <th class="px-6 py-4 text-left">Statut</th>
                        <th class="px-6 py-4 text-left">Commentaire</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($documents as $document)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- CHAUFFEUR --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-white flex items-center justify-center font-bold shadow">
                                    {{ strtoupper(substr($document->chauffeur->user->nom ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $document->chauffeur->user->nom ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-400">{{ $document->chauffeur->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- TYPE --}}
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                @switch($document->type)
                                    @case('permis_conduir')
                                        Permis de conduire
                                        @break
                                    @case('carte_grise')
                                        Carte grise
                                        @break
                                    @case('assurance')
                                        Assurance
                                        @break
                                    @default
                                        {{ $document->type }}
                                @endswitch
                            </span>
                        </td>

                        {{-- DOCUMENT --}}
                        <td class="px-6 py-4">
                            <a href="{{ asset($document->chemin) }}" target="_blank" 
                                class="flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                Voir le document
                            </a>
                        </td>

                        {{-- STATUT --}}
                        <td class="px-6 py-4">
                            @switch($document->status)
                                @case('en_attente')
                                    <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-700 font-medium">
                                        En attente
                                    </span>
                                    @break
                                @case('approuve')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                        Approuvé
                                    </span>
                                    @break
                                @case('rejete')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 font-medium">
                                        Rejeté
                                    </span>
                                    @break
                            @endswitch
                        </td>

                        {{-- COMMENTAIRE --}}
                        <td class="px-6 py-4">
                            @if($document->commentaire_admin)
                                <p class="text-sm text-slate-600 max-w-xs truncate">{{ $document->commentaire_admin }}</p>
                            @else
                                <span class="text-sm text-slate-400">-</span>
                            @endif
                        </td>

                        {{-- DATE --}}
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-500">{{ $document->created_at->format('d/m/Y') }}</p>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                {{-- BOUTON MESSAGE --}}
                                <button onclick="openMessageModal({{ $document->id }})"
                                    class="p-2 text-slate-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition"
                                    title="Envoyer un message">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </button>

                                @if($document->status === 'en_attente')
                                    {{-- VALIDATION --}}
                                    <form action="{{ route('admin.documents.verify', $document) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="p-2 text-green-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition"
                                            title="Approuver">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    {{-- REJET --}}
                                    <form action="{{ route('admin.documents.verify', $document) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="reject" value="1">
                                        <button type="submit"
                                            class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Rejeter">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- SUPPRESSION --}}
                                <form action="{{ route('admin.documents.destroy', $document) }}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <i data-lucide="file-x" class="w-12 h-12 text-slate-300"></i>
                                <p>Aucun document trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($documents->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $documents->links() }}
            </div>
        @endif

    </div>

</div>

{{-- MODAL MESSAGE --}}
<div id="messageModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-900">Envoyer un message au chauffeur</h3>
        </div>
        <form id="messageForm" method="POST">
            @csrf
            <div class="p-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Message</label>
                <textarea name="message" rows="4" required
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 outline-none resize-none"
                    placeholder="Entrez votre message..."></textarea>
            </div>
            <div class="p-6 border-t border-slate-100 flex gap-3 justify-end">
                <button type="button" onclick="closeMessageModal()"
                    class="px-5 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                    Annuler
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openMessageModal(documentId) {
        const form = document.getElementById('messageForm');
        form.action = `/admin/documents/${documentId}/message`;
        document.getElementById('messageModal').classList.remove('hidden');
        document.getElementById('messageModal').classList.add('flex');
    }

    function closeMessageModal() {
        document.getElementById('messageModal').classList.add('hidden');
        document.getElementById('messageModal').classList.remove('flex');
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('messageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMessageModal();
        }
    });
</script>

@endsection