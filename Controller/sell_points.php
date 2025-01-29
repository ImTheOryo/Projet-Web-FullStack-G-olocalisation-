<?php
/**
 * @var PDO $pdo
 */
    require "Model/sell_points.php";
    require "Model/sell_point.php";

    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        if (!empty($_GET['action'])){
            switch ($_GET['action']){
                case 'need_infos':
                    $page = isset($_GET['page']) ? cleanString($_GET['page']) : null;
                    $limit = isset($_GET['limit']) ? cleanString($_GET['limit']) : null;
                    $sortBy  = isset($_GET['sortBy']) ? cleanString($_GET['sortBy']) : null;
                    $sellPointsInfos = getSellPointsInfos($pdo,$limit, $page, $sortBy);

                    if (is_array($sellPointsInfos)){
                        header("Content-Type: application/json");
                        echo json_encode(['infos' => $sellPointsInfos]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees : $sellPointsInfos"]);
                        exit();
                    }

                case 'count':
                        $count = getSellPointsCount($pdo);

                        if (is_array($count)){
                            header("Content-Type: application/json");
                            echo json_encode(['infos' => $count]);
                            exit();
                        } else {
                            header("Content-Type: application/json");
                            echo json_encode(['errors' => true,'message' => "Erreur lors du comptage"]);
                            exit();
                        }
                case 'delete':
                    $id = isset($_GET['id']) ? (int)cleanString($_GET['id']) : null;
                    if (!is_int($id)){
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true, 'message' => "ID est donner au mauvais format"]);
                        exit();
                    }
                    $deleteSellPoint = deleteSellPoint($pdo, $id);
                    if ($deleteSellPoint){
                        header("Content-Type: application/json");
                        echo json_encode(['success' => true]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true, 'message' => $deleteSellPoint]);
                        exit();
                    }
                default:
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => true, 'message' => "Action not define"]);
                    exit();
            }

        }
    }
    require "View/sell_points.php";
