<?php
/**
 * @var PDO $pdo
 */
    require "Model/sell_point.php";
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        if (!empty($_GET['action'])){
            switch ($_GET['action']){
                case 'modify':
                    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;
                    $sellPointInfo = getSellPointInfos($pdo, $id);
                    if (is_array($sellPointInfo)){
                        header("Content-Type: application/json");
                        echo json_encode(['infos' => $sellPointInfo]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees : $sellPointInfo"]);
                        exit();
                    }

            }
        }
    }
    require "View/sell_point.php";