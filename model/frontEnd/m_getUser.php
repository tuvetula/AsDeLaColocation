<?php
require_once('model/bdd/bddConfig.php');
//Vérifie si le login existe en base de donnée (pour verif mot de passe au login)
function getUser($mail)
{
    $mail = htmlspecialchars(strip_tags($mail));
    $db = connectBdd();
    $answer = $db->prepare('SELECT user_id,user_mail,user_password,user_isAdmin,user_isMember
    FROM users 
    WHERE user_mail=:mail');
    $answer->execute([
        ':mail' => $mail
    ]);
    return $answer->fetch(PDO::FETCH_ASSOC);
}
//Récupère les infos d'un user par son adresse mail (pour verif token à l'inscription)
function getUserByMail($mail){
    $mail = htmlspecialchars(strip_tags($mail));
    $db = connectBdd();
    $answer = $db->prepare('SELECT user_id,user_mail,user_token,user_name,user_firstName,user_isMember 
    FROM users 
    WHERE user_mail=:mail');
    $answer->execute([
        ':mail' => $mail
    ]);
    return $answer->fetch(PDO::FETCH_ASSOC);
}
//Récupère les infos d'un user par son user_id (pour modification "mon compte")
function getUserById($userId)
{
    $userId = htmlspecialchars(strip_tags($userId));
    $db = connectBdd();
    $answer = $db->prepare('SELECT users.user_id,users.user_civility,users.user_name,users.user_firstName,users.user_dateOfBirth,users.user_phoneNumber,users.user_mail, users.user_loginSiteWeb, users.user_passwordSiteWeb, users.user_accountCreationDate, addresses.address_street,addresses.address_zipcode,addresses.address_city,addresses.address_country 
    FROM users 
    join addresses on users.address_id = addresses.address_id 
    WHERE user_id=:userId');
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
//Récupère les utilisateurs qui ont l'adress_id passé en argument
function getUsersWithThisAddressId($addressId){
        $addressId = htmlspecialchars(strip_tags($addressId));
        $db = connectBdd();
        $request = $db->prepare('SELECT user_id FROM users WHERE address_id=:addressId');
        $request->execute([
            ':addressId' => $addressId
        ]);
        $usersIdWithSameAddress = $request->fetch(PDO::FETCH_ASSOC);
        $request->closeCursor();
        return $usersIdWithSameAddress;
}
//Vérification du mot de passe (pour changement de mot de passe d'un utilisateur connecté)
function verifyPassword($password,$id)
{
    $password = htmlspecialchars(strip_tags($password));
    $id = htmlspecialchars(strip_tags($id));
    $db = connectBdd();
    $passwordRequest = $db->prepare('SELECT user_password 
    FROM users 
    WHERE user_id=:userId');
    $passwordRequest->execute([
        ':userId' => $id
    ]);
    $passwordBddArray = $passwordRequest->fetch(PDO::FETCH_ASSOC);
    $passwordBdd = $passwordBddArray['user_password'];
    return $passwordBdd;
}
//Verification si un autre user a deja l'adresse mail renseignée (pour eviter doublon)
function verifyMailAlreadyPresent($mail,$userId){
    $db = connectBdd();
    $verifyMailAlreadyPresentRequest = $db->prepare('SELECT user_id,user_mail 
    FROM users 
    WHERE user_id!=:userId && user_mail=:userMail');
    $verifyMailAlreadyPresentRequest->execute([
        ':userId' => $userId,
        ':userMail' => $mail
    ]);
    $verifyMailAlreadyPresent = $verifyMailAlreadyPresentRequest->fetchAll(PDO::FETCH_ASSOC);
    return $verifyMailAlreadyPresent;
}