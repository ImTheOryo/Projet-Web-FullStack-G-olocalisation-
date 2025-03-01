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
                    responseJSON('errors', 'ID au mauvais format');
                }
                $UserInfo = getUserInfo($pdo, $id);
                if (is_array($UserInfo)){
                    responseJSON('infos', $UserInfo);
                } else {
                    responseJSON('errors', 'Erreur lors de la récupération des données : ' . $UserInfo);
                }
            case 'modification':
                $id = (int) cleanString($_GET['id']);
                $data = prepareUserData($_POST);
                $count = verifyUsername($pdo, $data['username'], $id);

                if ($count['user_number'] > 0){
                    responseJSON('errors', 'Username not available');
                }
                if (!empty($data['password']) && !empty($data['password-confirm']) && $data['password'] === $data['password-confirm']){
                   $data['password-confirm'] = '';
                   $pass = changeUserPassword($pdo, $data['password'], $id);
                    if (is_array($pass)){
                        responseJSON('infos', $pass);
                    }
                }

                $res = changeUserInfos($pdo, $id, $data);
                if ($res){
                    responseJSON('success', true);
                } else {
                    responseJSON('errors', 'Erreur lors de la récupération des données : ' . $res);
                }
            case 'create':
                $data = prepareUserData($_POST);
                $count = verifyUsername($pdo, $data['username']);

                if ($count['user_number'] > 0){
                    responseJSON('errors', 'Username not available');
                }
                if ($data['password'] === $data['confirm-password']){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $data['confirm-password'] = '';
                } else {
                    responseJSON('errors', 'Les mots de passe ne correspondent pas');
                }

                $res = createNewUser($pdo, $data);
                if ($res){
                    responseJSON('success', true);
                } else {
                    responseJSON('errors', 'Erreur lors de la création du User');
                }
        }
    }
    require "View/user.php";