<?php
/**
 * @var PDO $pdo
 */
    require './vendor/autoload.php';
    require './Includes/database.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;


    $faker = Faker\Factory::create('fr_FR');
    $company_name = FAKER\Factory::create('en_US');
    $group = [
        null,
        $company_name -> company(),
        $company_name -> company(),
        $company_name -> company(),
        $company_name -> company()
    ];

    for ($i = 0; $i < 30; $i++){

        $street_name = $faker -> streetAddress();
        $street_name = str_replace(" ", "+", $street_name);

        $client = new Client();
        $request = new Request('GET', 'https://api-adresse.data.gouv.fr/search/?q='. $street_name .'&limit=1 ');
        $res = $client->sendAsync($request)->wait();
        $res_body = $res->getBody();
        $data = json_decode($res_body, true);

        $client = new Client();
        $request = new Request('GET', 'https://geo.api.gouv.fr/communes?nom='. $data['features'][0]['properties']['city'] .'&fields=departement');
        $res = $client->sendAsync($request)->wait();
        $res_body = $res->getBody();
        $departement = json_decode($res_body, true);

        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $state = $pdo -> prepare("INSERT INTO address (label, departement, coordonate_x, coordonate_y) VALUES (:label,:departement,:x,:y) ");
        $state -> bindValue(':label', $data['features'][0]['properties']['label']);
        $state -> bindValue(':departement',$departement[0]['departement']['code']);
        $state -> bindValue(':x', $data['features'][0]['properties']['x']);
        $state -> bindValue(':y', $data['features'][0]['properties']['y']);

        try {
            $state -> execute();
            $last_id_address = $pdo -> lastInsertId();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
        $state -> closeCursor();

        $group_random = rand(0,4);

        if (rand(1,2) === 1){
            $siret = $faker -> siret();
        } else {
            $siret = $faker -> siren();
        }

        $schedule = [
            [ 'day' => 'Monday',
                ['open' => '8.00'],
                ['close' => '22.00']
            ],
            [ 'day' => 'Tuesday',
                ['open' => '8.00'],
                ['close' => '22.00']
            ],
            [ 'day' => 'Wednesday',
                ['open' => '8.00'],
                ['close' => '22.00']
            ],
            [ 'day' => 'Thursday',
                ['open' => '8.00'],
                ['close' => '22.00']
            ],
            [ 'day' => 'Friday',
                ['open' => '8.00'],
                ['close' => '22.00']
            ],
            [ 'day' => 'Saturday',
                ['open' => '8.00'],
                ['close' => '22.00']
            ],
            [ 'day' => 'Sunday',
                ['CLOSED']
            ],
        ];

        $prepare = $pdo -> prepare("INSERT INTO sell_points (name, group_name, siret, id_address, image, last_name_director, first_name_director, schedule) VALUES (:name, :group_name, :siret, :id_address, :image, :last_name, :first_name, :schedule)");
        $prepare -> bindValue(':name',$faker -> company() . " Mc Donald");
        $prepare -> bindValue(':group_name', $group[$group_random]);
        $prepare -> bindValue(':siret', $siret);
        $prepare -> bindValue(':id_address', $last_id_address);
        $prepare -> bindValue(':image', $faker -> imageUrl(640,640, 'building'));
        $prepare -> bindValue(':last_name', $faker -> lastName());
        $prepare -> bindValue(':first_name', $faker -> firstName());
        $prepare -> bindValue(':schedule',json_encode($schedule));
        try {
            $prepare -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
        $prepare -> closeCursor();

        $launch = $pdo -> prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $launch -> bindValue(':username', $faker -> userName());
        $launch -> bindValue(':password', password_hash('0000', PASSWORD_DEFAULT));
        try {
            $launch -> execute();
        } catch (PDOException $e){
            echo  $e ->getMessage();
        }
        $launch -> closeCursor();
    }