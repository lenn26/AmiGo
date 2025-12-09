<x-main-layout>
    <!-- Hero Section -->
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-[#333333] mb-12">
                Comment pouvons-nous <br> vous aider ?
            </h1>

            <!-- Search Bar -->
            <div class="max-w-4xl mx-auto relative">
                <div class="relative bg-gradient-to-r from-blue-400 to-[#84CC16] p-2 rounded-full shadow-lg">
                    <div class="rounded-full flex items-center gap-2 p-1">
                        <div class="flex-1 flex items-center bg-white rounded-full px-4 py-3 shadow-sm focus-within:ring-2 focus:ring-blue-500">
                            <svg width="38px" height="38px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M2 6V6.29266C2 7.72154 2.4863 9.10788 3.37892 10.2236L8 16L12.6211 10.2236C13.5137 9.10788 14 7.72154 14 6.29266V6C14 2.68629 11.3137 0 8 0C4.68629 0 2 2.68629 2 6ZM8 8C9.10457 8 10 7.10457 10 6C10 4.89543 9.10457 4 8 4C6.89543 4 6 4.89543 6 6C6 7.10457 6.89543 8 8 8Z" fill="#2794EB" fill-rule="evenodd" />
                            </svg>
                            <input type="text" placeholder="Rechercher une FAQ" class="w-full bg-transparent outline-none focus:ring-0 border-none text-[#333333] placeholder-gray-400 font-medium focus:border-blue-500">
                        </div>
                        <button class="bg-white text-[#333333] px-8 py-4 rounded-full font-bold hover:bg-gray-50 transition shadow-md h-full">
                            GO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Topics -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold text-[#333333] mb-10">Rubriques les plus populaires</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1: Économies -->
            <div class="relative h-80 rounded-3xl overflow-hidden group cursor-pointer shadow-lg">
                <div class="absolute inset-0 bg-gray-800">
                    <!-- Placeholder for image if needed, using dark bg for now -->
                    <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Économies" class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-500">
                </div>
                <div class="absolute inset-0 p-8 flex flex-col justify-between">
                    <div>
                        <span class="bg-[#84CC16] text-white text-xs font-bold px-2 py-1 rounded">01</span>
                        <h3 class="text-white text-2xl font-bold mt-2">Économies</h3>
                    </div>
                    <p class="text-white/80 text-sm">Divise les frais d'essence. Garde tes sous pour un kebab.</p>
                </div>
            </div>

            <!-- Card 2: Communauté -->
            <div class="relative h-80 rounded-3xl overflow-hidden group cursor-pointer shadow-lg">
                <div class="absolute inset-0 bg-blue-600">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Communauté" class="w-full h-full object-cover opacity-60 mix-blend-overlay group-hover:scale-105 transition duration-500">
                </div>
                <div class="absolute inset-0 p-8 flex flex-col justify-between">
                    <div>
                        <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded">02</span>
                        <h3 class="text-white text-2xl font-bold mt-2">Communauté</h3>
                    </div>
                    <p class="text-white/80 text-sm">Rencontre des gens de ton campus ou de ton quartier.</p>
                </div>
            </div>

            <!-- Card 3: Écologie -->
            <div class="relative h-80 rounded-3xl overflow-hidden group cursor-pointer shadow-lg border border-gray-200">
                <div class="absolute inset-0 bg-white">
                    <!-- Minimalist style -->
                </div>
                <div class="absolute inset-0 p-8 flex flex-col justify-between">
                    <div>
                        <span class="bg-black text-white text-xs font-bold px-2 py-1 rounded">03</span>
                        <h3 class="text-gray-900 text-2xl font-bold mt-2">Écologie</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Moins de voitures dans Amiens, c'est plus d'air pur pour tout le monde.</p>
                    <div class="absolute bottom-0 right-0 p-4 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- General FAQ -->
    <section class="container mx-auto px-6 py-16 max-w-4xl">
        <h2 class="text-3xl font-bold text-[#333333] mb-10">Questions fréquentes</h2>

        <div class="space-y-4" x-data="{ active: null }">
            <!-- Question 1 -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = (active === 1 ? null : 1)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900">Comment proposer un trajet ?</span>
                    <span class="text-blue-500 transform transition-transform duration-200" :class="active === 1 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                <div x-show="active === 1" x-collapse class="px-6 pb-4 text-gray-600">
                    C'est très simple ! Connecte-toi, clique sur "Publie ton trajet", renseigne ton point de départ, ton arrivée et ton horaire. C'est tout !
                </div>
            </div>

            <!-- Question 2 -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = (active === 2 ? null : 2)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900">Le paiement est-il sécurisé ?</span>
                    <span class="text-blue-500 transform transition-transform duration-200" :class="active === 2 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                <div x-show="active === 2" x-collapse class="px-6 pb-4 text-gray-600">
                    Oui, toutes les transactions passent par notre partenaire de paiement sécurisé. L'argent est bloqué jusqu'à la validation du trajet.
                </div>
            </div>

            <!-- Question 3 -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <but ton @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                    <spa n class="font-bold text-gray-900">Puis-je annuler mon trajet ?</span>
                        <spa n class="text-blue-500 transform transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <pat h stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                    </sv g>
                                    </sp an>
                                    </bu tton>
                                    <div x-show="active === 3" x-collapse class="px-6 pb-4 text-gray-600">
                                        L'an nulation est gratuite jusqu'à 24h avant le départ. Passé ce délai, des frais peuvent s'appliquer pour dédommager le conducteur.
                                    </div>
                                    </di v>
                                    <!--   Question 4 -->
                                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                        <but ton @click="active = (active === 4 ? null : 4)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                            <span class="font-bold text-gray-900">Comment contacter le support ?</span>
                                            <spa n class="text-blue-500 transform transition-transform duration-200" :class="active === 4 ? 'rotate-180' : ''">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <pat h stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                                        </path>
                                                        </sv g>
                                                        </span>
                                                        </bu tton>
                                                        <div x-show="active === 4" x-collapse class="px-6 pb-4 text-gray-600">
                                                            Tu p eux nous contacter via la page Contact ou directement par email à support@amigo-amiens.fr.
                                                            </di v>
                                                        </div>
                                    </div>
    </section>
</x-main-layout>