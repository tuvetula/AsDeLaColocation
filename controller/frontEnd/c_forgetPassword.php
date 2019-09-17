<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_modifyUser.php');
require_once('model/bdd/config.php');

//Affichage de la page "mot de passe oublié"
function displayforgetPasswordPage()
{
    require_once('view/frontEnd/v_forgetPasswordTypeMail.php');
}

//Traitement mot de passe oublié (envoi mail après saisie adresse mail dans displayForgetPasswordPage)
function forgetPassword()
{
    //Récupération adresse mail depuis $_POST
    $mail = $_POST['mailForgetPassword'];
    //Vérification si l'adresse mail existe en base de donnée
    $mailVerification = getUser($mail);
    if ($mailVerification) {
        //On génère un token et on l'enregistre en base de donnée
        $token = sha1($mail.time());
        if (modifyToken($mail, $token)) {
            //On génère le lien à inscrire dans le mail
            global $mailLinkToSend;
            $link = $mailLinkToSend."token=$token&mailLink=$mail";
            //Création message à envoyer par mail
            $to = $mail;
            $subject = "Réinitialisation de votre mot de passe As de la coloc";
            $body = 'Bonjour,'."\r\n".' veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe :'."\r\n".''.$link.'';
            $headers[] = 'MIME-Version: 1.0';
            $headers[]= 'Content-type: text/html; charset=utf-8';
            //Envoi du mail
            if (mail($to, $subject, $body, implode("\r\n", $headers))) {
                //Redirection
                $message = 'Un lien vous permettant de modifier votre mot de passe vous a été envoyé à l\'adresse "'.$mail.'"';
                require_once('view/frontEnd/v_message.php');
            } else {
                $error = "Problème technique, veuillez réessayer ultérieurement";
            }
        } else {
            $error = "Problème technique, veuillez réessayer ultérieurement";
        }
    } else {
        $error = "Aucun compte ne correspond aux informations que vous avez saisies";
        require_once('view/frontEnd/v_ForgetPasswordTypeMail.php');
    }
    require_once('view/frontEnd/v_error.php');
}

//Affichage page "choisir un nouveau mot de passe" (après click sur le lien reçu par mail)
function displayTypeNewPassword()
{
    //Récupération mail et token (se trouvant dans le lien reçu par mail)
    $mail = $_GET['mailLink'];
    $token = $_GET['token'];
    //Vérification si adresse mail existe en base de donnée
    $mailVerification = getUser($mail);
    if ($mailVerification) {
        //Comparaison $_GET['token] et user_token
        if ($token == $mailVerification['user_token']) {
            //Affichage page choisir un nouveau mot de passe
            require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
        } else {
            $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
        }
    } else {
        $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
    }
    require_once('view/frontEnd/v_error.php');
}

//Affichage page Modifier mon mot de passe (après click dans mo compte, modifier mot de passe)
function displayChangePasswordPage(){
    $mail = $_SESSION['mail'];
    require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
}
//Traitement enregistrement nouveau mot de passe après réinitialisation
function saveNewPasswordAfterReinitialization()
{
    $mail = $_POST['userMail'];
    $password1 = $_POST['passwordReinitialization1'];
    $password2 = $_POST['passwordReinitialization2'];
    //Récupération ancien mot de passe si utilisateur connecté
    if (isset($_SESSION['mail'])){
        $oldpassword = $_POST['oldPassword'];
        //On vérifie si l'ancien mot de passe correspond bien à celui en base de donnée
        if(!verifyPassword($oldpassword)){
            $error = "Ancien mot de passe incorrect!";
            require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
            exit;
        }
    }
    //Vérification si les 2 mots de passe sont identiques
    if ($password1 == $password2) {
        //Enregistrement nouveau mot de passe
        if (modifyPassword($mail, $password1)) {
            //Si l'utilisateur n'est pas connecté, on remet le user_token à null
            if (!isset($_SESSION['mail'])){
                modifyToken($mail);
            }
            $message = "Votre mot de passe a bien été réinitialisé.";
            require_once('view/frontEnd/v_message.php');
        }else{
            $error = "Problème technique, veuillez réessayer ultérieurement";
            require_once('view/frontEnd/v_error.php');
        }
    } else {
        $error = "Les deux mots de passe ne sont pas identiques.";
        require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
    }
}