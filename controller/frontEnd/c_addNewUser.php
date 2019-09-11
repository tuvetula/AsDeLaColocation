<?php
require_once('model/frontEnd/m_insertNewUser.php');
require_once('model/frontEnd/m_insertNewAddress.php');
require_once('model/frontEnd/m_getAddress.php');
require_once('model/frontEnd/m_getUser.php');

//Enregistrement page d'inscription
function saveSubscribeForm()
{
    //On récupère l'adresse mail saisie
    if (isset($_POST['mailSubscribe'])) {
        $usermail = $_POST['mailSubscribe'];
    }

    //Vérification si mail existe déja
    $mailVerification = getUser($usermail);
    //Si le mail n'existe pas
    if (!$mailVerification) {
        //Verification si les deux mots de passes donnés sont identiques
        if (isset($_POST['passwordSubscribe1']) && isset($_POST['passwordSubscribe2']) && $_POST['passwordSubscribe1'] == $_POST['passwordSubscribe2']) {
            //On stocke dans des variables les $_POST
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
         
            //Vérification si addresse adresse postale existe déjà
            $addressVerification = getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry);
            //Si l'adresse postale existe deja, on stocke l'id de cette adresse dans une variable
            if ($addressVerification) {
                $addressId = $addressVerification['address_id'];
            } else {
                //Sinon on enregistre la nouvelle adresse en base de donnée
                if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
                    //On récupère l'id de l'adresse que l'on vient de créer et on le stocke dans une variable
                    $addressId = getLastAddressId()['MAX(address_id)'];
                }
            }
            //On ajoute l'utilisateur à la base de donnée et on redirige vers la page de login
            if (insertNewUser($userName, $userfirstName, $userphoneNumber, $usermail, $userpassword, $userloginSiteWeb, $userpasswordSiteWeb, $addressId)) {
                //On définit un message de confirmation et on redirige vers la page de confirmation
                $message = "Votre inscription est bien enregistrée!";
                require_once('view/frontEnd/displayMessage.php');
            }
        } else {
            $error = "Les deux mots de passe ne sont pas identiques.";
            require_once('view/frontEnd/displaySubscribeForm.php');
        }
    } else {
        $error = "Un compte est déjà existant avec cette adresse mail.";
        require_once('view/frontEnd/displaySubscribeForm.php');
    }
}
