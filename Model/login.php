<?php
    function getUser(PDO $pdo, string $username)
    {
        $state = $pdo -> prepare("SELECT * FROM users WHERE username = :username");
        $state -> bindParam(':username', $username);
        try {
            $state -> execute();
            return $state -> fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }