<?php
    function getSellPointInfos (PDO $pdo, int $id)
    {
        $state = $pdo -> prepare("SELECT sell_points.*, groups.group_name, adr.label, adr.departement, adr.coordonate_x, adr.coordonate_y FROM sell_points 
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