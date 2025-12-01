<x-main-layout>
    <div class="min-h-screen bg-gray-50 py-12 lg:py-20">
        <div class="container mx-auto px-4 max-w-6xl">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- COLONNE GAUCHE (Infos + FAQ) -->
                <div class="lg:col-span-5 space-y-8">
                    
                    <!-- Carte Coordonnées -->
                    <div class="bg-white rounded-3xl shadow-lg p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-6 h-6 rounded-full bg-[#3499FE] text-white flex items-center justify-center text-xs font-bold">i</div>
                            <h3 class="text-xl font-bold text-gray-800">Nos coordonnées</h3>
                        </div>

                        <div class="space-y-6">
                            <!-- Adresse -->
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#3499FE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Centre AmiGo</h4>
                                    <p class="text-sm text-gray-500 leading-relaxed">
                                        IUT d'Amiens, Département Informatique<br>
                                        Avenue des Facultés, 80000 Amiens
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#8ED630]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Email</h4>
                                    <p class="text-sm text-gray-500">contact@amigo-amiens.fr</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carte FAQ Rapide -->
                    <div class="bg-white rounded-3xl shadow-lg p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">FAQ Rapide</h3>
                        
                        <div class="space-y-4">
                            <div class="pb-4 border-b border-gray-100 flex justify-between items-center cursor-pointer group">
                                <span class="text-gray-600 text-sm group-hover:text-[#3499FE] transition">Comment faire pour réserver un trajet ?</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            <div class="pb-2 flex justify-between items-center cursor-pointer group">
                                <span class="text-gray-600 text-sm group-hover:text-[#3499FE] transition">Est-ce que on peut prendre nos animaux de compagnies ?</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- COLONNE DROITE (Formulaire) -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-12">
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                            Une question ? <br>
                            Un problème ?
                        </h1>
                        <p class="text-gray-500 mb-10 text-lg">
                            Contactez-nous maintenant, on sera toujours à votre service !
                        </p>

                        <form action="#" method="POST" class="space-y-6">
                            <div>
                                <input type="email" placeholder="Votre E-mail" 
                                    class="w-full bg-gray-50 border-none rounded-xl px-6 py-4 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#3499FE] focus:bg-white transition outline-none">
                            </div>
                            
                            <div>
                                <textarea rows="4" placeholder="Votre message" 
                                    class="w-full bg-gray-50 border-none rounded-xl px-6 py-4 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#3499FE] focus:bg-white transition outline-none resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[#3499FE] hover:bg-blue-600 text-white font-bold rounded-xl py-4 transition duration-300 shadow-lg shadow-blue-200">
                                J'envoie dès maintenant !
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-main-layout>
