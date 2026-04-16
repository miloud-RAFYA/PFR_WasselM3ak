<div class="min-h-screen flex bg-gray-50 items-center justify-center p-4" 
     x-data="{ 
        step: 1,
        formData: {
            role: 'driver',
            nom: '', prenom: '', email: '', phone: '', password: '', password_confirmation: '',
            type_vehicule: '', immatriculation: '', charge: '', volume: '',
            permis: null, assurance: null
        }
     }">
    
    <div class="max-w-5xl w-full flex bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 min-h-[650px]">
        
        <div class="w-1/3 bg-[#1e293b] p-8 text-white hidden md:block">
            <div class="mb-12">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center text-xl mb-4 shadow-lg shadow-red-600/20">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Inscription Chauffeur</p>
            </div>

            <nav class="space-y-10 relative">
                <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-gray-700"></div>

                <div class="relative flex items-center gap-4">
                    <div class="z-10 w-8 h-8 rounded-full flex items-center justify-center border-4 border-[#1e293b] transition-all"
                         :class="step >= 1 ? (step == 1 ? 'bg-blue-400 shadow-[0_0_15px_rgba(96,165,250,0.5)]' : 'bg-green-500') : 'bg-gray-700'">
                        <i class="fa-solid fa-check text-[10px]" x-show="step > 1"></i>
                        <div class="w-2 h-2 rounded-full bg-white" x-show="step == 1"></div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-widest" :class="step == 1 ? 'text-white' : 'text-gray-400'">Étape 1</span>
                        <span class="text-xs font-medium" :class="step == 1 ? 'text-blue-400' : 'text-gray-500'">Identité</span>
                    </div>
                </div>

                <div class="relative flex items-center gap-4">
                    <div class="z-10 w-8 h-8 rounded-full flex items-center justify-center border-4 border-[#1e293b] transition-all"
                         :class="step >= 2 ? (step == 2 ? 'bg-blue-400 shadow-[0_0_15px_rgba(96,165,250,0.5)]' : 'bg-green-500') : 'bg-gray-700'">
                        <i class="fa-solid fa-check text-[10px]" x-show="step > 2"></i>
                        <div class="w-2 h-2 rounded-full bg-white" x-show="step == 2"></div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-widest" :class="step == 2 ? 'text-white' : 'text-gray-400'">Étape 2</span>
                        <span class="text-xs font-medium" :class="step == 2 ? 'text-blue-400' : 'text-gray-500'">Véhicule</span>
                    </div>
                </div>

                <div class="relative flex items-center gap-4">
                    <div class="z-10 w-8 h-8 rounded-full flex items-center justify-center border-4 border-[#1e293b] transition-all"
                         :class="step == 3 ? 'bg-blue-400 shadow-[0_0_15px_rgba(96,165,250,0.5)]' : 'bg-gray-700'">
                        <div class="w-2 h-2 rounded-full bg-white" x-show="step == 3"></div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-widest" :class="step == 3 ? 'text-white' : 'text-gray-400'">Étape 3</span>
                        <span class="text-xs font-medium" :class="step == 3 ? 'text-blue-400' : 'text-gray-500'">Documents</span>
                    </div>
                </div>
            </nav>
        </div>

        <div class="flex-1 p-8 md:p-12 self-center">
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div x-show="step == 1" x-transition>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informations personnelles</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Prénom</label>
                            <input type="text" name="prenom" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Nom</label>
                            <input type="text" name="nom" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div class="space-y-4 mb-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Téléphone</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Mot de passe</label>
                                <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Confirmation</label>
                                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                    </div>
                    <button type="button" @click="step = 2" class="w-full bg-[#007ead] text-white py-4 rounded-xl font-bold hover:bg-[#00668c] transition-all">Suivant : Mon Véhicule</button>
                </div>

                <div x-show="step == 2" x-transition>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Détails du véhicule</h2>
                    <div class="space-y-4 mb-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Type de véhicule</label>
                            <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none appearance-none bg-white">
                                <option value="petit_utilitaire">Petit Utilitaire</option>
                                <option value="fourgon">Grand Fourgon</option>
                                <option value="camion">Camion</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Immatriculation</label>
                            <input type="text" name="immatriculation" placeholder="12345-A-6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Charge (kg)</label>
                                <input type="number" name="capacite_charge_kg" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Volume (m³)</label>
                                <input type="number" name="capacite_volume_m3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button type="button" @click="step = 1" class="w-1/4 border border-gray-200 text-gray-400 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all">Retour</button>
                        <button type="button" @click="step = 3" class="flex-1 bg-[#007ead] text-white py-4 rounded-xl font-bold hover:bg-[#00668c] transition-all">Suivant : Documents</button>
                    </div>
                </div>

                <div x-show="step == 3" x-transition>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Téléchargement des documents</h2>
                    <div class="space-y-4 mb-6">
                        <div class="relative group border-2 border-dashed border-gray-200 p-6 rounded-xl hover:border-blue-400 transition-all text-center">
                            <input type="file" name="document_permis" class="absolute inset-0 opacity-0 cursor-pointer">
                            <i class="fa-solid fa-id-card text-2xl text-gray-300 mb-2 block"></i>
                            <span class="text-xs font-bold text-gray-500">Scanner du Permis de Conduire</span>
                        </div>
                        <div class="relative group border-2 border-dashed border-gray-200 p-6 rounded-xl hover:border-blue-400 transition-all text-center">
                            <input type="file" name="document_assurance" class="absolute inset-0 opacity-0 cursor-pointer">
                            <i class="fa-solid fa-shield-halved text-2xl text-gray-300 mb-2 block"></i>
                            <span class="text-xs font-bold text-gray-500">Attestation d'assurance</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button type="button" @click="step = 2" class="w-1/4 border border-gray-200 text-gray-400 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all">Retour</button>
                        <button type="submit" class="flex-1 bg-green-500 text-white py-4 rounded-xl font-bold hover:bg-green-600 shadow-lg shadow-green-500/30 transition-all">Terminer l'inscription</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>