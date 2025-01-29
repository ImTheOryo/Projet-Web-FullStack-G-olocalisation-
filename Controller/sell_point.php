<?php
/**
 * @var PDO $pdo
 */
    require "Model/sell_point.php";

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
    function prepareData($data)
    {
        $tab = [];
        $tab['name'] = cleanString($data['name']);
        $tab['group'] = $data['group_name'] === 'null' ? null : (int)$data['group_name'];
        $tab['siren'] = cleanString($data['siren']);
        $tab['first_name'] = cleanString($data['first-name']);
        $tab['last_name'] = cleanString($data['last-name']);
        $tab['address'] = cleanString($data['address']);
        $tab['schedule'] = $data['schedule'];
        return $tab;
    }

    function addressAPI ($data)
    {
        $adr = urlencode($data);
        $client = new Client();
        $request = new Request('GET', "https://api-adresse.data.gouv.fr/search/?q=$adr&limit=1");
        $res = $client->sendAsync($request)->wait();
        $res_body = $res->getBody();
        return json_decode($res_body, true);
    }

    function departementAPI ($data)
    {

        $client = new Client();
        $request = new Request('GET', 'https://geo.api.gouv.fr/communes?nom='. $data['features'][0]['properties']['city'] .'&fields=departement');
        $res = $client->sendAsync($request)->wait();
        $res_body = $res->getBody();
        $departement = json_decode($res_body, true);
        return $departement[0]['departement']['code'];
    }

    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
    ){
        if (!empty($_GET['action'])){
            switch ($_GET['action']){
                case 'group':
                    $groups = getGroupsInfos($pdo);
                    if (is_array($groups)){
                        header('Content-type: application/json');
                        echo json_encode(['infos' => $groups]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'Une erreur est survenue lors de la récupération des groupes']);
                        exit();
                    }
                case 'modify':
                    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;
                    if (!is_numeric($id)){
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'ID au mauvais format']);
                        exit();
                    }
                    $sellPointInfo = getSellPointInfos($pdo, $id);
                    if (is_array($sellPointInfo)){
                        header("Content-Type: application/json");
                        echo json_encode(['infos' => $sellPointInfo]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => true,'message' => "Erreur lors de la recuperation des donnees : $sellPointInfo"]);
                        exit();
                    }

                case 'modification' :
                    $tab = [];
                    $tab = prepareData($_POST);

                    if (is_string($tab['address'])){
                        $tab['address'] = str_replace(' ', '', $tab['address']);


                        if (strlen($tab['address']) < 5){
                            header("Content-Type: application/json");
                            echo json_encode(['errors' => 'L adresse est trop courte']);
                            exit();
                        }
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'L adresse est trop courte']);
                        exit();
                    }
                    $address = addressAPI($tab['address']);
                    if (isset($address['status'])){
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'Veuillez transmettre une adresse valide']);
                        exit();
                    }
                    $departement = departementAPI($address);
                    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;

                    if (!is_numeric($id)){
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'ID au mauvais format']);
                        exit();
                    }

                    $res = updateSellPoint($pdo, $id, $tab, $address['features'][0], $departement);

                    if ($res){
                        header("Content-Type: application/json");
                        echo json_encode(['success' => $res]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => $res]);
                        exit();
                    }

                case 'create' :
                    var_dump($_SERVER);
                    var_dump($_FILES);
                    $tab = [];
                    $tab = prepareData($_POST);

                    if (is_string($tab['address'])){
                        $tab['address'] = str_replace(' ', '', $tab['address']);
                        if (strlen($tab['address']) < 5){
                            header("Content-Type: application/json");
                            echo json_encode(['errors' => 'L adresse est trop courte']);
                            exit();
                        }
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'L adresse est trop courte']);
                        exit();
                    }
                    $address = addressAPI($tab['address']);
                    if (isset($address['status'])){
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => 'Veuillez transmettre une adresse valide']);
                        exit();
                    }

                    $departement = departementAPI($address);

                    $res = createSellPoint($pdo, $tab, $address['features'][0], $departement);
                    if ($res){
                        header("Content-Type: application/json");
                        echo json_encode(['success' => $res]);
                        exit();
                    } else {
                        header("Content-Type: application/json");
                        echo json_encode(['errors' => $res]);
                        exit();
                    }
            }
        }
    }
    require "View/sell_point.php";