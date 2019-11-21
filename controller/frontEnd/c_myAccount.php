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
        //Construction mot de passe
        $dayMonth = calculAccountCreationDateDayMonth($userData['user_accountCreationDate']);
        $passwordSiteWeb = 'Coloc'.$userData['user_id'].$dayMonth;
        //Date dans le bon sens
        $dateOfBirth = date_parse_from_format('Y-m-d', $userData['user_dateOfBirth']);
        $userData['user_dateOfBirth'] = $dateOfBirth['day'].'-'.$dateOfBirth['month'].'-'.$dateOfBirth['year'];
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
        if (strlen($addressStreet)>255) {
            $fillingError['street'] = "255 caractères maximum.";
        }
    }
    if (isset($_POST['zipcode'])) {
        $addressZipcode = $_POST['zipcode'];
        if (strlen($addressZipcode)>20) {
            $fillingError['zipcode'] = "20 caractères maximum.";
        }
    }
    if (isset($_POST['city'])) {
        $addressCity = $_POST['city'];
        if (strlen($addressCity)>60) {
            $fillingError['city'] = "60 caractères maximum.";
        }
    }
    if (isset($_POST['country'])) {
        $addressCountry = $_POST['country'];
        if (strlen($addressCountry)>60) {
            $fillingError['country'] = "60 caractères maximum.";
        }
    }
    //User $_POST
    if (isset($_POST['civility'])) {
        $usercivility = $_POST['civility'];
        if (strlen($usercivility)>20) {
            $fillingError['civility'] = "20 caractères maximum.";
        }
    }
    if (isset($_POST['name'])) {
        $userName = $_POST['name'];
        if (strlen($userName)>125) {
            $fillingError['name'] = "125 caractères maximum.";
        }
    }
    if (isset($_POST['firstName'])) {
        $userfirstName = $_POST['firstName'];
        if (strlen($userfirstName)>125) {
            $fillingError['firstName'] = "125 caractères maximum.";
        }
    }
    if (isset($_POST['dateOfBirth'])) {
        //On vérifie si c'est bien un format date
        $dateOfBirth = date_parse_from_format('Y-m-d', $_POST['dateOfBirth']);
        if (!$dateOfBirth['error_count'] == 0 || !checkdate($dateOfBirth['month'], $dateOfBirth['day'], $dateOfBirth['year'])) {
            $fillingError['dateOfBirth'] = "Vérifier votre date de naissance.";
        } else {
            //On vérifie si la date renseignée n'est pas supérieure à la date du jour
            $dateOfTheDay = date('Y-m-d', strtotime('-18 year'));
            if ($_POST['dateOfBirth'] > $dateOfTheDay) {
                $fillingError['dateOfBirth'] = "Date invalide, vous devez avoir plus de 18 ans pour utiliser nos services.";
            } else {
                $userdateOfBirth = $_POST['dateOfBirth'];
            }
        }
    }
    if (isset($_POST['mail']) && !empty($_POST['mail'])) {
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $usermail = $_POST['mail'];
            //Vérification si mail existe déja
            $mailVerification = verifyMailAlreadyPresent($usermail, $userIdAccountToModify);
            //Si le mail existe
            if ($mailVerification) {
                $fillingError['mail'] = "Un compte est déjà existant avec cette adresse mail.";
            } elseif (strlen($usermail) > 255) {
                $fillingError['mail'] = '255 caractères maximum.';
            }
        } else {
            $fillingError['mail'] = 'L\'adresse mail est incomplète.';
        }
    } else {
        $fillingError['mail'] = 'Veuillez renseigner ce champ.';
    }
    if (isset($_POST['phoneNumber'])) {
        $userphoneNumber = $_POST['phoneNumber'];
        if (strlen($userphoneNumber)>20) {
            $fillingError['phoneNumber'] = "20 caractères maximum.";
        }
    }
    //Résultat des contrôles
    if (!empty($fillingError)) {
        displayModifyMyAccount($userIdAccountToModify, null, $fillingError);
    } else {
        //On récupère l'address_id de l'utilisateur
        $addressIdUserRequest = getUserAddressId($userIdAccountToModify);
        $addressIdUser = $addressIdUserRequest['address_id'];
        //On modifie l'adresse (table addresses)
        if (modifyAddress($addressIdUser, $addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
            //On modifie les informations personnelles (table users)
            if (modifyUser($userIdAccountToModify, $usercivility, $userName, $userfirstName, $userdateOfBirth, $usermail, $userphoneNumber)) {
                //On affiche la page "mon compte"
                //On appelle la fonction pour afficher la page "mon compte"
                displayMyAccount($userIdAccountToModify);
            } else {
                $error = "Problème technique, veuillez réessayer ultérieurement.";
                require_once('view/frontEnd/v_error.php');
            }
        } else {
            $error = "Problème technique, veuillez réessayer ultérieurement.";
            require_once('view/frontEnd/v_error.php');
        }
    }
}
