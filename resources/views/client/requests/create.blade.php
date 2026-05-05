@extends('layouts.dashboard')

@section('title', 'Nouvelle demande')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-3xl w-full space-y-6">

        {{-- En-tête --}}
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-500 mb-4">
                <i data-lucide="package-plus" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">
                Créer une demande
            </h2>
            <p class="text-slate-500 mt-1">
                Remplissez les informations pour trouver un transporteur rapidement
            </p>
        </div>

        {{-- Formulaire --}}
        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6 md:p-8">
            <form method="POST" action="{{ route('client.requests.store') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf

                {{-- Trajet --}}
                <div>
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary-500"></i>
                        Trajet
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Ville de départ *</label>
                            <div class="relative mt-1">
                                <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                                <input type="text" name="ville_depart"
                                    value="{{ old('ville_depart') }}"
                                    placeholder="Casablanca"
                                    required
                                    class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            </div>
                            @error('ville_depart')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Ville d'arrivée *</label>
                            <div class="relative mt-1">
                                <i data-lucide="flag" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                                <input type="text" name="ville_arrive"
                                    value="{{ old('ville_arrive') }}"
                                    placeholder="Rabat"
                                    required
                                    class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            </div>
                            @error('ville_arrive')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Marchandise --}}
                <div>
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-primary-500"></i>
                        Marchandise
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Type de marchandise *</label>
                            <select name="type_marchendise" required
                                class="w-full mt-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                <option value="">Choisir...</option>
                                <option value="Meubles" {{ old('type_marchendise') == 'Meubles' ? 'selected' : '' }}>🪑 Meubles</option>
                                <option value="Cartons" {{ old('type_marchendise') == 'Cartons' ? 'selected' : '' }}>📦 Cartons</option>
                                <option value="Électroménager" {{ old('type_marchendise') == 'Électroménager' ? 'selected' : '' }}>🔌 Électroménager</option>
                                <option value="Palettes" {{ old('type_marchendise') == 'Palettes' ? 'selected' : '' }}>📐 Palettes</option>
                                <option value="Véhicules" {{ old('type_marchendise') == 'Véhicules' ? 'selected' : '' }}>🚗 Véhicules</option>
                                <option value="Marchandises dangereuses" {{ old('type_marchendise') == 'Marchandises dangereuses' ? 'selected' : '' }}>⚠️ Dangereuses</option>
                            </select>
                            @error('type_marchendise')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Poids (kg) *</label>
                                <input type="number" name="poids_kg"
                                    value="{{ old('poids_kg') }}"
                                    required
                                    min="0"
                                    step="0.1"
                                    class="w-full mt-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                @error('poids_kg')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Prix estimé (DH) *</label>
                                <input type="number" name="prix_estime"
                                    value="{{ old('prix_estime') }}"
                                    required
                                    min="0"
                                    step="10"
                                    class="w-full mt-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                @error('prix_estime')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Photo de la marchandise --}}
                <div>
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i data-lucide="camera" class="w-5 h-5 text-primary-500"></i>
                        Photo (optionnelle)
                    </h3>
                    <div class="space-y-4">
                        <div id="upload-area"
                             class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-primary-500 transition-all duration-200 cursor-pointer bg-slate-50 hover:bg-primary-50/20">
                            <input type="file" name="image_marchandise" id="image_marchandise" accept="image/*" class="hidden" />
                            <div id="upload-preview" class="flex flex-col items-center justify-center gap-2">
                                <i data-lucide="upload-cloud" class="w-12 h-12 text-slate-400"></i>
                                <p class="text-slate-600 font-medium">Cliquez ou glissez une image ici</p>
                                <p class="text-xs text-slate-400">PNG, JPG, JPEG jusqu'à 5 Mo</p>
                            </div>
                        </div>
                        <div id="image-preview" class="hidden">
                            <div class="relative inline-block">
                                <img id="preview-img" src="#" alt="Aperçu" class="w-32 h-32 object-cover rounded-xl border shadow-md">
                                <button type="button" id="remove-image"
                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md transition">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        @error('image_marchandise')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="text-sm font-medium text-slate-700 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-primary-500"></i>
                        Description (optionnel)
                    </label>
                    <textarea name="description"
                        class="w-full mt-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        rows="3"
                        placeholder="Détails supplémentaires : dimensions, instructions particulières...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('client.index') }}"
                        class="flex-1 text-center py-3 border border-slate-300 rounded-xl hover:bg-slate-50 transition font-medium text-slate-700">
                        Annuler
                    </a>
                    <button type="submit"
                        class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        Publier la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Gestion de l'upload d'image
    const uploadArea = document.getElementById('upload-area');
    const imageInput = document.getElementById('image_marchandise');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeImageBtn = document.getElementById('remove-image');

    function handleImageUpload(file) {
        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner une image valide.');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            alert('L’image ne doit pas dépasser 5 Mo.');
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            imagePreview.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        };
        reader.readAsDataURL(file);

        // Mettre à jour l’input file
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        imageInput.files = dataTransfer.files;
    }

    uploadArea.addEventListener('click', () => imageInput.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-primary-500', 'bg-primary-50');
    });
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
    });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
        const file = e.dataTransfer.files[0];
        if (file) handleImageUpload(file);
    });

    imageInput.addEventListener('change', (e) => {
        if (e.target.files[0]) handleImageUpload(e.target.files[0]);
    });

    removeImageBtn.addEventListener('click', () => {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        previewImg.src = '#';
    });

    // Réinitialiser Lucide après chargement dynamique
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush

@push('styles')
<style>
    .shadow-soft {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
    }
    #upload-area {
        transition: all 0.2s ease;
    }
</style>
@endpush
@endsection