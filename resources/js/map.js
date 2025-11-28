document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('map');

    if (mapElement) {
        var map = L.map('map').setView([49.894, 2.295], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }).addTo(map);
        // University Markers
        var locations = [{
            name: "UPJV Citadelle",
            coords: [49.901, 2.295]
        },
        {
            name: "UPJV Pôle Scientifique",
            coords: [49.880, 2.270]
        },
        {
            name: "UPJV Campus Santé",
            coords: [49.875, 2.280]
        },
        {
            name: "IAE Amiens",
            coords: [49.895, 2.298]
        }
        ];

        // Custom Icon
        var universityIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="w-10 h-10 bg-[#84cc16] rounded-full flex items-center justify-center text-white shadow-lg border-2 border-white">
                        <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 6.28a1.23 1.23 0 0 0-.62-1.07l-6.74-4a1.27 1.27 0 0 0-1.28 0l-6.75 4a1.25 1.25 0 0 0 0 2.15l1.92 1.12v2.81a1.28 1.28 0 0 0 .62 1.09l4.25 2.45a1.28 1.28 0 0 0 1.24 0l4.25-2.45a1.28 1.28 0 0 0 .62-1.09V8.45l1.24-.73v2.72H16V6.28zm-3.73 5L8 13.74l-4.22-2.45V9.22l3.58 2.13a1.29 1.29 0 0 0 1.28 0l3.62-2.16zM8 10.27l-6.75-4L8 2.26l6.75 4z"/>
                        </svg>
                    </div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 20],
            popupAnchor: [0, -20]
        });

        locations.forEach(function (loc) {
            L.marker(loc.coords, { icon: universityIcon }).addTo(map)
                .bindPopup(loc.name);
        });
    }
});
