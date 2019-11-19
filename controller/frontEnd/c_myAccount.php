<?php
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_getAddress.php');
require_once('model/frontEnd/m_modifyUser.php');
require_once('model/frontEnd/m_modifyAddress.php');
require_once('controller/frontEnd/functions/calculDayMonthAccountCreationDate.php');

//Affichage page Mon compte
function displayMyAccount($userId=null)
{
    if ($userId) {
        $userData = getUserById($userId);
    } else {
        $userData = getUserById($_SESSION['id']);
    }
    if ($userData) {
        $yearMonth = calculAccountCreationDateYearMonth($userData['user_accountCreationDate']);
        $passwordSiteWeb = 'Coloc'.$userData['user_id'].$yearMonth;
        require_once('view/frontEndUserConnected/v_myAccount.php');
    } else {
        $error = "Erreur!";
        require_once('view/frontEnd/v_error.php');
    }
}

//Affichage page Modifier mon compte
function displayModifyMyAccount($userId = null, $error=null, $fillingError=null)
{
    if ($userId) {
        $userDataToModify = getUserById($userId);
    } else {
        $userDataToModify = getUserById($_SESSION['id']);
    }
    if ($userDataToModify) {
        require_once('view/frontEndUserConnected/v_myAccountModificationForm.php');
    } else {
        $error = "Erreur!";
        require_once('view/frontEnd/v_error.php');
    }
}

//Traitement modification mon compte
function modifyMyAccount($userId=null)
{
    //id de l'utilisateur à modifier
    if ($userId) {
        $userIdAccountToModify = $userId;
    } else {
        $userIdAccountToModify = $_SESSION['id'];
    }
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
        if (strlen($_POST['mail']) > 255) {
            $fillingError['mail'] = '255 caractères maximum';
        } else {
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $usermail = $_POST['mail'];
            } else {
                $fillingError['mail'] = 'L\'adresse mail est incomplète';
            }
        }
    }
    if (isset($_POST['phoneNumber'])) {
        $userPhoneNumber = $_POST['phoneNumber'];
    }
    //Résultat des contrôles
    if (!empty($fillingError)) {
        displayModifyMyAccount($userIdAccountToModify,null,$fillingError);
    } else {
        //On verifie si l'adresse mail n'existe pas déja
        if (empty(verifyMailAlreadyPresent($usermail, $userIdAccountToModify))) {
            //On récupère l'address_id de l'utilisateur
            $addressIdUserRequest = getUserAddressId($userIdAccountToModify);
            $addressIdUser = $addressIdUserRequest['address_id'];
            //On modifie l'adresse (table addresses)
            if (modifyAddress($addressIdUser, $addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
                //On modifie les informations personnelles (table users)
                if (modifyUser($userIdAccountToModify, $userName, $userFirstName, $usermail, $userPhoneNumber)) {
                    //On affiche la page "mon compte"
                    if ($_SESSION['isAdmin']) {
                        if ($_SESSION['id'] == $userIdAccountToModify) {
                            $message = "Vos informations personnelles ont bien été modifiées";
                        } else {
                            $message = "Les informations personnelles de l'utilisateur ont bien été modifiées";
                        }
                        require_once('controller/backEnd/c_users.php');
                        displayUsers($error=null, $message);
                    } else {
                        //On appelle la fonction pour afficher la page "mon compte"
                        displayMyAccount($userIdAccountToModify);
                    }
                } else {
                    $error = "Problème technique, veuillez réessayer ultérieurement.";
                }
            } else {
                $error = "Problème technique, veuillez réessayer ultérieurement.";
            }
        } else {
            $error = "mail";
            displayModifyMyAccount($userIdAccountToModify, $error);
        }
    }
}
