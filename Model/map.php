<?php

    function getGeoJSON(PDO $pdo)
    {
        $state = $pdo -> prepare('SELECT `geojson` FROM `departement` WHERE id = 1');
        try {
            $state -> execute();
            return $state -> fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
