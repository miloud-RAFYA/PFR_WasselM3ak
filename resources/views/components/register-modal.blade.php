<div x-data="{ open: false, activeTab: 'chauffeur' }" x-show="open" @open-register.window="open = true" @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">

    <!-- Overlay -->
    <div @click="open = false" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

        <!-- Header -->
        <div class="bg-primary-500 p-6 text-white text-center relative">
            <button @click="open = false" class="absolute top-4 right-4 text-white">
                ✕
            </button>
            <h2 class="text-xl font-bold">Créer un compte</h2>
        </div>

        <div class="p-6">

            <!-- Tabs -->
            <div class="flex gap-2 mb-6">
                <button @click="activeTab='expediteur'"
                    :class="activeTab === 'expediteur' ? 'bg-white border-primary-500 text-primary-600' : 'bg-gray-100'"
                    class="flex-1 py-2 rounded-lg border font-bold">
                    Expéditeur
                </button>

                <button @click="activeTab='chauffeur'"
                    :class="activeTab === 'chauffeur' ? 'bg-white border-primary-500 text-primary-600' : 'bg-gray-100'"
                    class="flex-1 py-2 rounded-lg border font-bold">
                    Chauffeur
                </button>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="user_type" :value="activeTab">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <ul class="text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <div class="space-y-4">

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="prenom" placeholder="Prénom" class="w-full border p-3 rounded-lg"
                            required>

                        <input type="text" name="nom" placeholder="Nom" class="w-full border p-3 rounded-lg"
                            required>
                    </div>

                    <input type="email" name="email" placeholder="Email" class="w-full border p-3 rounded-lg"
                        required>

                    <input type="tel" name="phone" placeholder="Téléphone" class="w-full border p-3 rounded-lg"
                        required>

                    <input type="password" name="password" placeholder="Mot de passe"
                        class="w-full border p-3 rounded-lg" required>

                    <input type="password" name="password_confirmation" placeholder="Confirmation"
                        class="w-full border p-3 rounded-lg" required>

                    <!-- Expéditeur -->
                    <div x-show="activeTab === 'expediteur'">
                        <textarea name="adresse_principale" placeholder="Adresse principale" class="w-full border p-3 rounded-lg"></textarea>
                    </div>

                    <!-- Chauffeur message -->
                    <div x-show="activeTab === 'chauffeur'" class="bg-orange-50 p-3 rounded-lg text-sm text-orange-700">
                        🚚 Vous pourrez compléter les informations de votre véhicule et vos documents après inscription.
                    </div>

                    <!-- Terms -->
                    <label class="flex gap-2 text-sm">
                        <input type="checkbox" name="terms" required>
                        <span>J'accepte les conditions générales</span>
                    </label>

                    <!-- Submit -->
                    <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-bold">
                        Créer mon compte
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
