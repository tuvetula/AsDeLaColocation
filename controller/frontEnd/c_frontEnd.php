<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_getAdvertisement.php');

//Vérification login et mot de passe
function login()
{
    $login = getUser($_POST['login']);
    if ($login) {
        if (password_verify($_POST['password'], $login['user_password'])) {
            $_SESSION['login'] = $login['user_mail'];
            $_SESSION['id'] = $login['user_id'];
            $_SESSION['isAdmin'] = $login['user_isAdmin'];
        }
    }
}
function displayLoginPage(){
    require('view/frontEnd/displayLoginForm.php');
}

//Affichage page d'accueil utilisateur connecté
function displayHomeUser()
{
    $userAdvertisements = getUserAdvertisement($_SESSION['id']);
    
    require_once('view/frontEnd/displayHomeUser.php');
}

//Affichage Formulaire d'ajout d'une nouvelle annonce
function displayAddAnAdvertisementForm()
{
    require_once('view/frontEnd/displayPostAnAdvertisement.php');
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
