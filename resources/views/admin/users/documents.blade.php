@extends('layouts.dashboard')

@section('title', 'Documents de ' . $user->nom)

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'users'])
@endsection

@section('page-title', 'Documents de ' . $user->nom)

@section('content')

    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users') }}" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 transition">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        {{ $user->nom }} {{ $user->prenom ?? '' }}
                    </h2>
                    <p class="text-slate-500">{{ $user->email }}</p>
                </div>
            </div>

            @if ($documents->isNotEmpty() && $documents->where('status', '!=', 'approuve')->count() > 0)
                <form action="{{ route('admin.users.documents.verify-all', $user) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-md flex items-center gap-2 transition"
                        onclick="return confirm('Voulez-vous valider tous les documents ?')">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Valider tous les documents
                    </button>
                </form>
            @elseif($documents->isNotEmpty())
                <div class="px-6 py-3 bg-green-100 text-green-700 rounded-xl flex items-center gap-2">
                    <i data-lucide="badge-check" class="w-5 h-5"></i>
                    Tous les documents sont validés
                </div>
            @endif
        </div>

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif
        {{-- DOCUMENTS --}}
        @if ($documents->isEmpty())
            <p>Aucun document</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($documents as $document)
                    @php
                        $documentPath = storage_path('app/public/' . $document->chemin);
                        $fileExists = file_exists($documentPath);
                        $fileExtension = $fileExists ? strtolower(pathinfo($documentPath, PATHINFO_EXTENSION)) : null;

                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $isPdf = $fileExtension === 'pdf';

                        $fileUrl = asset('storage/' . $document->chemin);
                    @endphp

                    <div class="bg-white rounded-xl shadow p-4">

                        {{-- TYPE --}}
                        <h3 class="font-semibold mb-2">
                            {{ ucfirst($document->type) }}
                        </h3>

                        {{-- PREVIEW --}}
                        @if ($fileExists)
                            {{-- IMAGE --}}
                            @if ($isImage)
                                <div onclick="openModal('{{ $fileUrl }}','image')"
                                    class="cursor-pointer aspect-video bg-slate-100 rounded-lg overflow-hidden mb-4">
                                    <img src="{{ $fileUrl }}" class="w-full h-full object-contain">
                                </div>

                                {{-- PDF --}}
                            @elseif ($isPdf)
                                <div onclick="openModal('{{ $fileUrl }}','pdf')"
                                    class="cursor-pointer aspect-video bg-slate-100 flex items-center justify-center rounded-lg mb-4">
                                    <div class="text-center">
                                        <i data-lucide="file-text" class="w-10 h-10 text-red-500 mx-auto"></i>
                                        <p>Voir PDF</p>
                                    </div>
                                </div>

                                {{-- AUTRE --}}
                            @else
                                <a href="{{ $fileUrl }}" target="_blank"
                                    class="block aspect-video bg-slate-100 flex items-center justify-center rounded-lg mb-4">
                                    Télécharger fichier
                                </a>
                            @endif
                        @else
                            <div class="text-red-500">Fichier introuvable</div>
                        @endif

                        {{-- STATUS --}}
                        <div class="mb-3 text-sm">
                            Status :
                            <strong
                                class="
                            @if ($document->status == 'approuve') text-green-600
                            @elseif($document->status == 'rejete') text-red-600
                            @else text-yellow-600 @endif
                        ">
                                {{ $document->status }}
                            </strong>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="grid grid-cols-2 gap-2">

                            {{-- VALIDER --}}
                            @if ($document->status !== 'approuve')
                                <form action="{{ route('admin.documents.verify', $document) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-3 py-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-500 hover:text-white transition text-sm">
                                        ✔ Valider
                                    </button>
                                </form>
                            @else
                                <div class="text-center text-gray-400 text-sm py-2 bg-gray-100 rounded-lg">
                                    ✔ Déjà validé
                                </div>
                            @endif

                            {{-- INVALIDER --}}
                            @if ($document->status !== 'rejete')
                                <form action="{{ route('admin.documents.verify', $document) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="reject" value="1">
                                    <button type="submit" onclick="return confirm('Confirmer le rejet ?')"
                                        class="w-full px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition text-sm">
                                        ✖ Invalider
                                    </button>
                                </form>
                            @else
                                <div class="text-center text-gray-400 text-sm py-2 bg-gray-100 rounded-lg">
                                    ✖ Déjà rejeté
                                </div>
                            @endif

                        </div>

                    </div>
                @endforeach

            </div>

        @endif

    </div>

    {{-- MODAL --}}
    <div id="documentModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

        <div class="bg-white rounded-xl p-4 max-w-4xl w-full relative">

            <button onclick="closeModal()" class="absolute top-2 right-2 text-xl">✕</button>

            <img id="modalImage" class="hidden w-full max-h-[80vh] object-contain" />
            <iframe id="modalPdf" class="hidden w-full h-[80vh]"></iframe>

        </div>

    </div>

    {{-- SCRIPT --}}
    <script>
        function openModal(url, type) {
            let modal = document.getElementById('documentModal');
            let img = document.getElementById('modalImage');
            let pdf = document.getElementById('modalPdf');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            if (type === 'image') {
                img.src = url;
                img.classList.remove('hidden');
                pdf.classList.add('hidden');
            } else {
                pdf.src = url;
                pdf.classList.remove('hidden');
                img.classList.add('hidden');
            }
        }

        function closeModal() {
            document.getElementById('documentModal').classList.add('hidden');
        }

        document.getElementById('documentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

@endsection
