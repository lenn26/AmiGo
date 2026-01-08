<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'AmiGo') }}</title>
   
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
        </style>
    @endif
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="absolute z-20 w-64 h-full bg-white border-r border-gray-200 transition-transform duration-300 md:relative md:translate-x-0 flex flex-col">
            <div class="p-6 flex justify-between items-center gap-2">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="AmiGo Logo" class="h-8 w-auto">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#333333]">AmiGo<span class="text-[#8ED630]">.</span>
                        <span class="text-gray-400 text-sm ml-1">Admin</span></a>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg group hover:bg-blue-50 hover:text-[#2794eb] {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-[#2794eb]' : 'text-gray-400 group-hover:text-[#2794eb]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.trips') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg group hover:bg-blue-50 hover:text-[#2794eb] {{ request()->routeIs('admin.trips') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.trips') ? 'text-[#2794eb]' : 'text-gray-400 group-hover:text-[#2794eb]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Gestion trajets
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg group hover:bg-blue-50 hover:text-[#2794eb] {{ request()->routeIs('admin.users') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users') ? 'text-[#2794eb]' : 'text-gray-400 group-hover:text-[#2794eb]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Utilisateurs
                </a>
                <a href="{{ route('admin.campus') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg group hover:bg-blue-50 hover:text-[#2794eb] {{ request()->routeIs('admin.campus') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.campus') ? 'text-[#2794eb]' : 'text-gray-400 group-hover:text-[#2794eb]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Campus & Map
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg group hover:bg-blue-50 hover:text-[#2794eb] {{ request()->routeIs('admin.reports') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reports') ? 'text-[#2794eb]' : 'text-gray-400 group-hover:text-[#2794eb]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Signalements
                </a>

            </nav>
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-[#2794eb] flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->first_name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->first_name ?? 'Admin' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-xs text-gray-500 hover:text-red-500">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Mobile Header -->
            <header class="bg-white border-b border-gray-200 p-4 md:hidden flex justify-between items-center z-10">
                 <a href="{{ route('home') }}" class="text-xl font-bold text-[#2794eb]">AmiGo</a>
                 <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                 </button>
            </header>
            
            <!-- Overlay for mobile sidebar -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-10 md:hidden" style="display: none;"></div>

            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
