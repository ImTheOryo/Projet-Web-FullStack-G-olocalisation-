<?php
    session_start();
    require __DIR__ . '/vendor/autoload.php';
    require "Includes/database.php";
    require "Includes/functions.php";
    if (isset($_GET['logout']) && $_GET['logout']){
        session_destroy();
        header("Location: index.php");
        exit();
    }
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        if (isset($_SESSION['auth']))
        {
            if (isset($_GET['component'])) {
                $componentName = cleanString($_GET['component']);
                if (file_exists("Controller/$componentName.php")) {
                    require "Controller/$componentName.php";
                } else {
                    header("Content-Type: application/json", true, 404);
                    echo json_encode(['errors' => true,'message' => "Ressource not found"]);
                    exit();
                }
            }
        } else {
            require "Controller/login.php";
        }
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Localisation</title>
        <link
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
                rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
                crossorigin="anonymous"
        >
        <link
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
                rel="stylesheet"
        >
        <link
                href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                rel="stylesheet"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                crossorigin=""
        >
        <script
                src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin="">
        </script>
    </head>
    <body>
        <?php
            if (isset($_SESSION['auth'])) {
                require "_Partials/navbar.php";
            }
        ?>
        <div class="container">
            <?php
                if (isset($_SESSION['auth'])){
                    if (isset($_GET['component'])){
                        $component_name = cleanString($_GET['component']);
                        if (file_exists("Controller/$component_name.php")){
                            require "Controller/$component_name.php";
                        }
                    }
                } else {
                    require "Controller/login.php";
                }
            ?>
        </div>
        <?php require "_Partials/toast.html";?>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>


    </body>
</html>
