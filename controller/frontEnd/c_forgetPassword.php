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
    $mailVerification = getUserByMail($mail);
    if ($mailVerification) {
        //On génère un token et on l'enregistre en base de donnée
        $token = sha1($mail.time());
        if (modifyToken($mail, $token)) {
            //On génère le lien à inscrire dans le mail
            global $mailLinkToSend;
            $link = $mailLinkToSend."action=password&token=$token&mail=$mail";
            //Création message à envoyer par mail
            $to = $mail;
            $subject = "Réinitialisation de votre mot de passe As de la coloc";
            $body = 'Bonjour,'."\r\n".'veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe :'."\r\n".''.$link.'';
            $headers[] = 'From: Asdelacoloc <no-reply@asdelacoloc.fr>'."\r\n".
            'Reply-To: no-reply@asdelacoloc.fr'."\r\n";
            //Envoi du mail à l'utilisateur
            if (mail($to, $subject, $body, implode("\r\n", $headers))) {
                //Redirection
                $message = 'Un lien vous permettant de modifier votre mot de passe va vous être envoyé dans quelques minutes à l\'adresse "'.$mail.'"';
                require_once('view/frontEnd/v_message.php');
            } else {
                $error = "Problème technique, veuillez réessayer ultérieurement";
            }
        } else {
            $error = "Problème technique, veuillez réessayer ultérieurement";
        }
    } else {
        $error = "Aucun compte ne correspond aux informations que vous avez saisies";
        require_once('view/frontEnd/v_forgetPasswordTypeMail.php');
    }
    require_once('view/frontEnd/v_error.php');
}

//Affichage page "choisir un nouveau mot de passe" (après click sur le lien reçu par mail)
function displayTypeNewPassword()
{
    //Récupération mail et token (se trouvant dans le lien reçu par mail)
    $mail = $_GET['mail'];
    $token = $_GET['token'];
    //Vérification si adresse mail existe en base de donnée
    $mailVerification = getUserByMail($mail);
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
function displayChangePasswordPage()
{
    $mail = $_SESSION['mail'];
    require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
}
//Traitement enregistrement nouveau mot de passe après réinitialisation
function saveNewPasswordAfterReinitialization()
{
    if (isset($_POST['userMail'])) {
        $mail = $_POST['userMail'];
    }
    if (isset($_POST['userToken'])) {
        $token = $_POST['userToken'];
    }
    $password1 = $_POST['passwordReinitialization1'];
    $password2 = $_POST['passwordReinitialization2'];
    
    //Vérification si les 2 mots de passe sont identiques
    if ($password1 == $password2) {
        //Si reinitialisation utilisateur non connecté
        if (!isset($_SESSION['mail'])) {
            //Vérification mail et token
            $tokenVerification = getUserByMail($mail);
            if ($tokenVerification) {
                //Comparaison $_GET['token] et user_token
                if ($token == $tokenVerification['user_token']) {
                    if (modifyPassword($mail, $password1)) {
                        //on remet le user_token à null
                        modifyToken($mail);
                        $message = "Votre mot de passe a bien été réinitialisé.";
                        require_once('view/frontEnd/v_message.php');
                    } else {
                        $error = "Problème technique, veuillez réessayer ultérieurement";
                        require_once('view/frontEnd/v_error.php');
                    }
                } else {
                    $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
                    require_once('view/frontEnd/v_error.php');
                }
            } else {
                $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
                require_once('view/frontEnd/v_error.php');
            }
            //Sinon reinitialisation utilisateur connecté
        } else {
            //Récupération ancien mot de passe
            $oldpassword = $_POST['oldPassword'];
            //On vérifie si l'ancien mot de passe correspond bien à celui en base de donnée
            if (!verifyPassword($oldpassword)) {
                $error = "Ancien mot de passe incorrect!";
                require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
            } else {
                //Enregistrement nouveau mot de passe
                if (modifyPassword($mail, $password1)) {
                    $message = "Votre mot de passe a bien été réinitialisé.";
                    require_once('view/frontEnd/v_message.php');
                } else {
                    $error = "Problème technique, veuillez réessayer ultérieurement";
                    require_once('view/frontEnd/v_error.php');
                }
            }
        }
    } else {
        $error = "Les deux mots de passe ne sont pas identiques.";
        require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
    }
}