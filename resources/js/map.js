document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById("map");

    if (mapElement && typeof mapboxgl !== "undefined") {
        // 1. Configuration de base pour la map
        mapboxgl.accessToken =
            "pk.eyJ1IjoiaHh5cGUiLCJhIjoiY21pbDVvOW1uMGo3azNlczF4NDNiMDM4MiJ9.xCqfDte4hRFnmkrLAPC5fQ";

        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v12",
            center: [2.295753, 49.894067], // Centré sur Amiens
            zoom: 12.5,
        });

        // Ajout des contrôles de navigation (zoom et rotation)
        map.addControl(new mapboxgl.NavigationControl());

        // 2. Liste des universités avec leurs adresses
        const locations = [
            {
                name: "La Citadelle",
                address: "10 Rue des Français Libres, 80080 Amiens",
            },
            {
                name: "Pôle Cathédrale",
                address: "10 Placette Lafleur, 80000 Amiens",
            },
            {
                name: "Pôle Saint-Leu",
                address: "33 rue Saint-Leu, 80000 Amiens",
            },
            {
                name: "Campus Santé",
                address: "Rue du Campus, 80000 Amiens, France",
            },
            {
                name: "IUT Amiens",
                address: "Avenue des Facultés, 80025 Amiens",
            },
            { name: "ESIEE", address: "14 Quai de la Somme, 80080 Amiens" },
        ];

        // 3. Fonction pour géocoder et ajouter le marqueur
        locations.forEach(function (loc) {
            // Appel à l'API de Geocoding Mapbox
            const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(
                loc.address
            )}.json?access_token=${mapboxgl.accessToken}&limit=1`;

            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    if (data.features && data.features.length > 0) {
                        const coords = data.features[0].center; // [Lng, Lat] récupéré automatiquement

                        // Création du logo d'université pour le marqueur
                        const el = document.createElement("div");
                        el.className = "custom-marker";
                        el.innerHTML = `
                            <div class="w-10 h-10 bg-[#84cc16] rounded-full flex items-center justify-center text-white shadow-lg border-2 border-white cursor-pointer hover:scale-110 transition-transform">
                                <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 6.28a1.23 1.23 0 0 0-.62-1.07l-6.74-4a1.27 1.27 0 0 0-1.28 0l-6.75 4a1.25 1.25 0 0 0 0 2.15l1.92 1.12v2.81a1.28 1.28 0 0 0 .62 1.09l4.25 2.45a1.28 1.28 0 0 0 1.24 0l4.25-2.45a1.28 1.28 0 0 0 .62-1.09V8.45l1.24-.73v2.72H16V6.28zm-3.73 5L8 13.74l-4.22-2.45V9.22l3.58 2.13a1.29 1.29 0 0 0 1.28 0l3.62-2.16zM8 10.27l-6.75-4L8 2.26l6.75 4z"/>
                                </svg>
                            </div>
                        `;

                        // Création du popup
                        const popup = new mapboxgl.Popup({
                            offset: 25,
                        }).setHTML(
                            `<div class="p-2">
                                <h3 class="font-bold text-gray-900">${loc.name}</h3>
                                <p class="text-sm text-gray-600 mt-1">${loc.address}</p>
                            </div>`
                        );

                        // Ajout du marqueur sur la carte
                        new mapboxgl.Marker(el)
                            .setLngLat(coords)
                            .setPopup(popup)
                            .addTo(map);
                    } else {
                        console.error("Adresse introuvable :", loc.address);
                    }
                })
                .catch((error) => console.error("Erreur Geocoding :", error));
        });
    }
});
