<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_getAddress.php');
require_once('model/frontEnd/m_modifyUser.php');
require_once('model/frontEnd/m_modifyAddress.php');

//Affichage page Mon compte
function displayMyAccount()
{
    $userData = getUserById($_SESSION['id']);
    require_once('view/frontEndUserConnected/v_myAccount.php');
}

//Affichage page Modifier mon compte
function displayModifyMyAccount()
{
    $userDataToModify = getUserById($_SESSION['id']);
    require_once('view/frontEndUserConnected/v_myAccountModificationForm.php');
}

//Traitement modification mon compte
function modifyMyAccount(){
    //Address $_POST
    if (isset($_POST['street'])) {
        $addressStreet = $_POST['street'];
    }
    if (isset($_POST['zipcode'])) {
        $addressZipcode = $_POST['zipcode'];
    }
    if (isset($_POST['city'])) {
        $addressCity = $_POST['city'];
    }
    if (isset($_POST['country'])) {
        $addressCountry = $_POST['country'];
    }
    //User $_POST
    if (isset($_POST['name'])) {
        $userName = $_POST['name'];
    }
    if (isset($_POST['firstName'])) {
        $userFirstName = $_POST['firstName'];
    }
    if (isset($_POST['mail'])) {
        $usermail = $_POST['mail'];
    }
    if (isset($_POST['phoneNumber'])) {
        $userPhoneNumber = $_POST['phoneNumber'];
    }
    if (isset($_POST['loginSiteWeb'])) {
        $userLoginSiteWeb = $_POST['loginSiteWeb'];
    }
    if (isset($_POST['passwordSiteWeb'])) {
        $userPasswordSiteWeb = $_POST['passwordSiteWeb'];
    }

    //On vérifie si l'adresse existe déjà et si oui on modifie que la table users
    $addressRequest = getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry);
    //Si l'adresse n'existe pas, on modifie l'adresse en base de donnée
    if (!$addressRequest){
        //On récupère l'address_id de l'utilisateur
        $addressIdUserRequest = getUserAddressId($_SESSION['id']);
        $addressIdUser = $addressIdUserRequest['address_id'];
        //On modifie l'adresse (table addresses)
        modifyAddress($addressIdUser,$addressStreet,$addressZipcode,$addressCity,$addressCountry);
    }
    //On modifie les coordonnées (table users)
    modifyUser($_SESSION['id'],$userName,$userFirstName,$usermail,$userPhoneNumber,$userLoginSiteWeb,$userPasswordSiteWeb);
    //On récupère les nouvelles informations suite à la modification
    $userData = getUserById($_SESSION['id']);
    //On affiche la page "mon compte"
    require_once('view/frontEndUserConnected/v_myAccount.php');
}