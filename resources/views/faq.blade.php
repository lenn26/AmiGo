<x-main-layout>
    <!-- Page Header -->
    <div class="text-center mt-8 mb-5">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#333333]">Pourquoi AmiGo ?</h1>
    </div>

    <!-- Slider des cartes -->
    <div class="overflow-hidden py-5">
        <div class="flex gap-5 overflow-x-auto px-[5%] pb-12 items-center cursor-grab select-none scroll-container [&::-webkit-scrollbar]:hidden [scrollbar-width:none] [&.active]:cursor-grabbing" id="cardsContainer">
            
            <!-- Card 1 -->
            <div class="info-card group flex-none w-[85vw] max-w-[1200px] h-[70vh] min-h-[500px] rounded-[30px] relative overflow-hidden shadow-2xl flex flex-col justify-end p-10 scale-90 opacity-70 bg-black transition-all duration-200 ease-out">
                <div class="card-image absolute inset-0 w-full h-full bg-cover bg-center z-0 transition-transform duration-700 ease-out group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=800&q=80');"></div>
                <div class="absolute top-8 left-8 z-10 bg-[#C6EF41] text-black font-bold text-base px-4 py-2 rounded-lg">01</div>
                <div class="relative z-10 text-white pointer-events-none">
                    <h3 class="text-4xl md:text-5xl font-bold mb-2 leading-tight">Économies</h3>
                    <p class="text-lg opacity-90 font-normal max-w-xl">Divise les frais d'essence. Garde tes sous pour un kebab.</p>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/90 z-0 pointer-events-none"></div>
            </div>

            <!-- Card 2 -->
            <div class="info-card group flex-none w-[85vw] max-w-[1200px] h-[70vh] min-h-[500px] rounded-[30px] relative overflow-hidden shadow-2xl flex flex-col justify-end p-10 scale-90 opacity-70 bg-black transition-all duration-200 ease-out">
                <div class="card-image absolute inset-0 w-full h-full bg-cover bg-center z-0 transition-transform duration-700 ease-out group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80');"></div>
                <div class="absolute top-8 left-8 z-10 bg-[#C6EF41] text-black font-bold text-base px-4 py-2 rounded-lg">02</div>
                <div class="relative z-10 text-white pointer-events-none">
                    <h3 class="text-4xl md:text-5xl font-bold mb-2 leading-tight">Communauté</h3>
                    <p class="text-lg opacity-90 font-normal max-w-xl">Rencontre des gens de ton campus ou de ton quartier.</p>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/90 z-0 pointer-events-none"></div>
            </div>

            <!-- Card 3 -->
            <div class="info-card group flex-none w-[85vw] max-w-[1200px] h-[70vh] min-h-[500px] rounded-[30px] relative overflow-hidden shadow-2xl flex flex-col justify-end p-10 scale-90 opacity-70 bg-black transition-all duration-200 ease-out">
                <div class="card-image absolute inset-0 w-full h-full bg-cover bg-center z-0 transition-transform duration-700 ease-out group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80');"></div>
                <div class="absolute top-8 left-8 z-10 bg-[#C6EF41] text-black font-bold text-base px-4 py-2 rounded-lg">03</div>
                <div class="relative z-10 text-white pointer-events-none">
                    <h3 class="text-4xl md:text-5xl font-bold mb-2 leading-tight">Écologie</h3>
                    <p class="text-lg opacity-90 font-normal max-w-xl">Moins de voitures dans Amiens, c'est plus d'air pur.</p>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/90 z-0 pointer-events-none"></div>
            </div>

            <!-- Card 4 -->
            <div class="info-card group flex-none w-[85vw] max-w-[1200px] h-[70vh] min-h-[500px] rounded-[30px] relative overflow-hidden shadow-2xl flex flex-col justify-end p-10 scale-90 opacity-70 bg-black transition-all duration-200 ease-out">
                <div class="card-image absolute inset-0 w-full h-full bg-cover bg-center z-0 transition-transform duration-700 ease-out group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1555421689-d68471e189f2?auto=format&fit=crop&w=800&q=80');"></div>
                <div class="absolute top-8 left-8 z-10 bg-[#C6EF41] text-black font-bold text-base px-4 py-2 rounded-lg">04</div>
                <div class="relative z-10 text-white pointer-events-none">
                    <h3 class="text-4xl md:text-5xl font-bold mb-2 leading-tight">Sécurité</h3>
                    <p class="text-lg opacity-90 font-normal max-w-xl">Profils vérifiés. Voyage en toute confiance.</p>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/90 z-0 pointer-events-none"></div>
            </div>

            <!-- Card 5 -->
            <div class="info-card group flex-none w-[85vw] max-w-[1200px] h-[70vh] min-h-[500px] rounded-[30px] relative overflow-hidden shadow-2xl flex flex-col justify-end p-10 scale-90 opacity-70 bg-black transition-all duration-200 ease-out">
                <div class="card-image absolute inset-0 w-full h-full bg-cover bg-center z-0 transition-transform duration-700 ease-out group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=800&q=80');"></div>
                <div class="absolute top-8 left-8 z-10 bg-[#C6EF41] text-black font-bold text-base px-4 py-2 rounded-lg">05</div>
                <div class="relative z-10 text-white pointer-events-none">
                    <h3 class="text-4xl md:text-5xl font-bold mb-2 leading-tight">Rapidité</h3>
                    <p class="text-lg opacity-90 font-normal max-w-xl">Pars quand tu veux, arrive à l'heure.</p>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/90 z-0 pointer-events-none"></div>
            </div>

        </div>
    </div>

    <!-- Option de recherche -->
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
                <button @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900">Puis-je annuler mon trajet ?</span>
                    <span class="text-blue-500 transform transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                <div x-show="active === 3" x-collapse class="px-6 pb-4 text-gray-600">
                    L'annulation est gratuite jusqu'à 24h avant le départ. Passé ce délai, des frais peuvent s'appliquer pour dédommager le conducteur.
                </div>
            </div>

            <!-- Question 4 -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = (active === 4 ? null : 4)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900">Comment contacter le support ?</span>
                    <span class="text-blue-500 transform transition-transform duration-200" :class="active === 4 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                <div x-show="active === 4" x-collapse class="px-6 pb-4 text-gray-600">
                    Tu peux nous contacter via la page Contact ou directement par email à support@amigo-amiens.fr.
                </div>
            </div>
    </section>

</x-main-layout>