<?php
header('Content-Type: application/javascript');
header("Access-Control-Allow-Origin: *");
require_once('../bdd/config.php');
if (isset($_GET['id']) && $_GET['id'] == $idjsonReturn){
    $columnBdd = htmlspecialchars(strip_tags($_GET['columnBdd']));
    $advertisementId = htmlspecialchars(strip_tags($_GET['advertisementId']));
    $dateValue = htmlspecialchars(strip_tags($_GET['dateValue']));
    if($dateValue == "publication"){
        $date = '"'.date("Y-m-d").'"';
    }else{
        $date = "NULL";
    }
    //Connexion Base de donnée
    try {
        $bdd = new PDO($acces.$dbName,$login,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    //Requete changement valeur de dateOfLastDiffusion
    $insert=$bdd->prepare('UPDATE advertisements SET '.$columnBdd.'='.$date.' WHERE advertisement_id="'.$advertisementId.'"');
    $insert->execute();
    echo true;
}