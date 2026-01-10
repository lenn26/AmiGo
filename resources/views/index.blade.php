<x-main-layout>
    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-12 lg:py-20 flex flex-col lg:flex-row items-center gap-12">
        <!-- Text Content -->
        <div class="lg:w-5/6 space-y-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-s font-medium text-gray-600">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Réseau étudiant 100% Amiénois
            </div>

            <!-- Slogan -->
            <h1 class="text-5xl lg:text-[96px] font-bold text-[#333333] leading-[1]">
                T&#8217;as pas de voiture ? <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-green-500 to-blue-500 bg-300% animate-gradient">Trouve un Amigo.</span>
            </h1>

            <!-- Description -->
            <p class="text-lg text-[#333333]/80 max-w-lg leading-relaxed">
                Amigo connecte les étudiants d'Amiens pour aller en cours.
                Économise, rencontre du monde, et oublie le bus blindé de 8h.
            </p>

            <!-- Boutons -->
            <div class="flex flex-wrap gap-4">
                <!-- Bouton recherche de trajet -->
                <a href="{{ route('trips') }}" class="px-8 py-4 bg-[#2794EB] text-white font-semibold rounded-xl hover:bg-blue-600 transition shadow-lg shadow-blue-500/25">
                    Tu cherches un trajet ?
                </a>
                <!-- Bouton publication de trajet -->
                <a href="{{ Auth::check() ? route('trips.create') : route('login') }}" class="px-8 py-4 bg-[#70D78D] text-white font-semibold rounded-xl hover:bg-green-500 transition shadow-lg shadow-green-400/25">
                    Publie ton trajet !
                </a>
            </div>

            <!-- Trajets, prix moyen, étudiants connectés, note -->
            <div class="flex items-center gap-8 pt-4 border-t-[1px] border-[#000000]/13">
                <div>
                    <p class="text-2xl font-bold text-[#333333]">450+</p>
                    <p class="text-base text-gray-500">Trajets / semaine</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-[#333333]">2.5€</p>
                    <p class="text-base text-gray-500">Prix moyen</p>
                </div>
            </div>
           <div class="flex flex-row items-center gap-4">
                <div class="flex -space-x-4 rtl:space-x-reverse">
                    <img class="w-14 h-14 rounded-full shadow-md border-2 border-white"
                        src="{{ asset('images/avatar1.png') }}"
                        alt="Avatar 1">

                    <img class="w-14 h-14 rounded-full shadow-md border-2 border-white"
                        src="{{ asset('images/avatar2.png') }}"
                        alt="Avatar 2">

                    <img class="w-14 h-14 rounded-full shadow-md border-2 border-white"
                        src="{{ asset('images/avatar3.png') }}"
                        alt="Avatar 3">
                </div>
                <div class="flex flex-col items-start"> <p class="text-xl font-medium text-[#333333]/80">+400 Étudiants connectés</p>
                    <div class="flex items-center text-yellow-400 text-lg">
                        ★★★★★ <span class="text-blue-500 ml-1 font-bold">4.9/5</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Téléphone -->
        <div class="lg:w-1/2 relative">
            <div class="relative z-10 bg-white rounded-[2.5rem] shadow-2xl p-3 w-[320px] mx-auto border-8 border-gray-900">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-24 h-6 bg-gray-900 rounded-b-xl"></div>
                <div class="h-[600px] bg-gray-50 rounded-[2rem] overflow-hidden flex flex-col relative">
                    <!-- En-tête de l'application -->
                    <div class="p-6 pt-12 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-3xl text-gray-900">Bonjour !</h3>
                        </div>
                        <div class="w-10 h-10 bg-[#47D6B6] rounded-full flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="px-6 space-y-4">
                        <button class="w-full py-6 bg-[#2794EB] text-white rounded-xl text-center text-lg font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-600 transition">
                            Tu cherches un trajet ?
                        </button>
                        <button class="w-full py-6 bg-[#70D78D] text-white rounded-xl text-center text-lg font-bold shadow-lg shadow-green-500/20 hover:bg-green-500 transition">
                            Publie ton trajet !
                        </button>
                    </div>

                    <div class="mt-8 px-6">
                        <h4 class="font-bold text-xl text-gray-900 mb-4">Trajets à venir</h4>
                        <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                            <!-- Infos utilisateur -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 bg-[#2794EB] rounded-full flex items-center justify-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-bold text-gray-900">Sophie L.</span>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-gray-500 font-medium">3.8/5</span>
                                </div>
                            </div>

                            <!-- Détails du trajet -->
                            <div class="flex justify-between items-end">
                                <!-- Timeline -->
                                <div class="relative pl-4 border-l-2 border-gray-200 space-y-6 ml-2">
                                     <!-- Départ -->
                                     <div class="relative">
                                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-gray-400 bg-white"></div>
                                        <p class="font-bold text-gray-900 leading-none">07:50</p>
                                        <p class="text-xs text-gray-500 mt-1">Gare d'Amiens</p>
                                     </div>
                                     <!-- Fin -->
                                     <div class="relative">
                                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-[#70D78D] bg-white"></div>
                                        <p class="font-bold text-gray-900 leading-none">08:15</p>
                                        <p class="text-xs text-gray-500 mt-1">Campus Citadelle</p>
                                     </div>
                                </div>

                                <!-- Prix et informations -->
                                <div class="text-right space-y-2">
                                    <p class="font-bold text-xl text-gray-900">2,00€</p>
                                    <div class="bg-[#70D78D]/20 text-[#70D78D] text-[10px] font-bold px-2 py-1 rounded-md inline-block">
                                        2 places restantes
                                    </div>
                                    <div class="flex justify-end gap-2 text-gray-400 pt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-blue-100 to-green-100 rounded-full blur-3xl -z-10 opacity-50"></div>
        </div>
    </section>

    <!-- Section de recherche -->
    <section class="container mx-auto px-6 py-14">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-6xl font-bold text-[#333333] mb-4">
                Ton trajet express<span class="text-[#8ED630]">.</span>
            </h2>
            <p class="text-base text-[#333333]/80 mb-8 max-w-3xl">
                Réserve ta place en deux clics et profite d'un trajet confortable vers ton campus.
                Arrive à l'heure, sans le stress des transports.
            </p>

            <div class="bg-gradient-to-r from-blue-400 to-green-400 rounded-[4rem] p-8 shadow-xl">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 p-2 rounded-xl md:rounded-full backdrop-blur-sm">
                    <!-- Départ -->
                    <div class="flex-1 w-full relative group">
                        <label class="block text-xs text-white ml-4 mb-1 font-medium">Départ</label>
                        <div class="flex items-center bg-white rounded-full px-4 py-3 shadow-sm focus-within:ring-2 focus:ring-blue-500 relative">
                            <svg width="38px" height="38px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M2 6V6.29266C2 7.72154 2.4863 9.10788 3.37892 10.2236L8 16L12.6211 10.2236C13.5137 9.10788 14 7.72154 14 6.29266V6C14 2.68629 11.3137 0 8 0C4.68629 0 2 2.68629 2 6ZM8 8C9.10457 8 10 7.10457 10 6C10 4.89543 9.10457 4 8 4C6.89543 4 6 4.89543 6 6C6 7.10457 6.89543 8 8 8Z" fill="#2794EB" fill-rule="evenodd" />
                            </svg>
                            <input type="text" id="home_start_address" placeholder="Ex : Gare du Nord" class="w-full bg-transparent outline-none focus:ring-0 border-none text-[#333333] placeholder-gray-400 font-medium focus:border-blue-500">
                        </div>
                        <!-- Suggestions Départ -->
                        <div id="home_start_suggestions" class="absolute z-50 w-full bg-white border border-gray-100 rounded-xl mt-1 shadow-lg hidden overflow-hidden left-0"></div>
                    </div>

                    <!-- Icone de swap -->
                    <button class="p-2 text-white hover:bg-white/20 rounded-full transition md:mt-4">
                        <svg width="55px" height="55px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                            <path d="M6 13 2 9l4-4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 9h12" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                            <path d="m18 19 4-4-4-4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 15H10" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                        </svg>
                    </button>

                    <!-- Arrivée -->
                    <div class="flex-1 w-full relative">
                        <label class="block text-xs text-white ml-4 mb-1 font-medium">Arrivée</label>
                        <div class="flex items-center bg-white rounded-full px-4 py-3 shadow-sm focus-within:ring-2 focus:ring-blue-500 relative">
                            <svg width="38px" height="38px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1V16H3V10H7L9 12H15V3H9L7 1H1Z" fill="#47D6B6" />
                            </svg>
                            <input type="text" id="home_end_address" placeholder="Ex : Campus Citadelle" class="w-full bg-transparent outline-none focus:ring-0 border-none text-[#333333] placeholder-gray-400 font-medium focus:border-blue-500">
                        </div>
                        <!-- Suggestions Arrivée -->
                        <div id="home_end_suggestions" class="absolute z-50 w-full bg-white border border-gray-100 rounded-xl mt-1 shadow-lg hidden overflow-hidden left-0"></div>
                    </div>

                    <!-- Bouton go -->
                    <button class="bg-white text-green-500 font-bold py-3 px-8 rounded-full hover:bg-gray-50 transition shadow-lg mt-6 md:mt-7">
                        GO
                    </button>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-white font-medium">
                    <span class="opacity-80">Populaires :</span>
                    <button class="px-3 py-1 border border-white/30 rounded-full hover:bg-white/10 transition">Gare d'Amiens</button>
                    <button class="px-3 py-1 border border-white/30 rounded-full hover:bg-white/10 transition">CHU Sud</button>
                    <button class="px-3 py-1 border border-white/30 rounded-full hover:bg-white/10 transition">St-Leu</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section de la carte -->
    <section class="container mx-auto px-6 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-6xl font-bold text-[#333333] mb-2">
                    La Map des Amigos<span class="text-[#2794EB]">.</span>
                </h2>
                <p class="text-base text-[#333333]/80">
                    Visualise en temps réel les conducteurs autour de toi.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Placeholder visuel de la carte -->
                <div class="w-full lg:w-3/4 bg-gray-100 rounded-[2rem] h-[500px] relative overflow-hidden shadow-2xl border border-gray-200">
                    <!-- Motif de fond de la carte -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;"></div>

                    <!-- Intégration Mapbox -->
                    
                    <!-- Container de la map -->
                    <div id="map" class="w-full h-full z-0 rounded-[2rem]"></div>
                </div>

                <!-- Légende -->
                <div class="w-full lg:w-1/4 space-y-4">
                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="w-10 h-10 bg-[#84cc16] rounded-full flex items-center justify-center text-white shadow-lg border-2 border-white">
                            <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 6.28a1.23 1.23 0 0 0-.62-1.07l-6.74-4a1.27 1.27 0 0 0-1.28 0l-6.75 4a1.25 1.25 0 0 0 0 2.15l1.92 1.12v2.81a1.28 1.28 0 0 0 .62 1.09l4.25 2.45a1.28 1.28 0 0 0 1.24 0l4.25-2.45a1.28 1.28 0 0 0 .62-1.09V8.45l1.24-.73v2.72H16V6.28zm-3.73 5L8 13.74l-4.22-2.45V9.22l3.58 2.13a1.29 1.29 0 0 0 1.28 0l3.62-2.16zM8 10.27l-6.75-4L8 2.26l6.75 4z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Université</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="w-10 h-10 bg-[#2794eb] rounded-full flex items-center justify-center text-white shadow-lg border-2 border-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Départ</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section de contact -->
    <section class="bg-[url('/public/images/img_contact_fond.png')] bg-cover bg-center w-full py-20">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl ml-auto border border-gray-200 rounded-3xl p-20 bg-white backdrop-blur-sm">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        Une question ? <br>
                        Un problème ?
                    </h3>
                    <p class="text-gray-500 text-lg">
                        Contactez-nous maintenant, on sera toujours à <br>votre service !
                    </p>
                </div>

                <!-- Formulaire de contact -->
                <form class="space-y-6">
                    <!-- Email Input -->
                    <div>
                        <input type="email" placeholder="Votre E-mail" class="w-full px-6 py-4 bg-[#F5F5F5] text-gray-900 rounded-xl border-none focus:ring-2 focus:ring-blue-500 outline-none transition placeholder-gray-400 font-medium">
                    </div>
                    <!-- Message Input -->
                    <div>
                        <textarea placeholder="Votre message" rows="4" class="w-full px-6 py-4 bg-[#F5F5F5] text-gray-900 rounded-xl border-none focus:ring-2 focus:ring-blue-500 outline-none transition resize-none placeholder-gray-400 font-medium"></textarea>
                    </div>
                    <!-- Submit Button -->
                    <button class="w-full py-5 bg-[#369AF7] text-white font-bold rounded-xl hover:bg-blue-600 transition shadow-lg shadow-blue-500/25 text-lg">
                        J'envoie dès maintenant !
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Initialisation de l'autocomplétion après le chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof window.setupAutocomplete === 'function') {
                    window.setupAutocomplete('home_start_address', 'home_start_suggestions');
                    window.setupAutocomplete('home_end_address', 'home_end_suggestions');
                }
            }, 100);
        });
    </script>
</x-main-layout>