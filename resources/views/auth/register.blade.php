@extends('layouts.app')

@section('title', 'Inscription - WasselM3ak')

@section('content')
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="min-h-screen flex bg-gray-50 font-sans" x-data="{
        step: 1,
        role: 'expediteur',
        showPass: false,
        init() {
            $watch('step', () => {
                setTimeout(() => lucide.createIcons(), 50);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }" x-cloak>

        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 items-center justify-center p-12 overflow-hidden">
            <img :src="role === 'expediteur'
                ?
                'https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&w=1200&q=80' :
                'https://images.unsplash.com/photo-1586339949916-3e9457bef6d3?auto=format&fit=crop&w=1200&q=80'"
                class="absolute inset-0 w-full h-full object-cover opacity-40 transition-opacity duration-700"
                alt="Background">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
            <div class="relative z-10 max-w-md w-full text-white">
                <div class="flex items-center gap-3 mb-8">
                    <div
                        class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-xl shadow-orange-500/20">
                        <i data-lucide="truck"></i>
                    </div>
                    <h1 class="text-4xl font-bold tracking-tight italic uppercase">WASSEL<span
                            class="text-orange-500">M3AK</span></h1>
                </div>
                <h2 class="text-5xl font-black leading-tight mb-6 uppercase italic"
                    x-text="role === 'expediteur' ? 'Envoyez partout' : 'Roulez avec nous'"></h2>
                <p class="text-lg opacity-80"
                    x-text="role === 'expediteur' ? 'La solution logistique la plus rapide au Maroc.' : 'Optimisez vos trajets et augmentez vos revenus.'">
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 md:p-12">
            <div
                class="max-w-xl w-full bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden flex border border-gray-100 min-h-[650px]">

                <div class="w-20 md:w-28 bg-[#1e293b] flex flex-col items-center py-10 transition-all"
                    x-show="step > 1 && step < 5">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all"
                            :class="step === 2 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' :
                                'bg-green-500 text-white'">
                            <i :data-lucide="step > 2 ? 'check' : 'user'" class="w-5 h-5"></i>
                        </div>
                        <div class="w-0.5 h-8 bg-slate-700" :class="step > 2 && 'bg-green-500'"></div>

                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all"
                            :class="step === 3 ? 'bg-orange-500 text-white shadow-lg' : (step > 3 ? 'bg-green-500 text-white' :
                                'bg-slate-800 text-slate-500')">
                            <i :data-lucide="role === 'expediteur' ? 'map-pin' : 'truck'" class="w-5 h-5"></i>
                        </div>

                        <template x-if="role === 'chauffeur'">
                            <div class="contents">
                                <div class="w-0.5 h-8 bg-slate-700" :class="step > 3 && 'bg-green-500'"></div>
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all"
                                    :class="step === 4 ? 'bg-orange-500 text-white shadow-lg' : (step > 4 ?
                                        'bg-green-500 text-white' : 'bg-slate-800 text-slate-500')">
                                    <i data-lucide="file-text" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex-1 p-8 md:p-12 self-center">
                    <form action="register" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_type" :value="role">
                        @if ($errors->any())
                            <div
                                class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-500 rounded-r-xl flex gap-3 animate-fade-in">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-orange-500 shrink-0"></i>
                                <div>
                                    <h4 class="text-sm font-bold text-orange-800 uppercase tracking-tight">Oups ! Quelque
                                        chose ne va pas</h4>
                                    <ul class="mt-1 list-disc list-inside text-xs text-orange-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div x-show="step === 1">
                            <h2 class="text-3xl font-bold text-slate-800 mb-2">Bienvenue !</h2>
                            <p class="text-slate-500 mb-8">Quel est votre profil ?</p>
                            <div class="space-y-4">
                                <div @click="role = 'expediteur'"
                                    :class="role === 'expediteur' ? 'border-orange-500 bg-orange-50/50 ring-2 ring-orange-500' :
                                        'border-slate-200'"
                                    class="p-6 border-2 rounded-[2rem] cursor-pointer transition-all">
                                    <h3 class="font-bold text-lg">Expéditeur</h3>
                                    <p class="text-sm text-slate-500">Je veux envoyer des marchandises.</p>
                                </div>
                                <div @click="role = 'chauffeur'"
                                    :class="role === 'chauffeur' ? 'border-orange-500 bg-orange-50/50 ring-2 ring-orange-500' :
                                        'border-slate-200'"
                                    class="p-6 border-2 rounded-[2rem] cursor-pointer transition-all">
                                    <h3 class="font-bold text-lg">Transporteur</h3>
                                    <p class="text-sm text-slate-500">Je propose mes services de transport.</p>
                                </div>
                            </div>
                            <button type="button" @click="step = 2"
                                class="w-full mt-8 py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl font-bold shadow-xl shadow-orange-500/20 transition-all">Continuer</button>
                        </div>

                        <div x-show="step === 2" x-transition>
                            <h2
                                class="text-2xl font-bold text-slate-800 mb-8 uppercase italic tracking-tight text-orange-500">
                                Infos Personnelles</h2>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div><label class="text-[10px] font-black uppercase text-slate-400">Prénom</label><input
                                            type="text" name="prenom"
                                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all">
                                    </div>
                                    <div><label class="text-[10px] font-black uppercase text-slate-400">Nom</label><input
                                            type="text" name="nom"
                                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all">
                                    </div>
                                </div>
                                <div><label class="text-[10px] font-black uppercase text-slate-400">Email</label><input
                                        type="email" name="email"
                                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all">
                                </div>
                                <div><label class="text-[10px] font-black uppercase text-slate-400">Téléphone</label><input
                                        type="tel" name="phone"
                                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all">
                                </div>
                                <div x-data="{ show: false }" class="relative">
                                    <label class="text-[10px] font-black uppercase text-slate-400">Mot de passe</label>
                                    <input :type="show ? 'text' : 'password'" name="password"
                                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all">
                                    <button type="button" @click="show = !show"
                                        class="absolute right-3 top-7 text-slate-400"><i
                                            :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i></button>
                                </div>
                                <div><label
                                        class="text-[10px] font-black uppercase text-slate-400">Confirmation</label><input
                                        type="password" name="password_confirmation"
                                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all">
                                </div>
                            </div>
                            <div class="flex justify-between mt-8">
                                <button type="button" @click="step = 1"
                                    class="text-slate-400 hover:text-orange-500 transition-colors"><i
                                        data-lucide="arrow-left"></i></button>
                                <button type="button" @click="step = 3"
                                    class="bg-orange-500 px-8 py-3 text-white rounded-lg font-bold shadow-lg shadow-orange-500/20 active:scale-95 transition-all">Suivant</button>
                            </div>
                        </div>

                        <div x-show="step === 3" x-transition>
                            <h2 class="text-2xl font-bold text-slate-800 mb-8 uppercase italic tracking-tight text-orange-500"
                                x-text="role === 'expediteur' ? 'Profil Expéditeur' : 'Détails du Véhicule'"></h2>

                            <div x-show="role === 'expediteur'" class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-black uppercase text-slate-400">Adresse
                                        Principale</label>
                                    <input type="text" name="adresse_principale"
                                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none border-slate-200 transition-all"
                                        placeholder="Ex: Hay Riad, Rabat">
                                </div>
                                <div class="bg-orange-50 p-4 rounded-xl border border-orange-100 flex gap-3">
                                    <i data-lucide="info" class="w-5 h-5 text-orange-500"></i>
                                    <p class="text-xs text-orange-700 italic leading-relaxed">En tant qu'expéditeur, vous
                                        pourrez suivre vos colis en temps réel dès la validation de votre profil.</p>
                                </div>
                            </div>

                            <div x-show="role === 'chauffeur'" class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-black uppercase text-slate-400">Type de Véhicule</label>
                                    <select name="type_vehicule"
                                        class="w-full p-3 border rounded-lg bg-white outline-none border-slate-200 focus:ring-2 focus:ring-orange-500">
                                        <option value="moto">Moto / Triporteur</option>
                                        <option value="camionnette">Camionnette (Kangoo/Partner)</option>
                                        <option value="camion">Poids lourd / Master</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black uppercase text-slate-400">Immatriculation</label>
                                    <input type="text" name="immatriculation"
                                        class="w-full p-3 border rounded-lg outline-none uppercase border-slate-200 focus:ring-2 focus:ring-orange-500"
                                        placeholder="12345-A-1">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div><label class="text-[10px] font-black uppercase text-slate-400">Charge
                                            (KG)</label><input type="number" name="capacite_charge_kg"
                                            class="w-full p-3 border rounded-lg outline-none border-slate-200 focus:ring-2 focus:ring-orange-500">
                                    </div>
                                    <div><label class="text-[10px] font-black uppercase text-slate-400">Volume
                                            (M³)</label><input type="number" name="capacite_volume_m3"
                                            class="w-full p-3 border rounded-lg outline-none border-slate-200 focus:ring-2 focus:ring-orange-500">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mt-8">
                                <button type="button" @click="step = 2" class="text-slate-400"><i
                                        data-lucide="arrow-left"></i></button>
                                <button type="button" @click="role === 'expediteur' ? step = 5 : step = 4"
                                    class="bg-orange-500 px-8 py-3 text-white rounded-lg font-bold shadow-lg shadow-orange-500/20 active:scale-95 transition-all"
                                    x-text="role === 'expediteur' ? 'Terminer' : 'Suivant'"></button>
                            </div>
                        </div>

                        <div x-show="step === 4 && role === 'chauffeur'" x-transition>
                            <h2
                                class="text-2xl font-bold text-slate-800 mb-8 uppercase italic tracking-tight text-orange-500">
                                Vérification Documents</h2>
                            <div class="space-y-3">
                                <div
                                    class="p-4 border-2 border-dashed border-slate-200 rounded-xl text-center hover:border-orange-400 transition-colors bg-slate-50/50">
                                    <label class="cursor-pointer block">
                                        <input type="file" name="doc_permis" class="hidden">
                                        <i data-lucide="upload-cloud" class="mx-auto text-slate-300 w-8 h-8"></i>
                                        <p class="text-[10px] font-black uppercase text-slate-500 mt-2">Permis de conduire
                                        </p>
                                    </label>
                                </div>
                                <div
                                    class="p-4 border-2 border-dashed border-slate-200 rounded-xl text-center hover:border-orange-400 transition-colors bg-slate-50/50">
                                    <label class="cursor-pointer block">
                                        <input type="file" name="doc_carte_grise" class="hidden">
                                        <i data-lucide="upload-cloud" class="mx-auto text-slate-300 w-8 h-8"></i>
                                        <p class="text-[10px] font-black uppercase text-slate-500 mt-2">Carte Grise</p>
                                    </label>
                                </div>
                                <div
                                    class="p-4 border-2 border-dashed border-slate-200 rounded-xl text-center hover:border-orange-400 transition-colors bg-slate-50/50">
                                    <label class="cursor-pointer block">
                                        <input type="file" name="doc_assurance" class="hidden">
                                        <i data-lucide="upload-cloud" class="mx-auto text-slate-300 w-8 h-8"></i>
                                        <p class="text-[10px] font-black uppercase text-slate-500 mt-2">Assurance Véhicule
                                        </p>
                                    </label>
                                </div>
                            </div>
                            <div class="flex justify-between mt-8">
                                <button type="button" @click="step = 3" class="text-slate-400"><i
                                        data-lucide="arrow-left"></i></button>
                                <button type="button" @click="step = 5"
                                    class="bg-orange-600 px-8 py-3 text-white rounded-lg font-bold shadow-lg shadow-orange-600/20 active:scale-95 transition-all">Finaliser</button>
                            </div>
                            <div class="mt-6 text-left">
                                <label class="flex items-center gap-2 text-sm text-slate-600">
                                    <input type="checkbox" name="terms" value="1" class="accent-orange-500">
                                    J’accepte les conditions générales
                                </label>
                            </div>
                        </div>

                        <div x-show="step === 5" class="text-center py-10">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i data-lucide="check" class="text-green-500 w-10 h-10"></i>
                            </div>
                            <h2 class="text-3xl font-black text-slate-800 italic uppercase">C'est prêt !</h2>
                            <p class="text-slate-500 mt-4 leading-relaxed">Votre compte est créé. <span
                                    x-show="role === 'chauffeur'">Nos administrateurs vérifient vos documents sous
                                    24h.</span></p>
                            <button type="submit"
                                class="block w-full mt-10 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest text-sm">Tableau
                                de Bord</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Personnalisation du scrollbar pour correspondre au thème */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
    </style>
@endsection
