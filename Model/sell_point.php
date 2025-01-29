<?php
    function getSellPointInfos (PDO $pdo, int $id)
    {
        $state = $pdo -> prepare("SELECT sell_points.*, groups.group_name, adr.departement, adr.label, adr.departement, adr.coordonate_x, adr.coordonate_y FROM sell_points 
                  INNER JOIN address AS adr ON sell_points.id_address = adr.id 
                  LEFT JOIN `groups` ON sell_points.id_group = `groups`.id 
                  WHERE sell_points.id = :id"
        );
        $state -> bindValue(':id', $id);
        try {
            $state -> execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }

    function deleteSellPoint(PDO $pdo, int $id)
    {
        $state = $pdo -> prepare("SELECT id_address FROM sell_points WHERE id = :id");
        $state -> bindValue(':id', $id);
        try {
            $state -> execute();
            $idAddress = $state -> fetchall(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
        $state -> closeCursor();

        $state = $pdo -> prepare("SET FOREIGN_KEY_CHECKS = 0");
        $state -> execute();

        $state = $pdo -> prepare("DELETE FROM address WHERE id = :id");
        $state -> bindValue(':id', $idAddress[0]['id_address']);
        try {
            $state -> execute();
        } catch (PDOException $e){
            return $e -> getMessage();
        }
        $state -> closeCursor();



        $state = $pdo -> prepare("DELETE FROM sell_points WHERE id = :id");
        $state -> bindValue( ":id", $id);
        try {
            $state -> execute();
            $state = $pdo -> prepare("SET FOREIGN_KEY_CHECKS = 1");
            $state -> execute();
            return true;
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }

    function getGroupsInfos (PDO $pdo)
    {
        $state = $pdo -> prepare("SELECT * FROM `groups`");
        try {
            $state -> execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }

    function createSellPoint(PDO $pdo, array $data, array $address, string $departement)
    {
        $state = $pdo -> prepare('INSERT INTO `address` (`label`, `departement`, `coordonate_x`, `coordonate_y`) VALUES ( :label, :departement, :x, :y);');
        $state -> bindValue(':departement', $departement);
        $state -> bindValue(':label', $address['properties']['label']);
        $state -> bindValue(':x', $address['geometry']['coordinates'][1]);
        $state -> bindValue(':y', $address['geometry']['coordinates'][0]);
        try {
            $state -> execute();
            $idAddress = $pdo -> lastInsertId();
        } catch (PDOException $e){
            return $e -> getMessage();
        }
        $state -> closeCursor();

        $state = $pdo -> prepare('INSERT INTO `sell_points` (`name`, `id_group`, `siret`,`image`, `id_address`, `last_name_director`, `first_name_director`, `schedule`) VALUES (:name, :group, :siret, :img,:id_address, :last_name, :first_name, :schedule)');
        $state -> bindValue(':name', $data['name']);
        $state -> bindValue(':group', $data['group'], PDO::PARAM_NULL || PDO::PARAM_INT);
        $state -> bindValue(':siret', $data['siren']);
        $state -> bindValue(':id_address', $idAddress);
        $state -> bindValue(':img', 'test');
        $state -> bindValue(':last_name', $data['last_name']);
        $state -> bindValue(':first_name', $data['first_name']);
        $state -> bindValue(':schedule', $data['schedule']);

        try {
            $state -> execute();
            return true;
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }



    function updateSellPoint(PDO $pdo, int $id, array $data, array $address, string $departement)
    {
        $state = $pdo -> prepare("SELECT id_address FROM sell_points WHERE id = :id");
        $state -> bindValue(':id', $id);
        try {
            $state -> execute();
            $idAddress = (int) $state -> fetchall(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
        $state -> closeCursor();

        $state = $pdo -> prepare("UPDATE address SET departement = :departement, label = :label, coordonate_x = :x, coordonate_y = :y WHERE id = :id");
        $state -> bindValue(':id', $idAddress);
        $state -> bindValue(':departement', $departement);
        $state -> bindValue(':label', $address['properties']['label']);
        $state -> bindValue(':x', $address['geometry']['coordinates'][1]);
        $state -> bindValue(':y', $address['geometry']['coordinates'][0]);
        try {
            $state -> execute();
        } catch (PDOException $e){
            return $e -> getMessage();
        }
        $state -> closeCursor();

        $state = $pdo -> prepare("UPDATE sell_points SET 
                       name = :name, 
                       id_group = :id_group, 
                       last_name_director = :last_name, 
                       first_name_director = :first_name, 
                       schedule = :schedule,
                       siret = :siret
                       WHERE id = :id");
        $state -> bindValue(':id', $id);
        $state -> bindValue(':name', $data['name']);
        $state -> bindValue(':id_group', $data['group'], PDO::PARAM_NULL || PDO::PARAM_INT);
        $state -> bindValue(':last_name', $data['last_name']);
        $state -> bindValue(':first_name', $data['first_name']);
        $state -> bindValue(':schedule', $data['schedule']);
        $state -> bindValue(':siret', $data['siren']);
        try {
            $state -> execute();
            return true;
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }