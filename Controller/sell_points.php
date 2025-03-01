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
                        responseJSON('infos', $sellPointsInfos);
                    } else {
                        responseJSON('errors', 'Erreur lors de la récupération des données : ' . $sellPointsInfos);
                    }

                case 'count':
                        $count = getSellPointsCount($pdo);

                        if (is_array($count)){
                            responseJSON('infos', $count);
                        } else {
                            responseJSON('errors', 'Erreur lors du compte');
                        }
                case 'delete':
                    $id = isset($_GET['id']) ? (int)cleanString($_GET['id']) : null;
                    if (!is_int($id)){
                        responseJSON('errors', 'ID au mauvais format');
                    }
                    $deleteSellPoint = deleteSellPoint($pdo, $id);
                    if ($deleteSellPoint){
                        responseJSON('success', true);
                    } else {
                        responseJSON('errors', 'Erreur lors de la suppression');
                    }
                default:
                    responseJSON('errors', 'Action invalide');
            }

        }
    }
    require "View/sell_points.php";
