    <h1 class="text-center mb-5">Carte de France des points de vente</h1>
    <div id="map" style="width: 100%;height: 800px"></div>
    <script src="./Assets/JavaScript/Components/Shared/map.js" type="module"></script>

    <script type="module">
        import {showMap, addMarker} from "./Assets/JavaScript/Components/Shared/map.js";
        import {handleSellPoints} from "./Assets/JavaScript/Components/sell_points.js";
        document.addEventListener("DOMContentLoaded", async () => {
            const component = "map"
            const sellPointsInfos = await handleSellPoints(component)
            let map = showMap(47.1464, 2.8747, 7)
            console.log(sellPointsInfos['infos'][0]['schedule'])
            for (let i = 0; i < sellPointsInfos['infos'].length; i++){
                addMarker(map, sellPointsInfos['infos'][i])
            }
        })
    </script>