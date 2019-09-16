<?php
// header('Content-type: text/html; charset=iso-8859-1');
require_once('../../bdd/config.php');

$advertisementId = htmlspecialchars(strip_tags($_POST['advertisementId']));

//Connexion Base de donnée
try {
    $bdd = new PDO('mysql:host=localhost;dbname='.$acces.';charset=utf8',''.$login.'', ''.$password.'',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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