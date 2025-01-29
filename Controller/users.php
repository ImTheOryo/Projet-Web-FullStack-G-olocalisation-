<?php
/**
 * @var PDO $pdo
 */
    require "Model/users.php";
    require "Model/user.php";
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        $action = cleanString($_GET['action']);
        switch ($action) {
            case 'need_infos':
                $page = isset($_GET['page']) ? cleanString($_GET['page']) : null;
                $limit = isset($_GET['limit']) ? cleanString($_GET['limit']) : null;
                $sortBy  = isset($_GET['sortBy']) ? cleanString($_GET['sortBy']) : null;
                $userInfos = getUsersInfos($pdo, $limit, $page, $sortBy);
                if (is_array($userInfos)){
                    header("Content-Type: application/json");
                    echo json_encode(['infos' => $userInfos]);
                    exit();
                } else {
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees : $sellPointsInfos"]);
                    exit();
                }

            case 'count':
                $count = getUsersCount($pdo);

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
                $deleteUser = deleteUser($pdo, $id);
                if ($deleteUser){
                    header("Content-Type: application/json");
                    echo json_encode(['success' => true]);
                    exit();
                } else {
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => true, 'message' => $deleteUser]);
                    exit();
                }
            default:
                header("Content-Type: application/json");
                echo json_encode(['errors' => true, 'message' => "Action not define"]);
                exit();
        }
    }
    require "View/users.php";
