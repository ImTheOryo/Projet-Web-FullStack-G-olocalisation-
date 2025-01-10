
    export const showMap = (x, y, zoom) => {
        let map = L.map('map').setView([x, y], zoom)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
        }).addTo(map)
        return map
    }

    export const addMarker = (map,infos = null) => {
        let message
        if (infos !== null){
                message =  `<h5>${infos['name']}</h5>
                                    <img src="${infos['image']}" alt="The Front of the store" style="width: 200px">
                                    <p>Adresse : ${infos['label']}</p>
                                    Horraire d'ouverture : <br/>
                `
            }
            let schedule = JSON.parse(infos['schedule'])
            schedule.forEach(day => {
            message += `${day.day}: ${day.open} - ${day.close} <br/>`
            })

        const createSvgMarker = (color) => {
            return L.divIcon({
                className: 'custom-icon', // Add a custom class (optional)
                html: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="30" height="30">
  <!-- Pin Body -->
  <path d="M32 4 C22 4, 14 14, 14 24 C14 36, 32 60, 32 60 C32 60, 50 36, 50 24 C50 14, 42 4, 32 4 Z" 
        fill="${color}" />

  <!-- Pin Shadow for Dimensional Effect -->
  <path d="M32 4 C22 4, 14 14, 14 24 C14 36, 32 60, 32 60 C32 60, 36 54, 40 44 C44 36, 42 4, 32 4 Z" 
        fill="dark${color}" opacity="0.5" />

  <!-- Pin Border -->
  <path d="M32 4 C22 4, 14 14, 14 24 C14 36, 32 60, 32 60 C32 60, 50 36, 50 24 C50 14, 42 4, 32 4 Z"
        fill="none" stroke="black" stroke-width="2" />

  <!-- Pin Highlight -->
  <ellipse cx="26" cy="12" rx="6" ry="8" fill="white" opacity="0.6" />
</svg>

      `,
                iconSize: [30, 30], // Set the size of the marker
                iconAnchor: [15, 15] // Anchor the marker to the map position
            });
        };

        // Initialize the marker with an initial color
        let currentColor = 'blue';

            var marker = L.marker([infos['coordonate_x'], infos['coordonate_y']], {icon: createSvgMarker(currentColor) }).addTo(map)
            marker.bindPopup(message)
    }