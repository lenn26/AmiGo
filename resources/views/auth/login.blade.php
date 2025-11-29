<x-main-layout>
    <div class="min-h-[calc(100vh-8rem)] flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 mb-24">
        <div class="flex flex-col md:flex-row w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Left Side - Promotional -->
            <div class="w-full md:w-1/2 bg-[#1A1A1A] p-8 md:p-10 flex flex-col justify-between relative">
                <!-- Back Link -->
                <div>
                    <a href="/" class="inline-flex items-center text-gray-400 hover:text-white transition group">
                        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour au site
                    </a>
                </div>

                <!-- Main Content -->
                <div class="relative z-10 mt-12 md:mt-0">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
                        T'as pas de <br>
                        <span class="text-[#2794EB]">voiture ?</span>
                    </h1>
                    <p class="text-[#C5C5C5] text-lg md:text-2xl max-w-md">
                        Rejoins la communauté étudiante Amiénoise
                    </p>

                    <div class="mt-12 flex flex-col items-center md:items-start">
                        <!-- Student Images -->
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

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 bg-white p-8 md:p-10 flex items-center justify-center">
                <div class="w-full max-w-md space-y-8">
                    <div class="text-center md:text-left">
                        <h2 class="text-3xl md:text-4xl font-bold text-[#333333] mb-2">Bon retour !</h2>
                        <p class="text-[#8A8A8A]">Connecte-toi pour trouver un trajet.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email universitaire</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                placeholder="etudiant@u-picardie.fr"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-900 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Mot de passe</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                placeholder="**********"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-900 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-4 bg-[#2794EB] text-white font-bold rounded-lg hover:bg-blue-600 transition shadow-lg shadow-blue-500/25 text-lg">
                            Se connecter
                        </button>

                        <!-- Register Link -->
                        <div class="text-center text-sm text-gray-500 font-medium">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}" class="text-[#2794EB] hover:underline">Créer un compte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>