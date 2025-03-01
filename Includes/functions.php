<?php
    function cleanString(string $value): string
    {
        return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }

    function responseJSON (string $status, array | string $message)
    {
        header("Content-Type: application/json");
        echo json_encode([$status => $message]);
        exit();
    }



