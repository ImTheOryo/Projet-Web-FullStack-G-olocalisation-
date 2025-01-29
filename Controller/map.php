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
                        header("Content-Type: application/json");
                        echo json_encode(['infos' => $sellPointsInfos]);
                        exit();
                    } else {

                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees"]);
                        exit();
                    }
                case 'getGeoJson':
                    $geoJSON = getGeoJSON($pdo);


                    if (is_array($geoJSON)){
                        header("Content-Type: application/json");
                        echo json_encode(['infos' => $geoJSON]);
                        exit();
                    } else {

                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true,'message' => "Erreur lors des donnees des departements"]);
                        exit();
                    }
            }
        }
    }
    require "View/map.php";