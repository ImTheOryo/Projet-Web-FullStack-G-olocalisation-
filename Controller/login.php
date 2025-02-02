<?php
/**
 * @var PDO $pdo
 */
    require "Model/login.php";

    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        $username = !empty($_POST['username']) ? cleanString($_POST['username']) : null;
        $password = !empty($_POST['password']) ? cleanString($_POST['password']) : null;

        if (!empty($_GET['action']) && $_GET['action'] === "verify"){
            $userInfos = getUser($pdo, $username);
            if (is_array($userInfos) && password_verify($password, $userInfos['password'])){
                $_SESSION['auth'] = true;
                $_SESSION['user_id'] = $userInfos['id'];
                $_SESSION['user_username'] = $userInfos['username'];
                responseJSON('auth', true);
            } else {
                responseJSON('errors', 'l\'identification a échoué' );
            }
        }
        }

    require "View/login.php";
