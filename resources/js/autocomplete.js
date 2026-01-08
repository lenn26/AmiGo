// Logique d'autocomplétion Mapbox
// utilisés dans index.blade.php et propose.blade.php

let customPlaces = [];

// Fonction pour récupérer les lieux depuis l'API
function fetchCustomPlaces() {
    fetch('/api/locations')
        .then(response => response.json())
        .then(data => {
            // Transformation des données API en format compatible
            customPlaces = data.map(uni => ({
                place_name: uni.name + (uni.address ? ` (${uni.address})` : ''),
                center: [parseFloat(uni.longitude), parseFloat(uni.latitude)],
                // On génère des mots-clés basiques à partir du nom
                keywords: uni.name.toLowerCase().split(' ').concat(['universite', 'fac', 'campus'])
            }));
            // On ajoute aussi quelques mots clés spécifiques si besoin dans le futur via la BDD
        })
        .catch(err => console.error('Erreur chargement universités:', err));
}

// Lancement au chargement du script
fetchCustomPlaces();

export function setupAutocomplete(inputId, suggestionsId, latInputId = null, longInputId = null) {
    const input = document.getElementById(inputId);
    const suggestionsList = document.getElementById(suggestionsId);
    // Les champs latitudes/longitudes sont optionnels (utiles pour stocker, mais pas forcément présents sur la home simple)
    const latInput = latInputId ? document.getElementById(latInputId) : null;
    const longInput = longInputId ? document.getElementById(longInputId) : null;

    if (!input || !suggestionsList) return;

    // Clé Mapbox 
    const mapboxAccessToken = "pk.eyJ1IjoiaHh5cGUiLCJhIjoiY21pbDVvOW1uMGo3azNlczF4NDNiMDM4MiJ9.xCqfDte4hRFnmkrLAPC5fQ"; // À idéalement mettre dans .env mais ok pour ici

    let timeoutId;

    // Reset des coordonnées dès qu'on tape quelque chose
    input.addEventListener('input', function() {
        // On vide les champs cachés pour forcer une nouvelle sélection
        if (latInput) latInput.value = '';
        if (longInput) longInput.value = '';

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
            // 1. Recherche dans nos lieux pour étudiants (Custom)
            const qLower = query.toLowerCase();
            const localMatches = customPlaces.filter(p => 
                p.place_name.toLowerCase().includes(qLower) || 
                p.keywords.some(k => qLower.includes(k))
            );

            // 2. Recherche Mapbox standard
            // Suppression de restriction "types" et ajout de limit=10 pour maximiser les résultats pertinents
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${mapboxAccessToken}&country=FR&language=fr&limit=10&proximity=2.2957,49.8940`)
                .then(response => response.json())
                .then(data => {
                    suggestionsList.innerHTML = '';
                    
                    let combinedFeatures = [];

                    // Ajout des résultats personnalisés en premier (avec un marqueur spécial)
                    if (localMatches.length > 0) {
                        localMatches.forEach(lm => {
                            combinedFeatures.push({
                                is_custom: true, // Flag pour le style
                                place_name: lm.place_name,
                                geometry: { coordinates: lm.center }, // Format identique à Mapbox
                                center: lm.center
                            });
                        });
                    }

                    // Ajout des résultats Mapbox
                    if (data.features) {
                        combinedFeatures = combinedFeatures.concat(data.features);
                    }

                    if (combinedFeatures.length > 0) {
                        suggestionsList.classList.remove('hidden');
                        combinedFeatures.forEach((feature, index) => {
                            const item = document.createElement('div');
                            // Style css : petit background différent pour les lieux custom ?
                            const baseClasses = 'px-4 py-3 cursor-pointer text-sm border-b border-gray-100 last:border-0 transition-colors z-50 relative';
                            const hoverClasses = feature.is_custom ? 'bg-green-50 hover:bg-green-100 text-green-900 font-semibold' : 'bg-white hover:bg-gray-50 text-gray-700';
                            
                            item.className = `${baseClasses} ${hoverClasses}`;
                            if (index === 0) item.className += ' rounded-t-xl'; 
                            
                            // Ajout d'une icone ou badge pour les lieux "Campus"
                            if (feature.is_custom) {
                                item.innerHTML = `<span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>${feature.place_name}`;
                            } else {
                                item.textContent = feature.place_name;
                            }
                            
                            // Gestion du clic sur une suggestion
                            item.addEventListener('click', () => {
                                input.value = feature.place_name;
                                suggestionsList.classList.add('hidden');
                                suggestionsList.innerHTML = '';
                                
                                // Enregistrement des coordonnées si les champs existent
                                if (latInput && longInput) {
                                    const [lng, lat] = feature.geometry.coordinates;
                                    latInput.value = lat;
                                    longInput.value = lng;
                                    
                                    // Validation visuelle OK
                                    input.classList.remove('border-red-500', 'border-2');
                                    input.classList.add('border-green-500', 'border-2');
                                    setTimeout(() => input.classList.remove('border-green-500', 'border-2'), 1000);
                                }
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

    // Validation visuelle : Si on quitte le champ sans avoir sélectionné (coordonnées vides)
    input.addEventListener('blur', function() {
        setTimeout(() => {
            if (latInput && !latInput.value && this.value.length > 0) {
                this.classList.add('border-red-500', 'border-2');
            } else {
                this.classList.remove('border-red-500', 'border-2');
            }
        }, 200);
    });

    // Fermeture du dropdown lors d'un clic en dehors
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !suggestionsList.contains(e.target)) {
            suggestionsList.classList.add('hidden');
        }
    });
}
