<?php
require_once('model/bdd/bddConfig.php');
//Récupère tous les users (nom, prénom, mail)
function getUsersForAdmin(){
    $db = connectBdd();
    $usersRequest = $db->prepare('SELECT user_id,user_name,user_firstName,user_mail,user_isMember FROM users');
    $usersRequest->execute();
    $users = $usersRequest->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}
//Récupère les informations d'un utilisateur (nom,prénom)
function getUserInformation($userId){
    $userId = htmlspecialchars(strip_tags($userId));
    $db = connectBdd();
    $usersRequest = $db->prepare('SELECT user_name,user_firstName FROM users WHERE user_id="'.$userId.'"');
    $usersRequest->execute();
    $user = $usersRequest->fetch(PDO::FETCH_ASSOC);
    return $user;
}
//Récupère l'id d'un utilisateur selon un numéro d'annonce
function getUserIdFromAdvertisementId($advertisementId){
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    $usersRequest = $db->prepare('SELECT user_id FROM advertisements WHERE advertisement_id="'.$advertisementId.'"');
    $usersRequest->execute();
    $userId = $usersRequest->fetch(PDO::FETCH_ASSOC);
    return $userId;
}
