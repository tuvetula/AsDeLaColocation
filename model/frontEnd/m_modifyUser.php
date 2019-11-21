<?php
require_once('model/bdd/bddConfig.php');

//Modification User ("mon compte")
function modifyUser($userId,$usercivility,$userName,$userFirstName,$userdateOfBirth,$userMail,$userPhoneNumber){
    $userId = htmlspecialchars(strip_tags($userId));
    $usercivility = htmlspecialchars(strip_tags($usercivility));
    $userName = htmlspecialchars(strip_tags($userName));
    $userFirstName = htmlspecialchars(strip_tags($userFirstName));
    $userdateOfBirth = htmlspecialchars(strip_tags($userdateOfBirth));
    $userMail = htmlspecialchars(strip_tags($userMail));
    $userPhoneNumber = htmlspecialchars(strip_tags($userPhoneNumber));

    $db = connectBdd();
    $modifyUser = $db->prepare('UPDATE users SET 
    user_civility=:civility,
    user_name=:name,
    user_firstName=:firstName,
    user_dateOfBirth=:dateOfBirth,
    user_phoneNumber=:phoneNumber,
    user_mail=:mail
    WHERE user_id="'.$userId.'"');
    $modifyUser->execute(array(
        ':civility'=>$usercivility,
        ':name'=> ucfirst($userName),
        ':firstName'=> ucfirst($userFirstName),
        ':dateOfBirth'=>$userdateOfBirth,
        ':phoneNumber'=> $userPhoneNumber,
        ':mail'=> $userMail
    ));
    return true;
}
//Modification date création compte et token (après clique sur lien de confirmation d'inscription)
function validRegistrationBdd($mail){
    $mail = htmlspecialchars(strip_tags($mail));
    $db = connectBdd();
    $validRegistration = $db->prepare('UPDATE users SET 
    user_token=:token,
    user_accountCreationDate=:accountCreationDate,
    user_isMember=:isMember
    WHERE user_mail="'.$mail.'"');
    $validRegistration->execute(array(
        ':token'=> null,
        ':accountCreationDate'=>date('Y-m-d'),
        ':isMember'=> 1
    ));
    return true;
}

//Modification user_token
function modifyToken($mail,$token=null){
    $mail = htmlspecialchars(strip_tags($mail));
    $token = htmlspecialchars(strip_tags($token));
    $db = connectBdd();
    $modifyUserToken = $db->prepare('UPDATE users 
    SET user_token=:token 
    WHERE user_mail="'.$mail.'"');
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
    $modifyUserPassword = $db->prepare('UPDATE users 
    SET user_password=:newPassword 
    WHERE user_mail="'.$mail.'"');
    $modifyUserPassword->execute(array(
        ':newPassword'=> $newPassword
    ));
    return true;
}