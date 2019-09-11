<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_getAdvertisement.php');

//Vérification login et mot de passe
function login()
{
    $login = getUser($_POST['mail']);
    if ($login) {
        if($login['user_isMember']==1){
            if (password_verify($_POST['password'], $login['user_password'])) {
                $_SESSION['mail'] = $login['user_mail'];
                $_SESSION['id'] = $login['user_id'];
                $_SESSION['isAdmin'] = $login['user_isAdmin'];
                header('Location:index.php');
            }else{
                header('Location:index.php?error=pbLog');
            }
        }else{
            header('Location:index.php?error=pbStatue');
        }
    }else{
        header('Location:index.php?error=pbLog');
    }
}

//Affichage page de connexion
function displayLoginPage(){
    if (isset($_GET['error'])){
        if ($_GET['error'] == "pbLog"){
            $error = "Mauvais identifiant ou mot de passe.";
        }else if ($_GET['error'] == "pbStatue"){
            $error = "Accès refusé. Vous n'êtes pas membre.";
        }
    }else{
        $error="";
    }
    require_once('view/frontEnd/displayLoginForm.php');
}

//Affichage page d'inscription
function displaySubscribePage(){
    if (isset($_GET['error'])){
        if ($_GET['error'] == "pbMail"){
            $error = "Cette adresse mail est déja utilisée";
        }
    }else{
        $error="";
    }
    require_once('view/frontEnd/displaySubscribeForm.php');
}

//Affichage page d'accueil utilisateur connecté
function displayHomeUser()
{
    require_once('view/frontEnd/displayHomeUser.php');
}
//Affichage page Mon compte
function displayMyAccount(){
    require_once('model/frontEnd/m_getUser.php');
    $userData = getUserById($_SESSION['id']);
    require_once('view/frontEnd/displayMyAccount.php');
}
//Affichage page Modifier mon compte
function displayModifyMyAccount(){
    require_once('model/frontEnd/m_getUser.php');
    $userDataToModify = getUserById($_SESSION['id']);
    require_once('view/frontEnd/displaymodifyMyAccountForm.php');
}
//Affichage page d'erreur
function displayErrorNewAdvertisement(){
    require_once('view/frontEnd/displayErrorPage.php');
}
//Affichage de la page "Mes annonces"
function displayMyAdvertisements(){
    require_once('model/frontEnd/m_getPicture.php');
    //Récupération annonces utilisateurs
    $userAdvertisements = getUserAdvertisement($_SESSION['id']);
    //Mise en tableau des id des annonces de l'utilisateur
    $advertisementIdArray = array();
    foreach($userAdvertisements as $key => $value){
        array_push($advertisementIdArray,$userAdvertisements[$key]['advertisement_id']);
    }
    //Récupération de la photo Order 1 de chaque annonce
    $pictureFilename = array();
    foreach($advertisementIdArray as $key => $value){
        $pictureFilename[$value] =getAdvertisementPictureOrder1($value);
    }
    //Integration photos dans le tableau $userAdvertisements
    for($i = 0 ; $i < count($userAdvertisements) ; $i++){
        foreach($pictureFilename as $key => $value){
            if ($userAdvertisements[$i]['advertisement_id'] == $key && $pictureFilename[$key]!=false){
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
function displayforgetPasswordPage(){
    if (isset($_GET['message'])) {
        if ($_GET['message'] == "mailOk") {
            $message = "Un lien vous permettant de modifier votre mot de passe vous a été envoyé";
        } else if ($_GET['message'] == "error"){
            $message = "Aucun compte ne correspond aux informations que vous avez saisies";
        } else {
            $message="";
        }
    }
    require_once('view/frontEnd/displayForgetPasswordPage.php');
}

//Traitement mot de passe oublié
function forgetPassword(){
    require_once('model/frontEnd/m_modifyUser.php');
    //Récupération adresse mail depuis $_POST
    $mail = $_POST['mailForgetPassword'];
    //Vérification si l'adresse mail existe en base de donnée
    $mailVerification = getUser($mail);
    if($mailVerification){
        //On génère un token et on l'enregistre en base de donnée
        $token = sha1($mail.time());
        modifyToken($mail,$token);
        //Lien mail
        $link = "http://localhost/asdelacolocation/index.php?token=$token&mail=$mail";
        //Création message à envoyer par mail
        $to = $mail;
        $subject = "Réinitialisation de votre mot de passe Asdelacolocation";
        $body = 'Bonjour, veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : '.$link.'';
        $header = 'MIME-Version: 1.0\r\n';
        $header .= 'Content-type: text/html; charset=utf-8\r\n';
        //Envoi du mail
        mail($to,$subject,$body,$header);
        //Redirection
        header('Location:index.php?page=forgetPassword&message=mailOk');
    }else{
        header('Location:index.php?page=forgetPassword&message=error');
    }
}














//VOYAGE TP
function displayTravels(){
    $travels = getTravels();
    $pageEnCours="index";
    require('view/frontEnd/displayTravels.php');
}

function displayLogins(){
    $pageEnCours='loginmdp';
    require('view/frontEnd/displayLoginForm.php');
}

function displayPage(){
    switch($_GET['page']){
        case 'voyages':
            displayTravels();
            break;

        case 'loginForm':
            displayLogins();
            break;

        default:
            displayTravels();
            break;
    }
}