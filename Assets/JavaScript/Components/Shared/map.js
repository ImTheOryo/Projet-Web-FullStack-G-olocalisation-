import {DEFAULT_COORDONATE} from "../../Config/constant.js";
import {getGeoJson} from "../../Services/Shared/map.js";

    export const showMap = (x = null, y = null, zoom = null) => {
        x = x === null ? DEFAULT_COORDONATE.x : x
        y = y === null ? DEFAULT_COORDONATE.y : y
        zoom = zoom === null ? DEFAULT_COORDONATE.zoom : zoom

        let map = L.map('map').setView([x, y], zoom)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
        }).addTo(map)
        return map
    }

    export const addDepartements = async (map) => {
        let res = await getGeoJson()
        // console.log(res['infos']['geojson'])
        let data = await JSON.parse( res['infos']['geojson'])
        let geojsonLayer
        let info = L.control()

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        }

        info.update = function (props) {
            this._div.innerHTML = '<h4>Département</h4>' +  (props ?
                '<b>' + props
                : 'Passez sur un département pour voir son nom');
        }
        info.addTo(map)


        const highlightFeature = (e) => {
            const layer = e.target
            layer.setStyle({
                fillColor: '#d3b8ff',
                weight: 3,
                fillOpacity: 0.7
            })
            info.update(layer.feature.properties.nom)
        }


        const resetHighlight = (e) => {
            geojsonLayer.resetStyle(e.target)
           info.update()
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds())
        }



        geojsonLayer = L.geoJSON(data, {
            style: {
                fillColor: '#fae9a3',
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            },
            onEachFeature: (feature, layer) => {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                })

            }
        }).addTo(map)

    }
    export const updateView = (map, info,zoom) => {
        map.setView([info['coordonate_x'], info['coordonate_y']], zoom)

        return map
    }

    export const addMarker = (map,infos = null) => {
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
        let currentColor = infos['color'];

        let marker = L.marker([infos['coordonate_x'], infos['coordonate_y']], {icon: createSvgMarker(currentColor) }).addTo(map)
        return marker
    }

    export const addPopUp = (marker, infos) => {
        let message
        if (infos['name'] !== null){
            message =  `<h5>${infos['name']}</h5>
                                <img src="${infos['image']}" alt="The Front of the store" style="width: 200px">
                                <p>Adresse : ${infos['label']}</p>
                                Horraire d'ouverture : <br/>
            `
            let schedule = JSON.parse(infos['schedule'])
            schedule.forEach(day => {
                message += `${day.day}: ${day.open} - ${day.close} <br/>`
            })
        }

        marker.bindPopup(message)
    }