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


