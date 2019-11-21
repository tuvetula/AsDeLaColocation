<?php
require_once('model/bdd/bddConfig.php');

//Ajoute un nouveau User (non admin et non membre par défaut si $isAdmin et $isMember ne sont pas renseignés)
function insertNewUser($usercivility, $username, $userfirstName, $userdateOfBirth, $userphoneNumber, $usermail, $userpassword, $token, $addressId, $userisAdmin=0, $userisMember=0)
{
    $usercivility = htmlspecialchars(strip_tags($usercivility));
    $username = htmlspecialchars(strip_tags($username));
    $userfirstName = htmlspecialchars(strip_tags($userfirstName));
    $userdateOfBirth = htmlspecialchars(strip_tags($userdateOfBirth));
    $userphoneNumber = htmlspecialchars(strip_tags($userphoneNumber));
    $usermail = htmlspecialchars(strip_tags($usermail));
    $userpassword = htmlspecialchars(strip_tags($userpassword));
    $userisAdmin = htmlspecialchars(strip_tags($userisAdmin));
    $userisMember = htmlspecialchars(strip_tags($userisMember));
    $userloginSiteWeb = htmlspecialchars(strip_tags($usermail));
    $userHasAppartagerAccount = 0;
    $userHasBubbleflatAccount = 0;
    $userHasErasmusuAccount = 0;
    $userHasLacartedescolocsAccount = 0;
    $userHasRoomlalaAccount = 0;
    $userHasSelogerAccount = 0;
    $userHasStudapartAccount = 0;
    $token = htmlspecialchars(strip_tags($token));
    $addressId = htmlspecialchars(strip_tags($addressId));
    //Hachage mot de passe
    $userpassword = password_hash($userpassword,PASSWORD_DEFAULT);
    $db = connectBdd();
    $insertUser = $db->prepare('INSERT INTO users (user_civility,user_name,user_firstName,user_dateOfBirth,user_phoneNumber,user_mail,user_password,user_isAdmin,user_isMember,user_loginSiteWeb,user_hasAppartagerAccount, user_hasBubbleflatAccount, user_hasErasmusuAccount, user_hasLacartedescolocsAccount, user_hasRoomlalaAccount, user_hasSelogerAccount, user_hasStudapartAccount, user_token, address_id)
     VALUES (:civility,:name,:firstName,:dateOfBirth,:phoneNumber,:mail,:password,:isAdmin,:isMember,:loginSiteWeb,:hasAppartager,:hasBubbleflat,:hasErasmusu,:hasLacartedescolocs,:hasRoomlala,:hasSeloger,:hasStudapart,:userToken, :addressId)');
    $insertUser->execute(array(
        ':civility'=>$usercivility,
        ':name'=>ucfirst($username),
        ':firstName'=>ucfirst($userfirstName),
        ':dateOfBirth'=>$userdateOfBirth,
        ':phoneNumber'=>$userphoneNumber,
        ':mail'=>$usermail,
        ':password'=>$userpassword,
        ':isAdmin'=>$userisAdmin,
        ':isMember'=>$userisMember,
        ':loginSiteWeb'=>$userloginSiteWeb,
        ':hasAppartager'=>$userHasAppartagerAccount,
        ':hasBubbleflat'=>$userHasBubbleflatAccount,
        ':hasErasmusu'=>$userHasErasmusuAccount,
        ':hasLacartedescolocs'=>$userHasLacartedescolocsAccount,
        ':hasRoomlala'=>$userHasRoomlalaAccount,
        ':hasSeloger'=>$userHasSelogerAccount,
        ':hasStudapart'=>$userHasStudapartAccount,
        ':userToken'=>$token,
        ':addressId'=>$addressId
    ));
    return true;
}
