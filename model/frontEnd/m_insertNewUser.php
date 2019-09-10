<?php
require_once('model/bdd/bddConfig.php');

//Ajoute un nouveau User (non admin et non membre par défaut si $isAdmin et $isMember ne sont pas renseignés)
function insertNewUser($username, $userfirstName, $userphoneNumber, $usermail, $userpassword, $userloginSiteWeb, $userpasswordSiteWeb, $addressId, $userisAdmin=0, $userisMember=0)
{
    $username = htmlspecialchars(strip_tags($username));
    $userfirstName = htmlspecialchars(strip_tags($userfirstName));
    $userphoneNumber = htmlspecialchars(strip_tags($userphoneNumber));
    $usermail = htmlspecialchars(strip_tags($usermail));
    $userpassword = htmlspecialchars(strip_tags($userpassword));
    $userisAdmin = htmlspecialchars(strip_tags($userisAdmin));
    $userisMember = htmlspecialchars(strip_tags($userisMember));
    $userloginSiteWeb = htmlspecialchars(strip_tags($userloginSiteWeb));
    $userpasswordSiteWeb = htmlspecialchars(strip_tags($userpasswordSiteWeb));
    $addressId = htmlspecialchars(strip_tags($addressId));

    //Hachage mot de passe
    $userpassword = password_hash($userpassword,PASSWORD_DEFAULT);

    $db = connectBdd();
    $insertUser = $db->prepare('INSERT INTO users (user_name,user_firstName,user_phoneNumber,user_mail,user_password,user_isAdmin,user_isMember,user_loginSiteWeb,user_passwordSiteWeb,address_id)
     VALUES (:name,:firstName,:phoneNumber,:mail,:password,:isAdmin,:isMember,:loginSiteWeb,:passwordSiteWeb,:addressId)');
    
    $insertUser->execute(array(
        ':name'=>$username,
        ':firstName'=>$userfirstName,
        ':phoneNumber'=>$userphoneNumber,
        ':mail'=>$usermail,
        ':password'=>$userpassword,
        ':isAdmin'=>$userisAdmin,
        ':isMember'=>$userisMember,
        ':loginSiteWeb'=>$userloginSiteWeb,
        ':passwordSiteWeb'=>$userpasswordSiteWeb,
        ':addressId'=>$addressId
    ));
    return true;
}
