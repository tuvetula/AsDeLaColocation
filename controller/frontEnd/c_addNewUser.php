<?php
require_once('model/frontEnd/m_insertNewUser.php');
require_once('model/frontEnd/m_insertNewAddress.php');
require_once('model/frontEnd/m_getAddress.php');

//Enregistrement page d'inscription
function saveSubscribeForm()
{
    if (isset($_POST['passwordSubscribe1']) && isset($_POST['passwordSubscribe2']) && $_POST['passwordSubscribe1'] == $_POST['passwordSubscribe2']){
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
            $userfirstName = $_POST['firstName'];
        }
        if (isset($_POST['mailSubscribe'])) {
            $usermail = $_POST['mailSubscribe'];
        }
        if (isset($_POST['phoneNumber'])) {
            $userphoneNumber = $_POST['phoneNumber'];
        }
        if (isset($_POST['passwordSubscribe1'])) {
            $userpassword = $_POST['passwordSubscribe1'];
        }
        if (isset($_POST['loginSiteWeb'])) {
            $userloginSiteWeb = $_POST['loginSiteWeb'];
        }
        if (isset($_POST['passwordSiteWeb'])) {
            $userpasswordSiteWeb = $_POST['passwordSiteWeb'];
        }
    
        //Vérification si addresse existe déjà
        $addressVerification = getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry);
        if ($addressVerification) {
            $addressId = $addressVerification['address_id'];
        } else {
            //On enregistre la nouvelle adresse
            if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
                //On récupère l'id de l'adresse que l'on vient de créer
                $addressId = getLastAddressId()['MAX(address_id)'];
            }
        }
        //Ajout utilisateur
        insertNewUser($userName, $userfirstName, $userphoneNumber, $usermail, $userpassword, $userloginSiteWeb, $userpasswordSiteWeb, $addressId);
        header('Location:index.php?page=subscribeConfirmation');

    }else{
        header('Location:index.php?page=displaySubscribeForm');
    }
}
