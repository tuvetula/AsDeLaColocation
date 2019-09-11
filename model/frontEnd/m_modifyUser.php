<?php
require_once('model/bdd/bddConfig.php');

//Modification User ("mon compte")
function modifyUser($userId,$userName,$userFirstName,$userMail,$userPhoneNumber,$userLoginSiteWeb,$userPasswordSiteWeb){
    $userId = htmlspecialchars(strip_tags($userId));
    $userName = htmlspecialchars(strip_tags($userName));
    $userFirstName = htmlspecialchars(strip_tags($userFirstName));
    $userMail = htmlspecialchars(strip_tags($userMail));
    $userPhoneNumber = htmlspecialchars(strip_tags($userPhoneNumber));
    $userLoginSiteWeb = htmlspecialchars(strip_tags($userLoginSiteWeb));
    $userPasswordSiteWeb = htmlspecialchars(strip_tags($userPasswordSiteWeb));

    $db = connectBdd();
    $modifyUser = $db->prepare('UPDATE users SET 
    user_name=:name,
    user_firstName=:firstName,
    user_phoneNumber=:phoneNumber,
    user_mail=:mail,
    user_loginSiteWeb=:loginSiteWeb,
    user_passwordSiteWeb=:passwordSiteWeb
    WHERE user_id="'.$userId.'"');
    $modifyUser->execute(array(
        ':name'=> $userName,
        ':firstName'=> $userFirstName,
        ':phoneNumber'=> $userPhoneNumber,
        ':mail'=> $userMail,
        ':loginSiteWeb'=> $userLoginSiteWeb,
        ':passwordSiteWeb'=> $userPasswordSiteWeb
    ));
    return true;
}

//Modification user_token
function modifyToken($mail,$token=null){
    $mail = htmlspecialchars(strip_tags($mail));
    $db = connectBdd();
    $modifyUserToken = $db->prepare('UPDATE users SET 
    user_token=:token WHERE user_mail="'.$mail.'"');
    $modifyUserToken->execute(array(
        ':token'=> $token
    ));
    return true;
}

//Modification user_password
function modifyPassword($mail,$newPassword){
    $mail = htmlspecialchars(strip_tags($mail));
    $newPassword = password_hash(htmlspecialchars(strip_tags($newPassword)),PASSWORD_DEFAULT);
    $db = connectBdd();
    $modifyUserPassword = $db->prepare('UPDATE users SET 
    user_password=:newPassword WHERE user_mail="'.$mail.'"');
    $modifyUserPassword->execute(array(
        ':newPassword'=> $newPassword
    ));
    return true;
}