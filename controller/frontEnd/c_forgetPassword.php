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
    if (isset($_POST['mailForgetPassword']) && !empty($_POST['mailForgetPassword'])) {
        if (filter_var($_POST['mailForgetPassword'], FILTER_VALIDATE_EMAIL)) {
            $mail = $_POST['mailForgetPassword'];
            //Vérification si mail existe déja
            $mailVerification = getUserByMail($mail);
            if (!$mailVerification) {
                $fillingError['mailForgetPassword'] = "Aucun compte ne correspond aux informations que vous avez saisies";
            } elseif (strlen($mail) > 255) {
                $fillingError['mailForgetPassword'] = '255 caractères maximum';
            } elseif (!$mailVerification['user_isMember']) {
                $error = "Vous devez être membre pour réinitialiser votre mot de passe.";
            }
        } else {
            $fillingError['mailForgetPassword'] = 'L\'adresse mail est incomplète';
        }
    } else {
        $fillingError['mailForgetPassword'] = 'Veuillez renseigner ce champ';
    }
    
    if (isset($fillingError) && !empty($fillingError)) {
        require_once('view/frontEnd/v_forgetPasswordTypeMail.php');
    } elseif (isset($error) && !empty($error)) {
        require_once('view/frontEnd/v_error.php');
    } else {
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
                require_once('view/frontEnd/v_error.php');
            }
        } else {
            $error = "Problème technique, veuillez réessayer ultérieurement";
            require_once('view/frontEnd/v_error.php');
        }
    }
}

//Affichage page "choisir un nouveau mot de passe" (après click sur le lien reçu par mail)
function displayTypeNewPassword()
{
    //Récupération mail et token (se trouvant dans le lien reçu par mail)
    if (filter_var($_GET['mail'], FILTER_VALIDATE_EMAIL)) {
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
}

//Affichage page Modifier mon mot de passe (après click dans mon compte, modifier mot de passe)
function displayChangePasswordPage()
{
    $mail = $_SESSION['mail'];
    require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
}
//Traitement enregistrement nouveau mot de passe après réinitialisation
function saveNewPasswordAfterReinitialization()
{
    $errorPbTechnique = "Problème technique, veuillez réessayer ultérieurement.";
    //On vérifie la présence et le format du mail
    if (isset($_POST['userMail'])) {
        if (filter_var($_POST['userMail'], FILTER_VALIDATE_EMAIL)) {
            $mail = $_POST['userMail'];
        } else {
            $error = $errorPbTechnique;
        }
    } else {
        $error = $errorPbTechnique;
    }
    //On vérifie la présence du token, si l'utilisateur est membre, si le token correspond à celui en bdd
    if (isset($_POST['userToken'])) {
        $token = $_POST['userToken'];
        //Vérification isMember et token
        $userVerification = getUserByMail($mail);
        if ($userVerification) {
            if ($userVerification['user_isMember']) {
                //Comparaison $_GET['token] et user_token
                if ($token != $userVerification['user_token']) {
                    $error = "Le lien utilisé ne fonctionne plus. Veuillez renouveller votre demande de réinitialisation de mot de passe.";
                }
            } else {
                $error = "Vous devez être membre pour réinitialiser votre mot de passe.";
            }
        } else {
            $error = $errorPbTechnique;
        }
    }
    //On vérifie si l'ancien mot de passe correspond bien à celui en base de donnée
    if (isset($_SESSION['mail'])) {
        //Récupération ancien mot de passe
        if (isset($_POST['oldPassword'])) {
            $oldpassword = $_POST['oldPassword'];
        }
        $passwordBdd = verifyPassword($oldpassword, $_SESSION['id']);
        if ($passwordBdd) {
            if (!password_verify($oldpassword, $passwordBdd)) {
                $fillingError['oldPassword'] = "Ancien mot de passe incorrect !";
            }
        } else {
            $error = $errorPbTechnique;
            require_once('view/frontEnd/v_error.php');
        }
    }
    //On vérifie la présence et la longueur des nouveaux mots de passe
    if (isset($_POST['passwordReinitialization1'])) {
        if (strlen($_POST['passwordReinitialization1']) > 255) {
            $fillingError['passwordReinitialization1'] = "255 caractères maximum.";
        } else {
            $password1 = $_POST['passwordReinitialization1'];
        }
    } else {
        $error = $errorPbTechnique;
    }
    if (isset($_POST['passwordReinitialization2'])) {
        $password2 = $_POST['passwordReinitialization2'];
    }
    //On vérifie si les 2 nouveaux mots de passe sont identiques
    if ($password1 != $password2) {
        $fillingError['passwordReinitialization1'] = "Les deux mots de passe ne sont pas identiques.";
    }
    //Traitement
    if (isset($error) && !empty($error)) {
        require_once('view/frontEnd/v_error.php');
    } elseif (isset($fillingError) && !empty($fillingError)) {
        require_once('view/frontEnd/v_forgetPasswordTypeNewPassword.php');
    } else {
        //Si reinitialisation utilisateur non connecté
        if (!isset($_SESSION['mail'])) {
            if (modifyPassword($mail, $password1)) {
                //on remet le user_token à null
                modifyToken($mail);
                $message = "Votre mot de passe a bien été réinitialisé.";
                require_once('view/frontEnd/v_message.php');
            } else {
                $error = $errorPbTechnique;
                require_once('view/frontEnd/v_error.php');
            }
        } else {
            //Sinon reinitialisation utilisateur connecté
            //Enregistrement nouveau mot de passe
            if (modifyPassword($mail, $password1)) {
                $message = "Votre mot de passe a bien été réinitialisé.";
                require_once('view/frontEnd/v_message.php');
            } else {
                $error = $errorPbTechnique;
                require_once('view/frontEnd/v_error.php');
            }
        }
    }
}
