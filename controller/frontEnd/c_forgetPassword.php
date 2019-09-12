<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_modifyUser.php');

//Affichage de la page "mot de passe oublié"
function displayforgetPasswordPage()
{
    require_once('view/frontEnd/displayForgetPasswordPage.php');
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
            //Lien mail
            $link = "http://localhost/asdelacolocation/index.php?token=$token&mailLink=$mail";
            //Création message à envoyer par mail
            $to = $mail;
            $subject = "Réinitialisation de votre mot de passe Asdelacolocation";
            $body = 'Bonjour,'."\r\n".' veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe :'."\r\n".''.$link.'';
            $headers[] = 'MIME-Version: 1.0';
            $headers[]= 'Content-type: text/html; charset=utf-8';
            //Envoi du mail
            if (mail($to, $subject, $body, implode("\r\n", $headers))) {
                //Redirection
                $message = 'Un lien vous permettant de modifier votre mot de passe vous a été envoyé à l\'adresse "'.$mail.'"';
                require_once('view/frontEnd/displayMessage.php');
            } else {
                $error = "Problème technique, veuillez réessayer ultérieurement";
            }
        } else {
            $error = "Problème technique, veuillez réessayer ultérieurement";
        }
    } else {
        $error = "Aucun compte ne correspond aux informations que vous avez saisies";
        require_once('view/frontEnd/displayForgetPasswordPage.php');
    }
    require_once('view/frontEnd/displayError.php');
}

//Affichage page "choisir un nouveau mot de passe"
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
            require_once('view/frontEnd/displayTypeNewPassword.php');
        } else {
            $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
        }
    } else {
        $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
    }
    require_once('view/frontEnd/displayError.php');
}

//Traitement enregistrement nouveau mot de passe après réinitialisation
function saveNewPasswordAfterReinitialization()
{
    $mail = $_GET['mailLink1'];
    $password1 = $_POST['passwordReinitialization1'];
    $password2 = $_POST['passwordReinitialization2'];
    //Vérification si les 2 mots de passe sont identiques
    if ($password1 == $password2) {
        //Enregistrement nouveau mot de passe
        if (modifyPassword($mail, $password1)) {
            //On remet le token à null
            if (modifyToken($mail)) {
                $message = "Votre mot de passe a bien été réinitialisé.";
                require_once('view/frontEnd/displayMessage.php');
            }
        }
    } else {
        $error = "Les deux mots de passe ne sont pas identiques.";
        require_once('view/frontEnd/displayTypeNewPassword.php');
    }
    $error = "Problème technique, veuillez réessayer ultérieurement";
    require_once('view/frontEnd/displayError.php');
}