<x-main-layout>
    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-12 lg:py-20 flex flex-col lg:flex-row items-center gap-12">
        <!-- Text Content -->
        <div class="lg:w-1/2 space-y-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-gray-600">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Nouveau sur Amiens
            </div>

            <h1 class="text-5xl lg:text-6xl font-extrabold text-[#333333] leading-tight">
                T'as pas de voiture ? <br>
                <span class="bg-gradient-to-r from-blue-500 to-green-500 bg-clip-text text-transparent">Trouve un Amigo.</span>
            </h1>

            <p class="text-lg text-[#333333] max-w-lg leading-relaxed">
                Amigo connecte les étudiants d'Amiens pour aller en cours.
                Économise, rencontre du monde, et oublie le bus blindé de 8h.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="#" class="px-8 py-4 bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-600 transition shadow-lg shadow-blue-500/25">
                    Tu cherches un trajet ?
                </a>
                <a href="#" class="px-8 py-4 bg-green-400 text-white font-semibold rounded-xl hover:bg-green-500 transition shadow-lg shadow-green-400/25">
                    Publie ton trajet !
                </a>
            </div>

            <div class="flex items-center gap-8 pt-4 border-t border-gray-100">
                <div>
                    <p class="text-2xl font-bold text-gray-900">450+</p>
                    <p class="text-sm text-gray-500">Trajets / semaine</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">2.5€</p>
                    <p class="text-sm text-gray-500">Prix moyen</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">+400 Étudiants connectés</p>
                    <div class="flex text-blue-500 text-xs">
                        ★★★★★ <span class="text-gray-400 ml-1">4.9/5</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image/Visual Content -->
        <div class="lg:w-1/2 relative">
            <div class="relative z-10 bg-white rounded-[2.5rem] shadow-2xl p-4 max-w-sm mx-auto border-8 border-gray-900">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-xl"></div>
                <div class="h-[600px] bg-gray-50 rounded-[2rem] overflow-hidden flex flex-col relative">
                    <!-- App Header -->
                    <div class="p-6 pt-12 flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Bonjour !</p>
                            <h3 class="font-bold text-xl text-gray-900">Où vas-tu ?</h3>
                        </div>
                        <div class="w-8 h-8 bg-blue-100 rounded-full"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="p-4 bg-blue-500 text-white rounded-xl text-center text-sm font-medium">Tu cherches un trajet ?</div>
                        <div class="p-4 bg-green-400 text-white rounded-xl text-center text-sm font-medium">Publie ton trajet !</div>
                    </div>
                    <div class="mt-8">
                        <h4 class="font-semibold text-gray-900 mb-4">Trajets à venir</h4>
                        <div class="space-y-3">
                            <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full"></div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">Gare du Nord</p>
                                    <p class="text-xs text-gray-500">Départ dans 15 min</p>
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

    <!-- Search Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Ton trajet express<span class="text-green-500">.</span>
            </h2>
            <p class="text-gray-600 mb-8 max-w-2xl">
                Réserve ta place en deux clics et profite d'un trajet confortable vers ton campus.
                Arrive à l'heure, sans le stress des transports.
            </p>

            <div class="bg-gradient-to-r from-blue-400 to-green-400 rounded-[2rem] p-8 shadow-xl">
                <div class="flex flex-col md:flex-row items-center gap-4 bg-white/10 p-2 rounded-xl md:rounded-full backdrop-blur-sm">
                    <!-- Departure -->
                    <div class="flex-1 w-full relative group">
                        <label class="block text-xs text-white ml-4 mb-1 font-medium">Départ</label>
                        <div class="flex items-center bg-white rounded-full px-4 py-3 shadow-sm">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <input type="text" placeholder="Dr. Gare du Nord" class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-400 font-medium">
                        </div>
                    </div>

                    <!-- Swap Icon -->
                    <button class="p-2 text-white hover:bg-white/20 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </button>

                    <!-- Arrival -->
                    <div class="flex-1 w-full relative">
                        <label class="block text-xs text-white ml-4 mb-1 font-medium">Arrivée</label>
                        <div class="flex items-center bg-white rounded-full px-4 py-3 shadow-sm">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8"></path>
                            </svg>
                            <input type="text" placeholder="Dr. Campus Citadelle" class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-400 font-medium">
                        </div>
                    </div>

                    <!-- Submit -->
                    <button class="bg-white text-green-500 font-bold py-3 px-8 rounded-full hover:bg-gray-50 transition shadow-lg mt-6 md:mt-0">
                        GO
                    </button>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-white font-medium">
                    <span class="opacity-80">Prochains :</span>
                    <button class="px-3 py-1 border border-white/30 rounded-full hover:bg-white/10 transition">Gare d'Amiens</button>
                    <button class="px-3 py-1 border border-white/30 rounded-full hover:bg-white/10 transition">CHU Sud</button>
                    <button class="px-3 py-1 border border-white/30 rounded-full hover:bg-white/10 transition">St-Leu</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    La Map des Amigos<span class="text-blue-500">.</span>
                </h2>
                <p class="text-gray-600">
                    Visualise en temps réel les conducteurs autour de toi.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Map Visual Placeholder -->
                <div class="w-full lg:w-3/4 bg-gray-100 rounded-[2rem] h-[500px] relative overflow-hidden shadow-inner border border-gray-200">
                    <!-- Map Background Pattern -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;"></div>

                    <!-- Roads -->
                    <div class="absolute top-1/2 left-0 w-full h-4 bg-white rotate-12 transform -translate-y-1/2"></div>
                    <div class="absolute top-0 left-1/3 h-full w-4 bg-white -rotate-6"></div>
                    <div class="absolute top-1/4 right-0 w-1/2 h-3 bg-white -rotate-3"></div>

                    <!-- Pins -->
                    <div class="absolute top-1/3 left-1/4 transform hover:scale-110 transition cursor-pointer group">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg border-4 border-white z-10 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                            Étudiant
                        </div>
                    </div>

                    <div class="absolute bottom-1/3 right-1/3 transform hover:scale-110 transition cursor-pointer group">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-lg border-4 border-white z-10 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                            Départ imminent
                        </div>
                    </div>

                    <div class="absolute top-1/2 right-1/4 transform hover:scale-110 transition cursor-pointer">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg border-2 border-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="w-full lg:w-1/4 space-y-4">
                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Étudiants</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Départ imminent</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
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

                <!-- Contact Form -->
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
</x-main-layout>