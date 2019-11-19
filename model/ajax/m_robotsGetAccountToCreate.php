<?php

header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *");
require_once('../bdd/config.php');

if (isset($_GET['id']) && $_GET['id'] == $idJson) {
    //Stocke la date - 7 jours
    $date = date('Y-m-d', strtotime('-7 day'));
    //Stocke la date - 30 jours (pour republication seloger)
    $dateSeloger = date('Y-m-d', strtotime('-31 day'));
    //Stocke la date pour site erasmusu
    $dateErasmusu = date('Y-m-d', strtotime('-6 day'));

    //Connexion Base de donnée
    try {
        $bdd = new PDO($acces.$dbName, $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    
    $json = creation($bdd);
    //Ecriture fichier json
    echo json_encode($json);
}
//creation: Annonce inactive + date non null
function creation($bdd)
{
    //leboncoin creation
    $requestcreationLeboncoin=$bdd->prepare('SELECT users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountLeboncoin=:isCreate');
    $requestcreationLeboncoin->execute([
        ':isCreate' => false,
    ]);
    $creationLeboncoin = $requestcreationLeboncoin->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Leboncoin'] = $creationLeboncoin;

    //Lacartedescolocs creation
    $requestcreationLacartedesColocs=$bdd->prepare('SELECT 
    users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountLacartedescolocs=:isCreate');
    $requestcreationLacartedesColocs->execute([
        ':isCreate' => false,
    ]);
    $creationLacartedescolocs = $requestcreationLacartedesColocs->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Lacartedescolocs'] = $creationLacartedescolocs;

    //Appartager creation
    $requestcreationAppartager=$bdd->prepare('SELECT users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountAppartager=:isCreate');
    $requestcreationAppartager->execute([
        ':isCreate' => false,
    ]);
    $creationAppartager = $requestcreationAppartager->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Appartager'] = $creationAppartager;

    //Seloger creation
    

    //Studapart creation
    $requestcreationStudapart=$bdd->prepare('SELECT users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountStudapart=:isCreate');
    $requestcreationStudapart->execute([
        ':isCreate' => false,
    ]);
    $creationStudapart = $requestcreationStudapart->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Studapart'] = $creationStudapart;

    //Erasmusu creation
    $requestcreationErasmusu=$bdd->prepare('SELECT users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountErasmusu=:isCreate');
    $requestcreationErasmusu->execute([
        ':isCreate' => false,
    ]);
    $creationErasmusu = $requestcreationErasmusu->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Erasmusu'] = $creationErasmusu;

    //Roomlala creation
    $requestcreationRoomlala=$bdd->prepare('SELECT users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountRoomlala=:isCreate');
    $requestcreationRoomlala->execute([
        ':isCreate' => false,
    ]);
    $creationRoomlala = $requestcreationRoomlala->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Roomlala'] = $creationRoomlala;

    //Bubbleflat creation
    $requestcreationBubbleflat=$bdd->prepare('SELECT users.user_name,users.user_firstName,users.user_mail,users.user_accountCreationDate,users.user_id FROM users
    WHERE user_accountBubbleflat=:isCreate');
    $requestcreationBubbleflat->execute([
        ':isCreate' => false,
    ]);
    $creationBubbleflat = $requestcreationBubbleflat->fetchAll(PDO::FETCH_ASSOC);
    $jsoncreation['c_Bubbleflat'] = $creationBubbleflat;
    
    return $jsoncreation;
}