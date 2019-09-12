<?php
require_once('model/bdd/bddConfig.php');

//Vérifie si le login existe en base de donnée
function getUser($postMail)
{
    $postMail = htmlspecialchars(strip_tags($postMail));
    $db = connectBdd();
    $answer = $db->prepare('SELECT user_id,user_mail,user_password,user_isAdmin,user_isMember,user_token FROM users WHERE user_mail=:mail');
    $answer->execute([
        ':mail' => $postMail
    ]);
    return $answer->fetch(PDO::FETCH_ASSOC);
}

//Récupère les infos d'un user par son user_id (pour modification "mon compte")
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

//Récupère address_id d'un user (pour modification addresse "mon compte")
function getUserAddressId($userId){
    $userId = htmlspecialchars(strip_tags($userId));
    $db = connectBdd();
    $addressIdRequest = $db->prepare('SELECT address_id FROM users WHERE user_id=:userId');
    $addressIdRequest->execute([
        ':userId' => $userId
    ]);
    $addressIdUser = $addressIdRequest->fetch(PDO::FETCH_ASSOC);
    $addressIdRequest->closeCursor();
    return $addressIdUser;
}

//Vérification du mot de passe (pour changement de mot de passe d'un utilisateur connecté)
function verifyPassword($password)
{
    $password = htmlspecialchars(strip_tags($password));
    $db = connectBdd();
    $passwordRequest = $db->prepare('SELECT user_password FROM users WHERE user_id=:userId');
    $passwordRequest->execute([
        ':userId' => $_SESSION['id']
    ]);
    $passwordBddArray = $passwordRequest->fetch(PDO::FETCH_ASSOC);
    $passwordBdd = $passwordBddArray['user_password'];
    if (password_verify($password, $passwordBdd)) {
        return true;
    }else{
        return false;
    }
}