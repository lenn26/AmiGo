<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AmiGo') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="{{ asset('images/logo.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    <!-- Importation de police -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        'amigo-blue': '#2794EB',
                        'amigo-green': '#70D78D',
                    },
                    keyframes: {
                        'underline-grow': {
                            '0%': {
                                width: '0%'
                            },
                            '100%': {
                                width: '100%'
                            },
                        }
                    },
                    animation: {
                        'underline-grow': 'underline-grow 0.3s ease-in-out',
                    }
                }
            }
        }
    </script>
    @endif
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    <!-- Chargement Global -->
    <div id="global-loader" class="fixed inset-0 z-[100] bg-white flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative w-24 h-24">
            <div class="absolute top-0 left-0 w-full h-full border-4 border-gray-100 rounded-full"></div>
            <div class="absolute top-0 left-0 w-full h-full border-4 border-[#2794EB] rounded-full animate-spin border-t-transparent"></div>
            <img src="{{ asset('images/logo.png') }}" alt="Loading..." class="w-10 h-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse">
        </div>
        <p class="mt-4 text-[#333333] font-medium text-lg animate-pulse">Préchauffage du moteur...</p>
    </div>

    <!-- En-tête -->
    <header id="main-navbar" class="w-full py-6 px-4 flex justify-center sticky top-0 z-50 pointer-events-none transition-transform duration-300" x-data="{ open: false }">
        <div class="w-full max-w-7xl bg-white rounded-[2rem] md:rounded-full shadow-xl px-8 py-4 flex flex-col md:flex-row items-center justify-between border border-gray-100 pointer-events-auto relative">
            <div class="w-full md:w-auto flex items-center justify-between">
                <!-- Navbar -->
                <div class="flex items-center gap-2">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-full object-cover">
                        <span class="text-3xl font-bold text-[#333333] tracking-tight">AmiGo<span class="text-[#8ED630]">.</span></span>
                    </a>
                </div>

                <!-- Bouton Menu Mobile -->
                <button @click="open = !open" class="group md:hidden flex flex-col justify-center items-center gap-1.5 w-10 h-10 z-50 focus:outline-none">
                    <div class="w-6 h-0.5 bg-[#333333] transition-all duration-300 origin-center" :class="{ 'group-hover:rotate-45 group-hover:translate-y-2': open }"></div>
                    <div class="w-6 h-0.5 bg-[#333333] transition-all duration-300" :class="{ 'group-hover:opacity-0': open }"></div>
                    <div class="w-6 h-0.5 bg-[#333333] transition-all duration-300 origin-center" :class="{ 'group-hover:-rotate-45 group-hover:-translate-y-2': open }"></div>
                </button>
            </div>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-8 text-base font-medium text-[#333333]">
                <a href="/" class="relative group @if(request()->is('/')) text-[#3499FE] font-semibold @else hover:text-black @endif transition">
                    Accueil
                    <!-- Animation quand on passe la souris sur la navbar -->
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#3499FE] origin-right scale-x-0 transition-transform duration-300 group-hover:scale-x-100 group-hover:origin-left"></span>
                </a>
                <a href="#" class="relative group @if(request()->is('trajets*')) text-[#3499FE] font-semibold @else hover:text-black @endif transition">
                    Mes trajets
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#3499FE] origin-right scale-x-0 transition-transform duration-300 group-hover:scale-x-100 group-hover:origin-left"></span>
                </a>
                <a href="{{ route('faq') }}" class="relative group @if(request()->is('faq*')) text-[#3499FE] font-semibold @else hover:text-black @endif transition">
                    FAQ
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#3499FE] origin-right scale-x-0 transition-transform duration-300 group-hover:scale-x-100 group-hover:origin-left"></span>
                </a>
                <a href="{{ route('contact') }}" class="relative group @if(request()->is('contact*')) text-[#3499FE] font-semibold @else hover:text-black @endif transition">
                    Contact
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#3499FE] origin-right scale-x-0 transition-transform duration-300 group-hover:scale-x-100 group-hover:origin-left"></span>
                </a>
            </nav>
            
            <!-- Login -->
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('register') }}" class="text-base font-medium text-[#333333] hover:text-black transition">Inscription</a>
                <a href="{{ route('login') }}" class="px-6 py-2 bg-[#2794EB] text-white text-base font-semibold rounded-lg hover:bg-blue-600 transition shadow-md shadow-blue-500/20">Connexion</a>
            </div>

            <!-- Menu Déroulant Mobile -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="w-full md:hidden flex flex-col gap-4 pt-6 pb-2 border-t border-gray-100 mt-4">
                
                <x-mobile-nav-link href="/" :active="request()->is('/')">Accueil</x-mobile-nav-link>
                <x-mobile-nav-link href="#" :active="request()->is('trajets*')">Mes trajets</x-mobile-nav-link>
                <x-mobile-nav-link :href="route('faq')" :active="request()->is('faq*')">FAQ</x-mobile-nav-link>
                <x-mobile-nav-link :href="route('contact')" :active="request()->is('contact*')">Contact</x-mobile-nav-link>
                
                <div class="flex flex-col gap-3 mt-2">
                    <a href="{{ route('register') }}" class="text-center text-base font-medium text-[#333333] hover:text-black transition py-2">Inscription</a>
                    <a href="{{ route('login') }}" class="text-center px-6 py-3 bg-[#2794EB] text-white text-base font-semibold rounded-lg hover:bg-blue-600 transition shadow-md shadow-blue-500/20">Connexion</a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer id="main-footer" class="bg-[#1E1E1E] text-white pt-20 pb-3 border-t border-[#1E1E1E]">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-24">
                <!-- Page Links -->
                <div class="text-center">
                    <h4 class="bg-gradient-to-r from-[#2794EB] to-[#379ECF] bg-clip-text text-transparent font-semibold text-5xl mb-8 uppercase tracking-wider relative inline-block group pb-2">Page<span class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-[#2794EB] to-[#379ECF] group-hover:w-full transition-all duration-300"></span></h4>
                    <ul class="space-y-4 text-gray-300 font-medium text-3xl">
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="/" class="hover:text-white transition">Accueil</a></li>
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="#" class="hover:text-white transition">Mes trajets</a></li>
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="{{ route('faq') }}" class="hover:text-white transition">FAQ</a></li>
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div class="text-center">
                    <h4 class="bg-gradient-to-r from-[#3AA0C9] to-[#54B09B] bg-clip-text text-transparent font-semibold text-5xl mb-8 uppercase tracking-wider relative inline-block group pb-2 pt-2">Social<span class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-[#3AA0C9] to-[#54B09B] group-hover:w-full transition-all duration-300"></span></h4>
                    <ul class="space-y-4 text-gray-300 font-medium text-3xl flex flex-col items-start justify-center mx-auto w-fit">
                        <li class="flex items-center gap-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            </svg>
                            <a href="#" class="hover:text-white transition">Instagram</a>
                        </li>
                        <li class="flex items-center gap-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            </svg>
                            <a href="#" class="hover:text-white transition">X</a>
                        </li>
                        <li class="flex items-center gap-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                            <a href="#" class="hover:text-white transition">Facebook</a>
                        </li>
                    </ul>
                </div>

                <!-- Legal Links -->
                <div class="text-center">
                    <h4 class="bg-gradient-to-r from-[#5CB68A] to-[#6EC26B] bg-clip-text text-transparent font-semibold text-5xl mb-8 uppercase tracking-wider relative inline-block group pb-2 pt-2">Légal<span class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-[#5CB68A] to-[#6EC26B] group-hover:w-full transition-all duration-300"></span></h4>
                    <ul class="space-y-4 text-gray-300 font-medium text-3xl">
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="#" class="hover:text-white transition">Mention légales</a></li>
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="#" class="hover:text-white transition">Confidentialité</a></li>
                        <li class="transition-transform duration-300 hover:-translate-y-1"><a href="#" class="hover:text-white transition">Conditions d'utilisation</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center pt-4">
                <!-- Logo Section -->
                <div class="flex items-center gap-14 mb-16 select-none">
                    <!-- Image logo AmiGo -->
                    <div class="w-48 h-48 md:w-72 md:h-72 rounded-full flex items-center justify-center relative overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>

                    <!-- Texte AmiGo -->
                    <span class="text-[5rem] sm:text-[7rem] md:text-[11rem] lg:text-[20rem] font-bold text-[#333333] leading-none tracking-normal">
                        AmiGo<span class="text-[#84CC16]">.</span>
                    </span>
                </div>

                <div class="w-full border-t-[1.5px] border-[#474747] mt-16 mb-6"></div>

                <p class="text-[#D9DBE1] text-sm text-left w-full">
                    &copy; 2025 AmiGo. Tout droits réservés.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>