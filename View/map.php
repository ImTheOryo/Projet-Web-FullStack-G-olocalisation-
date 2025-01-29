    <h1 class="text-center mb-5">Carte de France des points de vente</h1>
    <div id="map"  class="mb-3" style="width: 100%;height: 800px"></div>
    <script src="./Assets/JavaScript/Components/Shared/map.js" type="module"></script>
    <style>
        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
        }
        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }
    </style>
    <script type="module">
        import {showMap, addMarker,addPopUp,addDepartements} from "./Assets/JavaScript/Components/Shared/map.js";
        import {handleSellPoints} from "./Assets/JavaScript/Components/sell_points.js";
        document.addEventListener("DOMContentLoaded", async () => {
            const component = "map"
            const sellPointsInfos = await handleSellPoints(component)
            let map = showMap()
            addDepartements(map)
            for (let i = 0; i < sellPointsInfos['infos'].length; i++){
                const marker = addMarker(map, sellPointsInfos['infos'][i])
                addPopUp(marker, sellPointsInfos['infos'][i])
            }
        })
    </script>