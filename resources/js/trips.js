document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById("map");

    if (mapElement && typeof mapboxgl !== "undefined") {
        mapboxgl.accessToken =
            "pk.eyJ1IjoiaHh5cGUiLCJhIjoiY21pbDVvOW1uMGo3azNlczF4NDNiMDM4MiJ9.xCqfDte4hRFnmkrLAPC5fQ";

        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v12",
            center: [2.295753, 49.886], // Amiens
            zoom: 12.5,
        });

        map.addControl(new mapboxgl.NavigationControl());

        let currentMarkers = [];

        // Fonction pour afficher l'itinéraire
        async function getRoute(start, end) {
            const query = await fetch(
                `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`,
                { method: "GET" }
            );
            const json = await query.json();
            const data = json.routes[0];
            const route = data.geometry.coordinates;
            const geojson = {
                type: "Feature",
                properties: {},
                geometry: {
                    type: "LineString",
                    coordinates: route,
                },
            };

            // Si la couche 'route' existe déjà, on la met à jour
            if (map.getSource("route")) {
                map.getSource("route").setData(geojson);
            } else {
                map.addLayer({
                    id: "route",
                    type: "line",
                    source: {
                        type: "geojson",
                        data: geojson,
                    },
                    layout: {
                        "line-join": "round",
                        "line-cap": "round",
                    },
                    paint: {
                        "line-color": "#3887be",
                        "line-width": 5,
                        "line-opacity": 0.75,
                    },
                });
            }

            // Ajuster la vue pour voir tout le trajet
            const bounds = new mapboxgl.LngLatBounds();
            route.forEach((coord) => bounds.extend(coord));
            map.fitBounds(bounds, { padding: 50 });
        }

        // Gestion des clics sur les cartes de trajet
        const tripCards = document.querySelectorAll(".trip-card");
        tripCards.forEach((card) => {
            card.addEventListener("click", () => {
                const startLat = parseFloat(card.dataset.startLat);
                const startLong = parseFloat(card.dataset.startLong);
                const endLat = parseFloat(card.dataset.endLat);
                const endLong = parseFloat(card.dataset.endLong);
                const startAddress = card.dataset.startAddress;
                const endAddress = card.dataset.endAddress;

                if (!startLat || !startLong || !endLat || !endLong) return;

                const start = [startLong, startLat];
                const end = [endLong, endLat];

                // Supprimer les anciens marqueurs
                currentMarkers.forEach((marker) => marker.remove());
                currentMarkers = [];

                // Ajouter les nouveaux marqueurs avec Popup
                const startPopup = new mapboxgl.Popup({ offset: 25 }).setHTML(
                    `<div class="p-2 font-sans">
                        <h3 class="font-bold text-[#70D78D]">Départ</h3>
                        <p class="text-sm text-gray-600 mt-1">${startAddress}</p>
                    </div>`
                );

                const endPopup = new mapboxgl.Popup({ offset: 25 }).setHTML(
                    `<div class="p-2 font-sans">
                        <h3 class="font-bold text-[#2794EB]">Arrivée</h3>
                        <p class="text-sm text-gray-600 mt-1">${endAddress}</p>
                    </div>`
                );

                const startMarker = new mapboxgl.Marker({ color: "#70D78D" })
                    .setLngLat(start)
                    .setPopup(startPopup)
                    .addTo(map);

                const endMarker = new mapboxgl.Marker({ color: "#2794EB" })
                    .setLngLat(end)
                    .setPopup(endPopup)
                    .addTo(map);

                currentMarkers.push(startMarker, endMarker);

                // Tracer la route
                getRoute(start, end);
            });
        });
    }
});
