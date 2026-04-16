@extends('layouts.dashboard')

@section('title', 'Nouvelle demande')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('page-title', 'Nouvelle demande')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-3xl w-full space-y-6">

        <!-- 🔥 Header -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-slate-900">
                Créer une demande 🚚
            </h2>
            <p class="text-slate-500">
                Remplissez les informations pour trouver un transporteur rapidement
            </p>
        </div>

        <!-- 📦 Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">

            <form method="POST" action="{{ route('client.requests.store') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <!-- 📍 Trajet -->
                <div>
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Trajet
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">

                        <!-- Départ -->
                        <div>
                            <label class="text-sm text-slate-600 font-medium">Ville de départ *</label>
                            <div class="relative mt-1">
                                <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                                <input type="text" name="ville_depart"
                                    value="{{ old('ville_depart') }}"
                                    placeholder="Casablanca"
                                    required
                                    class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none transition">
                            </div>
                            @error('ville_depart')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arrivée -->
                        <div>
                            <label class="text-sm text-slate-600 font-medium">Ville d'arrivée *</label>
                            <div class="relative mt-1">
                                <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                                <input type="text" name="ville_arrive"
                                    value="{{ old('ville_arrive') }}"
                                    placeholder="Rabat"
                                    required
                                    class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none transition">
                            </div>
                            @error('ville_arrive')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- 📦 Marchandise -->
                <div>
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Marchandise
                    </h3>

                    <div class="space-y-4">

                        <!-- Type -->
                        <div>
                            <label class="text-sm text-slate-600 font-medium">Type de marchandise *</label>
                            <select name="type_marchendise" required
                                class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none transition">
                                <option value="">Choisir...</option>
                                <option value="Meubles" {{ old('type_marchendise') == 'Meubles' ? 'selected' : '' }}>🪑 Meubles</option>
                                <option value="Cartons" {{ old('type_marchendise') == 'Cartons' ? 'selected' : '' }}>📦 Cartons</option>
                                <option value="Électroménager" {{ old('type_marchendise') == 'Électroménager' ? 'selected' : '' }}>🔌 Électroménager</option>
                                <option value="Palettes" {{ old('type_marchendise') == 'Palettes' ? 'selected' : '' }}>📐 Palettes</option>
                                <option value="Véhicules" {{ old('type_marchendise') == 'Véhicules' ? 'selected' : '' }}>🚗 Véhicules</option>
                                <option value="Marchandises dangereuses" {{ old('type_marchendise') == 'Marchandises dangereuses' ? 'selected' : '' }}>⚠️ Marchandises dangereuses</option>
                            </select>
                            @error('type_marchendise')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poids + Prix -->
                        <div class="grid md:grid-cols-2 gap-4">

                            <div>
                                <label class="text-sm text-slate-600 font-medium">Poids (kg) *</label>
                                <input type="number" name="poids_kg"
                                    value="{{ old('poids_kg') }}"
                                    required
                                    min="0"
                                    step="0.1"
                                    class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none transition">
                                @error('poids_kg')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-sm text-slate-600 font-medium">Prix estimé (€) *</label>
                                <input type="number" name="prix_estime"
                                    value="{{ old('prix_estime') }}"
                                    required
                                    min="0"
                                    step="0.01"
                                    class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none transition">
                                @error('prix_estime')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>

                <!-- 🖼️ Image de la marchandise (NOUVEAU) -->
                <div>
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Photo de la marchandise
                    </h3>

                    <div class="space-y-4">
                        <!-- Zone d'upload -->
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-primary-500 transition cursor-pointer"
                             id="upload-area">
                            <input type="file" name="image_marchandise" id="image_marchandise" accept="image/*" class="hidden" />
                            <div id="upload-preview" class="flex flex-col items-center justify-center gap-3">
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-slate-600">
                                    Cliquez ou glissez une image ici
                                </p>
                                <p class="text-xs text-slate-400">
                                    PNG, JPG, JPEG jusqu'à 5MB
                                </p>
                            </div>
                        </div>

                        <!-- Aperçu de l'image -->
                        <div id="image-preview" class="hidden">
                            <div class="relative inline-block">
                                <img id="preview-img" src="#" alt="Aperçu" class="w-32 h-32 object-cover rounded-lg border shadow">
                                <button type="button" id="remove-image" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        @error('image_marchandise')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 📝 Description -->
                <div>
                    <label class="text-sm text-slate-600 font-medium">Description (optionnel)</label>
                    <textarea name="description"
                        class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none transition"
                        rows="3"
                        placeholder="Détails supplémentaires : dimensions, instructions particulières...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 🔥 Actions -->
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('client.dashboard') }}"
                        class="flex-1 text-center py-3 border border-slate-300 rounded-xl hover:bg-slate-50 transition font-medium">
                        Annuler
                    </a>
                    <button type="submit"
                        class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                        🚀 Publier la demande
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
    
    // Clic sur la zone d'upload
    uploadArea.addEventListener('click', () => {
        imageInput.click();
    });
    
    // Drag & Drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-primary-500', 'bg-primary-50');
    });
    
    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleImageUpload(file);
        }
    });
    
    // Changement de fichier
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            handleImageUpload(file);
        }
    });
    
    // Gérer l'upload
    function handleImageUpload(file) {
        if (file.size > 5 * 1024 * 1024) {
            alert('L\'image ne doit pas dépasser 5MB');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            imagePreview.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        };
        reader.readAsDataURL(file);
        
        // Créer un DataTransfer pour garder le fichier dans l'input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        imageInput.files = dataTransfer.files;
    }
    
    // Supprimer l'image
    removeImageBtn.addEventListener('click', () => {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        previewImg.src = '#';
    });
</script>

<style>
    #upload-area {
        transition: all 0.3s ease;
    }
    #upload-area:hover {
        background-color: #f0fdf4;
        border-color: #10b981;
    }
</style>
@endpush
@endsection