<?php
/**
 * @var PDO $pdo
 */
    require './vendor/autoload.php';
    require './Includes/database.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;

    $state = $pdo -> prepare("SET FOREIGN_KEY_CHECKS = 0");
    $state -> execute();

    $state = $pdo -> prepare("TRUNCATE `address`;");
    try {
        $state -> execute();
    } catch (PDOException $e){
        echo $e -> getMessage();
    }
    $state = $pdo -> prepare("TRUNCATE `groups`;");
    try {
        $state -> execute();
    } catch (PDOException $e){
        echo $e -> getMessage();
    }
    $state = $pdo -> prepare("TRUNCATE `sell_points`;");
    try {
        $state -> execute();
    } catch (PDOException $e){
        echo $e -> getMessage();
    }
    $state = $pdo -> prepare("TRUNCATE `users`;");
    try {
        $state -> execute();
    } catch (PDOException $e){
        echo $e -> getMessage();
    }

    $state = $pdo -> prepare("SET FOREIGN_KEY_CHECKS = 1");
    $state -> execute();

    $faker = Faker\Factory::create('fr_FR');
    $company_name = FAKER\Factory::create('en_US');

    $schedule = [
        0 => [
            "day" => "Lundi",
            "open" => "08:00:00",
            "close" => "22:00:00"
        ],
        1 => [
            "day" => "Mardi",
            "open" => "08:00:00",
            "close" => "22:00:00"
        ],
        2 => [
            "day" => "Mercredi",
            "open" => "08:00:00",
            "close" => "22:00:00"
        ],
        3 => [
            "day" => "Jeudi",
            "open" => "08:00:00",
            "close" => "22:00:00"
        ],
        4 => [
            "day" => "Vendredi",
            "open" => "08:00:00",
            "close" => "22:00:00"
        ],
        5 => [
            "day" => "Samedi",
            "open" => "08:00:00",
            "close" => "22:00:00"
        ],
        6 => [
            "day" => "Dimanche",
            "open" => "Ferme",
            "close" => "Ferme"
        ],
    ];
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    for ($j = 0; $j < 4; $j ++){
        $state = $pdo -> prepare("INSERT INTO `groups` (group_name) VALUES (:name)");
        $state -> bindValue(':name', $company_name -> company());

        try {
            $state -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
        $state -> closeCursor();
    }


    for ($i = 0; $i < 50; $i++){

        $street_name = $faker -> streetAddress();
        $street_name = str_replace(" ", "+", $street_name);

        $client = new Client();
        $request = new Request('GET', 'https://api-adresse.data.gouv.fr/search/?q='.$street_name.'&limit=1 ');
        $res = $client->sendAsync($request)->wait();
        $res_body = $res->getBody();
        $data = json_decode($res_body, true);

        $client = new Client();
        $request = new Request('GET', 'https://geo.api.gouv.fr/communes?nom='. $data['features'][0]['properties']['city'] .'&fields=departement');
        $res = $client->sendAsync($request)->wait();
        $res_body = $res->getBody();
        $departement = json_decode($res_body, true);


        $state = $pdo -> prepare("INSERT INTO address (label, departement, coordonate_x, coordonate_y) VALUES (:label,:departement,:x,:y) ");
        $state -> bindValue(':label', $data['features'][0]['properties']['label']);
        $state -> bindValue(':departement',$departement[0]['departement']['code']);
        $state -> bindValue(':x', $data['features'][0]['geometry']['coordinates'][1]);
        $state -> bindValue(':y', $data['features'][0]['geometry']['coordinates'][0]);

        try {
            $state -> execute();
            $last_id_address = $pdo -> lastInsertId();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
        $state -> closeCursor();

        if (rand(1,2) === 1){
            $siret = $faker -> siret();
        } else {
            $siret = $faker -> siren();
        }

        if (rand(1,5) === 5){
            $group = null;
        } else {
            $group = rand(1,4);
        }

        $state = $pdo -> prepare("INSERT INTO sell_points (name, id_group, siret, id_address, image, last_name_director, first_name_director, schedule) VALUES (:name, :id_group_name, :siret, :id_address, :image, :last_name, :first_name, :schedule)");
        $state -> bindValue(':name', "Mc Donald " . $data['features'][0]['properties']['city']);
        $state -> bindValue(':id_group_name', $group);
        $state -> bindValue(':siret', $siret);
        $state -> bindValue(':id_address', $last_id_address);
        $state -> bindValue(':image', "https://images.pexels.com/photos/3714786/pexels-photo-3714786.jpeg");
        $state -> bindValue(':last_name', $faker -> lastName());
        $state -> bindValue(':first_name', $faker -> firstName());
        $state -> bindValue(':schedule',json_encode($schedule));
        try {
            $state -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
        $state -> closeCursor();
    }
    $state = $pdo -> prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $state -> bindValue(':username', 'admin');
    $state -> bindValue(':password', password_hash('0000', PASSWORD_DEFAULT));
    try {
        $state -> execute();
    } catch (PDOException $e){
        echo  $e ->getMessage();
    }
    $state -> closeCursor();