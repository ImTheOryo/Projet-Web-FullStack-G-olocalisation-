<?php
    function deleteUser(PDO $pdo, int $id)
    {
        $state = $pdo ->prepare("DELETE FROM users WHERE id = :id");
        $state -> bindParam(':id', $id, PDO::PARAM_INT);
        try {
            $state -> execute();
            return true;
        } catch (PDOException $e) {
            return $e -> getMessage();
        }
    }

    function getUserInfo(PDO $pdo, int $id){
        $state = $pdo ->prepare("SELECT users.username, users.mail, users.enabled FROM users WHERE id = :id");
        $state -> bindParam(':id', $id, PDO::PARAM_INT);
        try {
            $state -> execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e -> getMessage();
        }
    }

    function verifyUsername( PDO $pdo, string $username, ?int $id = null)
    {
        try {
            $query = "SELECT COUNT(*) AS user_number FROM users WHERE username = :username";
            $id !== null ? $query .= " AND id != :id" : null;
            $state = $pdo->prepare($query);
            $state->bindParam(':username', $username);
            $id !== null ? $state->bindParam(':id', $id, PDO::PARAM_INT) : null;
            $state->execute();
            return $state->fetch();
        } catch (Exception $e) {
            return "Erreur de verification du username {$e->getMessage()}";
        }
    }

    function changeUserPassword(PDO $pdo, string $password, int $id)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $state = $pdo ->prepare("UPDATE users SET password = :password WHERE id = :id");
        $state -> bindParam(':password', $password);
        $state -> bindParam(':id', $id, PDO::PARAM_INT);
        try {
            $state -> execute();
            return true;
        } catch (PDOException $e) {
            return $e -> getMessage();
        }
    }

    function createNewUser(PDO $pdo, array $data)
    {
        $state = $pdo -> prepare('INSERT INTO users (username, password, mail, enabled) VALUES (:username, :password, :mail, :enabled)');
        $state -> bindParam(':username', $data['username']);
        $state -> bindParam(':password', $data['password']);
        $state -> bindParam(':mail', $data['mail']);
        $state -> bindParam(':enabled', $data['enabled']);
        try {
            $state -> execute();
            return true;
        } catch (PDOException $e) {
            return $e -> getMessage();
        }
    }

    function changeUserInfos(PDO $pdo, int $id, array $data)
    {

        $state = $pdo ->prepare("UPDATE users SET username = :username, mail = :mail, enabled = :enabled WHERE id = :id");
        $state -> bindParam(':username', $data['username']);
        $state -> bindParam(':mail', $data['mail']);
        $state -> bindParam(':enabled', $data['enabled'], PDO::PARAM_BOOL);
        $state -> bindParam(':id', $id, PDO::PARAM_INT);
        try {
            $state -> execute();
            return true;
        } catch (PDOException $e) {
            return $e -> getMessage();
        }
    }