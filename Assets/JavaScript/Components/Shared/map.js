
    export const showMap = (x, y, zoom) => {
        let map = L.map('map').setView([x, y], zoom)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
        }).addTo(map)
        return map
    }

    export const addMarker = (map,infos) => {
            let message =  `<h5>${infos['name']}</h5>
                                    <img src="${infos['image']}" alt="The Front of the store" style="width: 200px">
                                    <p>Adresse : ${infos['label']}</p>
                                    Horraire d'ouverture : <br/>
            `
            let schedule = JSON.parse(infos['schedule'])
            schedule.forEach(day => {
            message += `${day.day}: ${day.open} - ${day.close} <br/>`
            })

        const customIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png', // default marker image
            iconSize: [25, 41],  // Size of the marker
            iconAnchor: [12, 41], // The anchor point
            popupAnchor: [1, -34], // The point from which the popup will open
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png', // shadow image
            shadowSize: [41, 41]  // Size of the shadow
        });

            var marker = L.marker([ infos['coordonate_x'], infos['coordonate_y']], {icon: customIcon}).addTo(map)
            marker.bindPopup(message)
    }