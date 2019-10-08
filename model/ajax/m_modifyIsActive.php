<?php
session_start();
header("Access-Control-Allow-Origin: *");
include_once('../bdd/config.php');
if (isset($_SESSION['mail'])){
    $advertisementId = htmlspecialchars(strip_tags($_POST['advertisementId']));
    
    //Connexion Base de donnée
    try {
        $bdd = new PDO($acces.$dbName,$login,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    
    //Requete recup etat actuel de advertisement_isActive
    $request=$bdd->query('SELECT advertisement_isActive FROM advertisements 
                        WHERE advertisement_id="'.$advertisementId.'"');
    $advertisementIsActiveState = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    
    //préparation nouvel état de isActive à insérer en bdd
    if($advertisementIsActiveState[0]['advertisement_isActive']){
        $advertisementIsActiveNewState = 0;
    }else{
        $advertisementIsActiveNewState = 1;
    }
    
    //Requete changement valeur de isActive
    $insert=$bdd->prepare('UPDATE advertisements SET advertisement_isActive="'.$advertisementIsActiveNewState.'" WHERE advertisement_id="'.$advertisementId.'"');
    $insert->execute();
    echo "requete executée en base de donnée";
}