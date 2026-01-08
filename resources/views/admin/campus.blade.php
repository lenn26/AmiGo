@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Campus & Map</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Liste des campus -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Liste des lieux enregistrés</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Adresse</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <!-- Boucle pour afficher les campus -->
                                @forelse($campuses as $campus)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $campus->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $campus->type ?? 'Lieu' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ Str::limit($campus->address, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('admin.campus.delete', $campus) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lieu ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Si aucun campus n'est trouvé -->
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                        Aucun lieu enregistré.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    @if($campuses->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $campuses->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Formulaire d'ajout -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Ajouter un lieu</h2>
                    <form action="{{ route('admin.campus.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Entrée cachée pour latitude et longitude -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nom du lieu</label>
                            <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Ex: Campus Citadelle" required>
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Adresse</label>
                            <input type="text" name="address" id="address_input" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Rechercher une adresse..." autocomplete="off" required>
                             <!-- Dropdown pour les suggestions -->
                             <div id="suggestions" class="absolute z-50 w-full bg-white border border-gray-100 rounded-xl mt-1 shadow-lg hidden overflow-hidden"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                            <select name="type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                <option value="University">Université</option>
                                <option value="Gare">Gare</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const mapboxAccessToken = "pk.eyJ1IjoiaHh5cGUiLCJhIjoiY21pbDVvOW1uMGo3azNlczF4NDNiMDM4MiJ9.xCqfDte4hRFnmkrLAPC5fQ";

        function setupAutocomplete(inputId, suggestionsId, latInputId, longInputId) {
            const input = document.getElementById(inputId);
            const suggestionsList = document.getElementById(suggestionsId);
            const latInput = document.getElementById(latInputId);
            const longInput = document.getElementById(longInputId);

            let timeoutId;

            input.addEventListener('input', function() {
                const query = this.value;
                clearTimeout(timeoutId);

                if (query.length < 3) {
                    suggestionsList.innerHTML = '';
                    suggestionsList.classList.add('hidden');
                    return;
                }

                timeoutId = setTimeout(() => {
                    fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${mapboxAccessToken}&country=FR&language=fr&types=place,address,poi`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsList.innerHTML = '';
                            if (data.features && data.features.length > 0) {
                                suggestionsList.classList.remove('hidden');
                                data.features.forEach(feature => {
                                    const item = document.createElement('div');
                                    item.className = 'px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0 transition-colors';
                                    item.textContent = feature.place_name;
                                    
                                    item.addEventListener('click', () => {
                                        input.value = feature.place_name;
                                        suggestionsList.classList.add('hidden');
                                        const [lng, lat] = feature.geometry.coordinates;
                                        latInput.value = lat;
                                        longInput.value = lng;
                                    });
                                    
                                    suggestionsList.appendChild(item);
                                });
                            } else {
                                suggestionsList.classList.add('hidden');
                            }
                        })
                        .catch(err => console.error('Erreur Geocoding:', err));
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !suggestionsList.contains(e.target)) {
                    suggestionsList.classList.add('hidden');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupAutocomplete('address_input', 'suggestions', 'latitude', 'longitude');
        });
    </script>
@endsection
