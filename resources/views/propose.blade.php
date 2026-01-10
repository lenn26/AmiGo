<x-main-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <h1 class="text-5xl font-extrabold text-[#333333] mb-2">
                    T’as de la place ?
                    <br>
                    Partage ton <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#70D78D] via-[#4bc5a7] to-[#2794EB]">Trajet.</span>
                </h1>
                <p class="text-gray-500 mb-8">
                    Ne roule plus à vide vers le campus : propose ton trajet et partage tes frais.
                </p>

                <form action="{{ route('trips.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Affichage des erreurs de validation -->
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-500 p-4 rounded-xl">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Départ / Arrivée -->
                    <div class="space-y-4">
                        <!-- Entrées cachées pour les coordonnées -->
                        <input type="hidden" name="start_lat" id="start_lat" value="{{ old('start_lat') }}">
                        <input type="hidden" name="start_long" id="start_long" value="{{ old('start_long') }}">
                        <input type="hidden" name="end_lat" id="end_lat" value="{{ old('end_lat') }}">
                        <input type="hidden" name="end_long" id="end_long" value="{{ old('end_long') }}">

                        <div class="relative group">
                            <label class="block text-sm font-semibold text-[#333333] mb-2">Départ</label>
                            <input type="text" name="start_address" id="start_address" value="{{ old('start_address') }}" placeholder="Ex: Gare d'Amiens" 
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#70D78D]" autocomplete="off">
                            
                            <!-- Dropdown pour les suggestions -->
                            <div id="start_suggestions" class="absolute z-50 w-full bg-white border border-gray-100 rounded-xl mt-1 shadow-lg hidden overflow-hidden"></div>
                        </div>
                        
                        <div class="relative group">
                            <label class="block text-sm font-semibold text-[#333333] mb-2">Arrivée</label>
                            <div class="relative">
                                <input type="text" name="end_address" id="end_address" value="{{ old('end_address') }}" placeholder="Ex: Campus Santé" 
                                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#70D78D]" autocomplete="off">
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#333333]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                </button>
                            </div>
                            <!-- Dropdown pour les suggestions -->
                            <div id="end_suggestions" class="absolute z-50 w-full bg-white border border-gray-100 rounded-xl mt-1 shadow-lg hidden overflow-hidden"></div>
                        </div>
                    </div>

                    <!-- Date / Heure -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#333333] mb-2">Date</label>
                            <input type="date" name="date" id="date_input" value="{{ old('date') }}"
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#70D78D]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#333333] mb-2">Départ</label>
                            <input type="time" name="time" id="time_input" value="{{ old('time') }}" placeholder="08:00"
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#70D78D]">
                        </div>
                        <div>
                            <!-- Heure d'arrivée estimée (en mode readonly) -->
                            <label class="block text-sm font-semibold text-[#333333] mb-2">Arrivée (Estimée)</label>
                            <input type="time" name="arrival_time" id="arrival_time_input" readonly
                                class="w-full bg-gray-100 border-none rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Prix / Véhicule -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#333333] mb-2">Prix (€)</label>
                            <input type="number" step="0.5" name="price" value="{{ old('price') }}" placeholder="2,00"
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#70D78D]">
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-sm font-semibold text-[#333333]">Véhicule</label>
                                <div class="flex items-center gap-3">
                                    <button type="button" id="refresh_vehicles" class="text-xs text-gray-500 hover:text-[#2794EB] flex items-center transition-colors" title="Rafraîchir la liste">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Actualiser
                                    </button>
                                    <a href="{{ route('profile.edit') }}" class="text-xs text-[#2794EB] hover:underline font-medium" target="_blank">+ Ajouter</a>
                                </div>
                            </div>
                            <select name="vehicle_id" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-[#70D78D]">
                                <option value="" disabled selected>Ton véhicule</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})</option>
                                @endforeach
                            </select>
                             @if($vehicles->isEmpty())
                                <p class="text-xs text-amber-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Aucun véhicule enregistré.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Nombre de places -->
                    <div>
                        <label class="block text-sm font-semibold text-[#333333] mb-2">Places</label>
                        <div class="flex items-center bg-gray-50 rounded-xl px-4 py-2 w-full">
                            <button type="button" class="w-8 h-8 flex items-center justify-center text-[#2794EB] bg-white rounded-full shadow-sm hover:scale-105 transition" onclick="decrementSeats()">-</button>
                            <!-- Input nombre de places (caché le bouton de base : [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none)-->
                            <input type="number" name="seats_available" id="seats_input" value="{{ old('seats_available', 3) }}" class="flex-1 text-center bg-transparent border-none focus:ring-0 text-gray-700 font-bold [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" readonly>
                            <button type="button" class="w-8 h-8 flex items-center justify-center text-[#2794EB] bg-white rounded-full shadow-sm hover:scale-105 transition" onclick="incrementSeats()">+</button>
                        </div>
                    </div>

                    <!-- Options de trajet -->
                    <div>
                        <label class="block text-sm font-semibold text-[#333333] mb-2">Options :</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative w-5 h-5 rounded border border-gray-300 bg-white flex items-center justify-center transition-colors group-hover:border-[#70D78D]">
                                    <input type="checkbox" name="girl_only" class="opacity-0 absolute inset-0 cursor-pointer peer" {{ old('girl_only') ? 'checked' : '' }}>
                                    <svg class="w-full h-full text-white hidden peer-checked:block pointer-events-none bg-[#70D78D] rounded absolute inset-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Fille uniquement</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative w-5 h-5 rounded border border-gray-300 bg-white flex items-center justify-center transition-colors group-hover:border-[#70D78D]">
                                    <input type="checkbox" name="accepts_pets" class="opacity-0 absolute inset-0 cursor-pointer peer" {{ old('accepts_pets') ? 'checked' : '' }}>
                                    <svg class="w-full h-full text-white hidden peer-checked:block pointer-events-none bg-[#70D78D] rounded absolute inset-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Animal de compagnie</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative w-5 h-5 rounded border border-gray-300 bg-white flex items-center justify-center transition-colors group-hover:border-[#70D78D]">
                                    <input type="checkbox" name="accepts_luggage" class="opacity-0 absolute inset-0 cursor-pointer peer" {{ old('accepts_luggage') ? 'checked' : '' }}>
                                    <svg class="w-full h-full text-white hidden peer-checked:block pointer-events-none bg-[#70D78D] rounded absolute inset-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Bagages autorisés</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bouton valider -->
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#70D78D] hover:bg-green-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5">
                            Valider et Publier
                        </button>
                    </div>

                </form>
            </div>

            <!-- Partie de droite -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Mes trajets publiés -->
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-[#333333] mb-6">Mes trajets publiés</h2>
                    
                    <div class="space-y-4">
                        <!-- Boucle sur les trajets de l'utilisateur -->
                        @forelse($userTrips as $trip)
                            <div class="bg-gray-50 rounded-2xl p-4 flex items-center justify-between group hover:bg-white hover:shadow-md transition border border-transparent hover:border-gray-100 cursor-pointer">
                                <div>
                                    <div class="text-sm font-bold text-[#333333] mb-1">
                                        <!-- Date et heure -->
                                        {{ $trip->start_time->format('d M à H\hi') }}
                                    </div>
                                    <div class="text-xs text-gray-500 flex items-center gap-1">
                                         <!-- Adresse -->
                                         {{ Str::limit($trip->start_address, 15) }} &rarr; {{ Str::limit($trip->end_address, 15) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($trip->seats_available == 0)
                                        <span class="text-xs font-bold text-gray-400">Complet</span>
                                    @else
                                        <div class="text-xs font-bold text-[#70D78D]">1 inscrit</div>
                                        <div class="text-[10px] text-gray-400">{{ $trip->seats_available }} places libres</div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">Aucun trajet publié.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('publications') }}" class="text-[#2794EB] text-sm font-bold hover:underline">Voir tout l'historique</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scripts pour :
        // L'autocomplétion des adresses de départ et d'arrivée avec l'API Mapbox
        // L'incrémentation et la décrémentation du nombre de places disponibles

        // Configuration pour utiliser Mapbox
        const mapboxAccessToken = "pk.eyJ1IjoiaHh5cGUiLCJhIjoiY21pbDVvOW1uMGo3azNlczF4NDNiMDM4MiJ9.xCqfDte4hRFnmkrLAPC5fQ"; // Utilisation du token

        function setupAutocomplete(inputId, suggestionsId, latInputId, longInputId) {
            const input = document.getElementById(inputId);
            const suggestionsList = document.getElementById(suggestionsId);
            const latInput = document.getElementById(latInputId);
            const longInput = document.getElementById(longInputId);

            let timeoutId;

            input.addEventListener('input', function() {
                const query = this.value;
                
                // Annuler le timeout précédent
                clearTimeout(timeoutId);

                if (query.length < 3) {
                    suggestionsList.innerHTML = '';
                    suggestionsList.classList.add('hidden');
                    return;
                }

                    // Debounce appel API
                    timeoutId = setTimeout(() => {
                    fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${mapboxAccessToken}&country=FR&language=fr&types=place,address,poi`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsList.innerHTML = '';
                            if (data.features && data.features.length > 0) {
                                suggestionsList.classList.remove('hidden');
                                data.features.forEach(feature => {
                                    const item = document.createElement('div');
                                    // Style css (avec tailwind) pour chaque suggestion
                                    item.className = 'px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0 transition-colors';
                                    item.textContent = feature.place_name;
                                    
                                    // Gestion du clic sur une suggestion
                                    item.addEventListener('click', () => {
                                        input.value = feature.place_name;
                                        suggestionsList.classList.add('hidden');
                                        
                                        // Enregistrement des coordonnées
                                        const [lng, lat] = feature.geometry.coordinates;
                                        latInput.value = lat;
                                        longInput.value = lng;

                                        // Recalculer la durée si toutes les infos sont là
                                        calculateRouteDuration();
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

            // Fermeture du dropdown lors d'un clic en dehors
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !suggestionsList.contains(e.target)) {
                    suggestionsList.classList.add('hidden');
                }
            });
        }

        // Initialisation des autocomplétions
        document.addEventListener('DOMContentLoaded', function() {
            setupAutocomplete('start_address', 'start_suggestions', 'start_lat', 'start_long');
            setupAutocomplete('end_address', 'end_suggestions', 'end_lat', 'end_long');

            // Ecouteur sur le changement de l'heure de départ pour recalculer l'heure d'arrivée
            const timeInput = document.getElementById('time_input');
            if(timeInput) {
                timeInput.addEventListener('change', calculateRouteDuration);
            }

            // Gestion du rafraîchissement des véhicules
            document.getElementById('refresh_vehicles')?.addEventListener('click', function() {
                const btn = this;
                const select = document.querySelector('select[name="vehicle_id"]');
                const originalText = btn.innerHTML;
                
                // Etat de chargement
                btn.innerHTML = '<svg class="animate-spin w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Chargement...';
                btn.classList.add('cursor-not-allowed', 'opacity-75');
                btn.disabled = true;
                
                fetch('{{ route("api.user.vehicles") }}')
                    .then(response => response.json())
                    .then(data => {
                        const currentVal = select.value;
                        
                        // Vider la liste (sauf le placeholder)
                        select.innerHTML = '<option value="" disabled>Ton véhicule</option>';
                        
                        // Gérer le message "Aucun véhicule"
                        const container = select.parentElement;
                        const existingMsg = container.querySelector('.text-amber-600');
                        
                        if (data.length === 0) {
                            if(!existingMsg) {
                                const msg = document.createElement('p');
                                msg.className = "text-xs text-amber-600 mt-1 flex items-center";
                                msg.innerHTML = '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>Aucun véhicule enregistré.';
                                container.appendChild(msg);
                            }
                            select.value = "";
                        } else {
                            if(existingMsg) existingMsg.remove();
    
                            data.forEach(vehicle => {
                                const option = document.createElement('option');
                                option.value = vehicle.id;
                                option.textContent = `${vehicle.make} ${vehicle.model} (${vehicle.license_plate})`;
                                if (vehicle.id == currentVal) option.selected = true;
                                select.appendChild(option);
                            });
                            
                            // Sélectionner le dernier ajouté si rien n'était sélectionné
                            if (!currentVal && data.length > 0) {
                                select.value = data[data.length - 1].id; 
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Impossible de récupérer les véhicules.');
                    })
                    .finally(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('cursor-not-allowed', 'opacity-75');
                        btn.disabled = false;
                    });
            });
        });

        // 1. Fonction pour calculer la durée du trajet via l'API Directions de Mapbox
        function calculateRouteDuration() {
            const startLat = document.getElementById('start_lat').value;
            const startLong = document.getElementById('start_long').value;
            const endLat = document.getElementById('end_lat').value;
            const endLong = document.getElementById('end_long').value;
            const timeInput = document.getElementById('time_input');
            
            // Vérification que toutes les données sont présentes
            if (!startLat || !startLong || !endLat || !endLong || !timeInput.value) return;

            const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${startLong},${startLat};${endLong},${endLat}?access_token=${mapboxAccessToken}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.routes && data.routes.length > 0) {
                        const durationSeconds = data.routes[0].duration;
                        updateArrivalTimeField(durationSeconds);
                    }
                })
                .catch(err => console.error('Error calculating route:', err));
        }

        // 2. Fonction pour mettre à jour le champ heure d'arrivée estimée
        function updateArrivalTimeField(durationSeconds) {
            const timeInput = document.getElementById('time_input');
            const arrivalInput = document.getElementById('arrival_time_input');
            
            if (!timeInput.value) return;

            const [hours, minutes] = timeInput.value.split(':').map(Number);
            const date = new Date();
            date.setHours(hours, minutes, 0, 0);

            // Ajout de la durée (secondes * 1000 pour ms)
            const arrivalDate = new Date(date.getTime() + (durationSeconds * 1000));

            // Format en HH:mm
            const arrivalHours = String(arrivalDate.getHours()).padStart(2, '0');
            const arrivalMinutes = String(arrivalDate.getMinutes()).padStart(2, '0');

            arrivalInput.value = `${arrivalHours}:${arrivalMinutes}`;
        }

        // Fonction pour incrémenter le nombre de places
        function incrementSeats() {
            const input = document.getElementById('seats_input');
            let val = parseInt(input.value);
            if (val < 8) input.value = val + 1;
        }

        // Fonction pour décrémenter le nombre de places
        function decrementSeats() {
            const input = document.getElementById('seats_input');
            let val = parseInt(input.value);
            if (val > 1) input.value = val - 1;
        }

        // Définir la date minimale comme aujourd'hui
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector("input[name='date']");
            if (dateInput) {
                const today = new Date();
                today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
                dateInput.min = today.toISOString().split('T')[0];
            }
        });
    </script>
</x-main-layout>
