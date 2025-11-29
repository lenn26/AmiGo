<x-main-layout>
    <div class="min-h-[calc(100vh-8rem)] flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 mb-24">
        <div class="flex flex-col md:flex-row w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Partie gauche - Promotional -->
            <div class="w-full md:w-1/2 bg-[#1A1A1A] p-8 md:p-10 flex flex-col justify-between relative">
                <!-- Retour au site -->
                <div>
                    <a href="/" class="inline-flex items-center text-gray-400 hover:text-white transition group">
                        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour au site
                    </a>
                </div>

                <!-- Contenu principal -->
                <div class="relative z-10 mt-12 md:mt-0">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
                        T'as pas de <br>
                        <span class="text-[#56BA8D]">voiture ?</span>
                    </h1>
                    <p class="text-[#C5C5C5] text-lg md:text-2xl max-w-md">
                        Rejoins la communauté étudiante Amiénoise
                    </p>

                    <div class="mt-12 flex flex-col items-center md:items-start">
                        <!-- Images des étudiants -->
                        <div class="relative w-64 h-64 mb-4">
                            <img src="{{ asset('images/login_students.png') }}" alt="Étudiants" class="w-full h-full object-contain">
                        </div>

                        <div class="text-center md:text-left">
                            <p class="text-3xl md:text-3xl font-bold text-white mb-1">+1500 étudiants</p>
                            <p class="text-2xl md:text-3xl font-bold text-white">inscrits !</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partie droite - Formulaire d'inscription -->
            <div class="w-full md:w-1/2 bg-white p-8 md:p-10 flex items-center justify-center">
                <div class="w-full max-w-md space-y-8">
                    <div class="text-center md:text-left">
                        <h2 class="text-3xl md:text-4xl font-bold text-[#333333] mb-2">Rejoins AmiGo</h2>
                        <p class="text-[#8A8A8A]">Simple, gratuit et sécurisé.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Prénom et Nom -->
                        <div class="flex space-x-4">
                            <div class="w-1/2">
                                <label for="first_name" class="block text-sm font-bold text-gray-700 mb-2">Prénom</label>
                                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                                    placeholder="Thomas"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-[#56BA8D] focus:border-[#56BA8D] outline-none transition text-gray-900 placeholder-gray-400">
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                            <div class="w-1/2">
                                <label for="last_name" class="block text-sm font-bold text-gray-700 mb-2">Nom</label>
                                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                                    placeholder="Dupont"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-[#56BA8D] focus:border-[#56BA8D] outline-none transition text-gray-900 placeholder-gray-400">
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Adresse email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email universitaire</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                placeholder="etudiant@u-picardie.fr"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-[#56BA8D] focus:border-[#56BA8D] outline-none transition text-gray-900 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Mot de passe</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Mot de passe robuste"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-[#56BA8D] focus:border-[#56BA8D] outline-none transition text-gray-900 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirmer mot de passe</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirmer le mot de passe"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-[#56BA8D] focus:border-[#56BA8D] outline-none transition text-gray-900 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Conditions d'utilisation -->
                        <div class="flex items-center">
                            <input id="terms" type="checkbox" name="terms" required
                                class="w-4 h-4 text-[#56BA8D] border-gray-300 rounded focus:ring-[#56BA8D]">
                            <label for="terms" class="ml-2 block text-sm text-gray-500">
                                J'accepte les <a href="#" class="text-[#56BA8D] hover:underline">CGU</a> et certifie être étudiant.
                            </label>
                        </div>

                        <!-- Bouton d'inscription -->
                        <button type="submit" class="w-full py-4 bg-[#56BA8D] text-white font-bold rounded-lg hover:bg-green-600 transition shadow-lg shadow-green-500/25 text-lg">
                            S'inscrire gratuitement
                        </button>

                        <!-- Lien de connexion -->
                        <div class="text-center text-sm text-gray-500 font-medium">
                            Déjà un compte ?
                            <a href="{{ route('login') }}" class="text-[#56BA8D] hover:underline">Se connecter</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>