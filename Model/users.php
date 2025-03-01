<?php

    function getUsersInfos (PDO $pdo, null | int $limit = null, null | int $page = null, null | string $sortBy = null)
    {
        $query = 'SELECT users.id, users.mail, users.username, users.enabled FROM users';
        if ($sortBy !== null){
            $query .= " ORDER BY $sortBy";
        }
        if ($limit !== null){
            $query .= " LIMIT $limit";
        }
        if ($page !== 1 && $page !== null){
            $page = ($page - 1) * 15;
            $query .= " OFFSET $page";
        }

        $state = $pdo -> prepare($query);
        try {
            $state ->execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }

    function getUsersCount(PDO $pdo)
    {
        $state = $pdo -> prepare("SELECT COUNT(*) AS `usersCount` FROM users");
        try {
            $state -> execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }