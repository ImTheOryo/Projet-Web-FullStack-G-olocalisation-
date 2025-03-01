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
        $tab['image'] = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
        $tab['path'] = !empty($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : null;
        if (!empty($tab['image'])) {
            $tab['ext'] = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
        }
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
                        responseJSON('infos', $groups);
                    } else {
                        responseJSON('errors', 'Une erreur est survenue lors de la récupération des groupes');
                    }
                case 'modify':
                    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;
                    if (!is_numeric($id)){
                        responseJSON('errors', 'ID au mauvais format');
                    }
                    $sellPointInfo = getSellPointInfos($pdo, $id);
                    if (is_array($sellPointInfo)){
                        responseJSON('infos', $sellPointInfo);
                    } else {
                        responseJSON('errors', 'Erreur lors de la recuperation des donnees :' . $sellPointInfo);
                    }

                case 'modification' :
                    $tab = [];
                    $tab = prepareData($_POST);

                    if (is_string($tab['address'])){
                        $tab['address'] = str_replace(' ', '', $tab['address']);


                        if (strlen($tab['address']) < 5){
                            responseJSON('errors', 'Adresse invalide');
                        }
                    } else {
                        responseJSON('errors', 'Adresse trop courte');
                    }
                    $address = addressAPI($tab['address']);
                    if (isset($address['status'])){
                        responseJSON('errors', 'Veuillez transmettre une adresse valide');
                    }
                    $departement = departementAPI($address);
                    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;

                    if (!is_numeric($id)){
                        responseJSON('errors', 'ID au mauvais format');
                    }

                    if ($tab['image'] !== null){
                        $lastImage = getImageName($pdo,  $id);

                        try {
                            $uniqueFileName = $tab['path'] !== null ? uniqid() . '.' . $tab['ext'] : null;
                            move_uploaded_file($tab['path'], $_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $uniqueFileName);
                        } catch (Exception $e) {
                            responseJSON('errors', 'Erreur lors de la sauvegarde de l\'image sur le serveur ' );
                        }

                        $res = updateSellPointImage($pdo, $id, $uniqueFileName);

                        if ($res) {
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $lastImage['image'])) {
                                try {
                                    unlink($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $lastImage['image']);
                                } catch (Exception $e) {
                                    responseJSON('errors', 'Erreur lors de la suppression de l\'image | ErrorCode:' . $e -> getMessage());
                                }
                            }
                        } else {
                            responseJSON('errors', 'Erreur lors de la suppression de l\'ancienne image');
                        }
                    }

                    $res = updateSellPoint($pdo, $id, $tab, $address['features'][0], $departement);

                    if ($res){
                        responseJSON('success', $res);
                    } else {
                        responseJSON('errors', $res);
                    }

                case 'create' :
                    $tab = [];
                    $tab = prepareData($_POST);

                    if (is_string($tab['address'])){
                        $tab['address'] = str_replace(' ', '', $tab['address']);
                        if (strlen($tab['address']) < 5){
                            responseJSON('errors', 'Adresse trop courte');
                        }
                    } else {
                        responseJSON('errors', 'Adresse trop courte');
                    }
                    $address = addressAPI($tab['address']);
                    if (isset($address['status'])){
                        responseJSON('errors', 'Veuillez transmettre une adresse valide');
                    }

                    $departement = departementAPI($address);
                    $uniqueFileName = $tab['path'] !== null ? uniqid() . '.' . $tab['ext'] : null;
                    move_uploaded_file($tab['path'], $_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $uniqueFileName);
                    $res = createSellPoint($pdo, $tab, $address['features'][0], $departement, $uniqueFileName);
                    if ($res){
                        responseJSON('success', $res);
                    } else {
                        responseJSON('errors', $res);
                    }
            }
        }
    }
    require "View/sell_point.php";