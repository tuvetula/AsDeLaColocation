<?php
require_once('model/bdd/bddConfig.php');

//Vérifie si le login existe en base de donnée
function getUser($postLogin)
{
    $postLogin = htmlspecialchars(strip_tags($postLogin));
    $db = connectBdd();
    $answer = $db->prepare('SELECT * FROM users WHERE user_mail=:login');
    $answer->execute([
        ':login' => $postLogin
    ]);
    return $answer->fetch();
}

//Récupère les infos d'un user par son user_id
function getUserById($userId)
{
    $userId = htmlspecialchars(strip_tags($userId));
    $db = connectBdd();
    $answer = $db->prepare('SELECT users.user_name,users.user_firstName,users.user_phoneNumber,users.user_mail,users.user_loginSiteWeb,users.user_passwordSiteWeb,addresses.address_street,addresses.address_zipcode,addresses.address_city,addresses.address_country FROM users join addresses on users.address_id = addresses.address_id WHERE user_id=:userId');
    $answer->execute([
        ':userId' => $userId
    ]);
    $userData = $answer->fetch(PDO::FETCH_ASSOC);
    $answer->closeCursor();
    return $userData;
}