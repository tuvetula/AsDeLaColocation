<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_modifyUser.php');
require_once('model/frontEnd/m_getAdvertisement.php');

//Vérification login et mot de passe
function login()
{
    //On verifie si le mail existe en base de donnée
    $mailVerification = getUser($_POST['mailLogin']);
    if ($mailVerification) {
        //On vérifie si l'utilisateur a renseigné le bon mot de passe
        if (password_verify($_POST['passwordLogin'], $mailVerification['user_password'])) {
            //On vérifie si l'utilisateur est membre
            if ($mailVerification['user_isMember']==1) {
                $_SESSION['mail'] = $mailVerification['user_mail'];
                $_SESSION['id'] = $mailVerification['user_id'];
                $_SESSION['isAdmin'] = $mailVerification['user_isAdmin'];
                require_once('view/frontEnd/displayHomeUser.php');
            } else {
                $error = "Accès refusé. Vous n'êtes pas membre.";
                require_once('view/frontEnd/displayLoginForm.php');
            }
        } else {
            $error = "Mauvais identifiant et/ou mot de passe.";
            require_once('view/frontEnd/displayLoginForm.php');
        }
    } else {
        $error = "Mauvais identifiant et/ou mot de passe.";
        require_once('view/frontEnd/displayLoginForm.php');
    }
}

//Affichage page de connexion
function displayLoginPage()
{
    require_once('view/frontEnd/displayLoginForm.php');
}
//Affichage page d'accueil utilisateur connecté
function displayHomeUser()
{
    require_once('view/frontEnd/displayHomeUser.php');
}
//Affichage page Mon compte
function displayMyAccount()
{
    require_once('model/frontEnd/m_getUser.php');
    $userData = getUserById($_SESSION['id']);
    require_once('view/frontEnd/displayMyAccount.php');
}
//Affichage page Modifier mon compte
function displayModifyMyAccount()
{
    require_once('model/frontEnd/m_getUser.php');
    $userDataToModify = getUserById($_SESSION['id']);
    require_once('view/frontEnd/displaymodifyMyAccountForm.php');
}
//Affichage page d'erreur
function displayErrorNewAdvertisement()
{
    require_once('view/frontEnd/displayErrorPage.php');
}
//Affichage de la page "Mes annonces"
function displayMyAdvertisements()
{
    require_once('model/frontEnd/m_getPicture.php');
    //Récupération annonces utilisateurs
    $userAdvertisements = getUserAdvertisement($_SESSION['id']);
    //Mise en tableau des id des annonces de l'utilisateur
    $advertisementIdArray = array();
    foreach ($userAdvertisements as $key => $value) {
        array_push($advertisementIdArray, $userAdvertisements[$key]['advertisement_id']);
    }
    //Récupération de la photo Order 1 de chaque annonce
    $pictureFilename = array();
    foreach ($advertisementIdArray as $key => $value) {
        $pictureFilename[$value] =getAdvertisementPictureOrder1($value);
    }
    //Integration photos dans le tableau $userAdvertisements
    for ($i = 0 ; $i < count($userAdvertisements) ; $i++) {
        foreach ($pictureFilename as $key => $value) {
            if ($userAdvertisements[$i]['advertisement_id'] == $key && $pictureFilename[$key]!=false) {
                $userAdvertisements[$i]['picture_fileName'] = $value;
            }
        }
    }
    //Déclaration variable url bouton supprimer
    $deleteUrl = 'index.php?page=deleteAdvertisement&id=';
    require_once('view/frontEnd/displayMyAdvertisements.php');
}
//Affichage Formulaire d'ajout d'une nouvelle annonce
function displayAddAnAdvertisementForm()
{
    //Variable pour définir date minimum dans "disponible le"
    $dateOfTheDay=date('Y-m-d');
    require_once('view/frontEnd/displayPostAnAdvertisement.php');
}

//Affichage de la page "mot de passe oublié"
function displayforgetPasswordPage()
{
    if (isset($_GET['message'])) {
        if ($_GET['message'] == "mailOk") {
            $message = "Un lien vous permettant de modifier votre mot de passe vous a été envoyé";
        } elseif ($_GET['message'] == "error1") {
            $message = "Aucun compte ne correspond aux informations que vous avez saisies";
        } elseif ($_GET['message'] == "error2") {
            $message = "Problème technique, veuillez réessayer ultérieurement";
        } else {
            $message="";
        }
    }
    require_once('view/frontEnd/displayForgetPasswordPage.php');
}

//Traitement mot de passe oublié (envoi mail)
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
            $link = "http://localhost/asdelacolocation/index.php?token=$token&mail=$mail";
            //Création message à envoyer par mail
            $to = $mail;
            $subject = "Réinitialisation de votre mot de passe Asdelacolocation";
            $body = 'Bonjour,'."\r\n".' veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe :'."\r\n".''.$link.'';
            $headers[] = 'MIME-Version: 1.0';
            $headers[]= 'Content-type: text/html; charset=utf-8';
            //Envoi du mail
            if (mail($to, $subject, $body, implode("\r\n", $headers))) {
                //Redirection
                header('Location:index.php?page=forgetPassword&message=mailOk');
            } else {
                header('Location:index.php?page=forgetPassword&message=error2');
            }
        } else {
            header('Location:index.php?page=forgetPassword&message=error2');
        }
    } else {
        header('Location:index.php?page=forgetPassword&message=error1');
    }
}

//Affichage page "choisir un nouveau mot de passe"
function displayTypeNewPassword()
{
    $mail = $_GET['mail'];
    $token = $_GET['token'];
    //Vérification si adresse mail existe en base de donnée
    $mailVerification = getUser($mail);
    if ($mailVerification) {
        //Comparaison $_GET['token] et user_token
        if ($token == $mailVerification['user_token']) {
            //Affichage page choisir un nouveau mot de passe
            require_once('view/frontEnd/displayTypeNewPassword.php');
        } else {
            header('Location:index.php?page=error&message=wrongMailToken');
        }
    } else {
        header('Location:index.php?page=error&message=wrongMailToken');
    }
}

//Traitement enregistrement nouveau mot de passe après réinitialisation
function saveNewPasswordAfterReinitialization()
{
    $mail = $_GET['mail'];
    $password1 = $_POST['passwordReinitialization1'];
    $password2 = $_POST['passwordReinitialization2'];
    //Vérification si les 2 mots de passe sont identiques
    if ($password1 == $password2) {
        //Enregistrement nouveau mot de passe
        if (modifyPassword($mail, $password1)) {
            //On remet le token à null
            if (modifyToken($mail)) {
                header('Location:index.php?message=reinitializationOk');
            } else {
                header('Location:index.php');
            }
        } else {
            header('Location:index.php');
        }
    } else {
        header('Location:index.php?');
    }
}
