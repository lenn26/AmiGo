<x-main-layout>
    <!-- J'ai mis justify-start (au lieu de center) et ajouté pt-40 pour le placer plus haut -->
    <div class="flex flex-col items-center justify-start min-h-screen pt-40 px-4 text-center">
        <h1 class="text-9xl font-bold bg-gradient-to-r from-[#3499FE] to-[#8ED630] bg-clip-text text-transparent mb-4">404.</h1>
        <h2 class="text-5xl font-bold text-gray-800 mb-3">Oups, fausse route.</h2>
        <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
            Il semblerait que ce trajet n'existe pas ou que le conducteur se soit perdu. Pas de panique, fais demi-tour !
        </p>
        
        <a href="/" class="inline-block px-10 py-4 text-lg font-bold text-white bg-gradient-to-r from-[#3499FE] to-[#8ED630] rounded-full shadow-lg hover:opacity-90 transition-transform hover:scale-105">
            Retourner à l'accueil
        </a>
    </div>
</x-main-layout>
