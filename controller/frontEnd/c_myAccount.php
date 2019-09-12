<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_getAddress.php');
require_once('model/frontEnd/m_modifyUser.php');
require_once('model/frontEnd/m_modifyAddress.php');

//Affichage page Mon compte
function displayMyAccount()
{
    $userData = getUserById($_SESSION['id']);
    require_once('view/frontEnd/displayMyAccount.php');
}

//Affichage page Modifier mon compte
function displayModifyMyAccount()
{
    $userDataToModify = getUserById($_SESSION['id']);
    require_once('view/frontEnd/displaymodifyMyAccountForm.php');
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

    //On récupère l'address_id de l'utilisateur
    $addressIdUserRequest = getUserAddressId($_SESSION['id']);
    $addressIdUser = $addressIdUserRequest['address_id'];
    //On modifie l'adresse (table addresses)
    modifyAddress($addressIdUser,$addressStreet,$addressZipcode,$addressCity,$addressCountry);
    //On modifie les coordonnées (table users)
    modifyUser($_SESSION['id'],$userName,$userFirstName,$usermail,$userPhoneNumber,$userLoginSiteWeb,$userPasswordSiteWeb);
    header('Location:index.php?page=displayMyAccount');
}