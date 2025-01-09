<?php
    function getSellPointsInfos(PDO $pdo, null | int $limit = null, null | int $page = null, null | string $sortBy = null)
    {
        $query = "SELECT sell_points.*, groups.group_name, adr.label, adr.departement, adr.coordonate_x, adr.coordonate_y FROM sell_points 
                  INNER JOIN address AS adr ON sell_points.id_address = adr.id 
                  LEFT JOIN `groups` ON sell_points.id_group = `groups`.id";

        if ($limit !== null){
            $query .= " LIMIT $limit";
        }
        if ($page !== 1 && $page !== null){
            $page = ($page - 1) * 20;
            $query .= " OFFSET $page";
        }
        if ($sortBy !== null){
            $query .= " SORTBY $sortBy";
        }
        $state = $pdo -> prepare($query);
        try {
            $state ->execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }

    function getSellPointsCount(PDO $pdo)
    {
        $state = $pdo -> prepare("SELECT COUNT(*) AS `sellPointsCount` FROM sell_points");
        try {
            $state -> execute();
            return $state -> fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return $e -> getMessage();
        }
    }
