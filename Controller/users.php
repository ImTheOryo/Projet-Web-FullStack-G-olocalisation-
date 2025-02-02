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
                    responseJSON('infos', $userInfos);
                } else {
                    responseJSON('errors', 'Erreur lors de le récupération des données');
                }

            case 'count':
                $count = getUsersCount($pdo);

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
                $deleteUser = deleteUser($pdo, $id);
                if ($deleteUser){
                    responseJSON('success', true);
                } else {
                    responseJSON('errors', $deleteUser);
                }
            default:
                responseJSON('errors', 'Action inconnu');
        }
    }
    require "View/users.php";
