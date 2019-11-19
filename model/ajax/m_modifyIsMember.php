<?php
session_start();
header("Access-Control-Allow-Origin: *");
include_once('../bdd/config.php');
if (isset($_SESSION['mail']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
    $userId = htmlspecialchars(strip_tags($_POST['userId']));
    //Connexion Base de donnée
    try {
        $bdd = new PDO($acces.$dbName,$login,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    //Requete recup etat actuel de advertisement_isActive
    $request=$bdd->prepare('SELECT user_isMember 
    FROM users 
    WHERE user_id=:userId');
    $request->execute([
        ':userId'=>$userId
    ]);
    $userIsMemberState = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    //préparation nouvel état de isMember à insérer en bdd
    if($userIsMemberState[0]['user_isMember']){
        $userIsMemberNewState = 0;
    }else{
        $userIsMemberNewState = 1;
    }
    //Requete changement valeur de isMember
    $updateUser=$bdd->prepare('UPDATE users SET user_isMember="'.$userIsMemberNewState.'" WHERE user_id="'.$userId.'"');
    $updateUser->execute();
    if($userIsMemberNewState == 0){
        $updateAdvertisementIsActive = $bdd->prepare('UPDATE advertisements SET advertisement_isActive=0 WHERE user_id="'.$userId.'"');
        $updateAdvertisementIsActive->execute();
    }
    echo "requete executée en base de donnée";
}