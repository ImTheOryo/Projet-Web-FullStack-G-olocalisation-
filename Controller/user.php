<?php
/**
 * @var PDO $pdo
 */
    require "Model/user.php";

    function prepareUserData($info)
    {
        $tab['username'] = isset($info["username"]) ? cleanString($info["username"]) : null;
        $tab['mail'] = isset($info["mail"]) ? cleanString($info["mail"]) : null;
        $tab['password'] = !empty($info["password"]) ? cleanString($info["password"]) : null;
        $tab['confirm-password'] = !empty($info["password-confirm"]) ? cleanString($info["password-confirm"]) : null;
        $tab['enabled'] = isset($info["enabled"]) ? cleanString($info["enabled"]) : null;
        return $tab;
    }

    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        $action = cleanString($_GET['action']);
        switch ($action) {
            case 'modify':
                $id = (int) cleanString($_GET['id']);
                if (!is_numeric($id)){
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => 'ID au mauvais format']);
                    exit();
                }
                $UserInfo = getUserInfo($pdo, $id);
                if (is_array($UserInfo)){
                    header("Content-Type: application/json");
                    echo json_encode(['infos' => $UserInfo]);
                    exit();
                } else {
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees : $UserInfo"]);
                    exit();
                }
            case 'modification':
                $id = (int) cleanString($_GET['id']);
                $data = prepareUserData($_POST);
                $count = verifyUsername($pdo, $data['username'], $id);

                if ($count['user_number'] > 0){
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => 'Le Username est deja utilise']);
                    exit();
                }
                if (!empty($data['password']) && !empty($data['password-confirm']) && $data['password'] === $data['password-confirm']){
                   $data['password-confirm'] = '';
                   $pass = changeUserPassword($pdo, $data['password'], $id);
                    if (is_array($pass)){
                        header("Content-Type: application/json");
                        echo json_encode(['infos' => $pass]);
                        exit();
                    }
                }

                $res = changeUserInfos($pdo, $id, $data);
                if ($res){
                    header("Content-Type: application/json");
                    echo json_encode(['success' => true]);
                    exit();
                } else {
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees : $res"]);
                    exit();
                }
            case 'create':
                $data = prepareUserData($_POST);
                $count = verifyUsername($pdo, $data['username']);

                if ($count['user_number'] > 0){
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => 'Le Username est deja utilise']);
                    exit();
                }
                if ($data['password'] === $data['confirm-password']){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $data['confirm-password'] = '';
                } else {
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => 'Les mots de passe ne correspondent pas']);
                    exit();
                }

                $res = createNewUser($pdo, $data);
                if ($res){
                    header("Content-Type: application/json");
                    echo json_encode(['success' => true]);
                    exit();
                } else {
                    header("Content-Type: application/json");
                    echo json_encode(['errors' => true,'message' => "Erreur lors de la creation du user : $res"]);
                    exit();
                }
        }
    }
    require "View/user.php";