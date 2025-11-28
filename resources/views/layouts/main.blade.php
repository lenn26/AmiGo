<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AmiGo') }}</title>
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
                    }
                }
            }
        }
    </script>
    @endif
</head>

<body class="font-sans antialiased text-gray-900 bg-white flex flex-col min-h-screen">
    <!-- Header -->
    <header class="container mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Navbar -->
        <div class="flex items-center gap-2">
            <!-- Logo -->
            <div class="w-8 h-8 rounded-full bg-gradient-to-b from-blue-500 to-green-400 flex items-center justify-center text-white font-bold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            </div>
            <span class="text-2xl font-bold text-gray-800 tracking-tight">Ami<span class="text-green-500">Go.</span></span>
        </div>
        <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
            <a href="/" class="hover:text-black transition">Accueil</a>
            <a href="#" class="hover:text-black transition">Réserver un trajet !</a>
            <a href="#" class="hover:text-black transition">FAQ</a>
            <a href="#" class="hover:text-black transition">Contact</a>
        </nav>
        <div class="flex items-center gap-4">
            <a href="{{ route('register') }}" class="text-sm font-medium text-gray-600 hover:text-black transition">Inscription</a>
            <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition shadow-md shadow-blue-500/20">Connexion</a>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-[#1E1E1E] text-white pt-20 pb-3 border-t border-[#1E1E1E]">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-24">
                <!-- Page Links -->
                <div class="text-center">
                    <h4 class="bg-gradient-to-r from-[#2794EB] to-[#379ECF] bg-clip-text text-transparent font-semibold text-5xl mb-8 uppercase tracking-wider">Page</h4>
                    <ul class="space-y-4 text-gray-300 font-semibold text-4xl">
                        <li><a href="/" class="hover:text-white transition">Accueil</a></li>
                        <li><a href="#" class="hover:text-white transition">Réserver un trajet !</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div class="text-center">
                    <h4 class="bg-gradient-to-r from-[#3AA0C9] to-[#54B09B] bg-clip-text text-transparent font-semibold text-5xl mb-8 uppercase tracking-wider">Social</h4>
                    <ul class="space-y-4 text-gray-300 font-semibold text-4xl inline-block text-left">
                        <li class="flex items-center gap-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            </svg>
                            <a href="#" class="hover:text-white transition">Instagram</a>
                        </li>
                        <li class="flex items-center gap-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            </svg>
                            <a href="#" class="hover:text-white transition">Twitter</a>
                        </li>
                        <li class="flex items-center gap-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                            <a href="#" class="hover:text-white transition">Facebook</a>
                        </li>
                    </ul>
                </div>

                <!-- Legal Links -->
                <div class="text-center">
                    <h4 class="bg-gradient-to-r from-[#5CB68A] to-[#6EC26B] bg-clip-text text-transparent font-semibold text-5xl mb-8 uppercase tracking-wider">Légal</h4>
                    <ul class="space-y-4 text-gray-300 font-semibold text-4xl">
                        <li><a href="#" class="hover:text-white transition">Mention légales</a></li>
                        <li><a href="#" class="hover:text-white transition">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition">Conditions d'utilisation</a></li>
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