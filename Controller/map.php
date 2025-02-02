<?php
/**
 * @var PDO $pdo
 */
    require "Model/map.php";
    require "Model/sell_points.php";

    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        if (!empty($_GET['action'])){
            switch ($_GET['action']) {
                case 'need_infos':
                    $sellPointsInfos = getSellPointsInfos($pdo);

                    if (is_array($sellPointsInfos)){
                        responseJSON('infos', $sellPointsInfos);
                    } else {
                        responseJSON('errors', 'Erreur lors de la récupération des données');
                    }
                case 'getGeoJson':
                    $geoJSON = getGeoJSON($pdo);

                    if (is_array($geoJSON)){
                        responseJSON('infos', $geoJSON);
                    } else {
                        responseJSON('errors', 'Erreur lors de la récupération des données départementales');
                    }
            }
        }
    }
    require "View/map.php";