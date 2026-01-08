<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté.") }}
                    
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:text-blue-700 underline">
                            Aller à la page de profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
