<?php
require_once('model/frontEnd/m_insertNewUser.php');
require_once('model/frontEnd/m_insertNewAddress.php');
require_once('model/frontEnd/m_getAddress.php');
require_once('model/frontEnd/m_deleteAddress.php');
require_once('model/frontEnd/m_getUser.php');
require_once('model/bdd/config.php');

//Affichage page d'inscription
function displaySubscribePage()
{
    require_once('view/frontEnd/v_subscribeForm.php');
}

//Enregistrement page d'inscription
function saveSubscribeForm()
{
    //On récupère l'adresse mail et vérifie si c'est bien un mail
    if (isset($_POST['mailSubscribe']) && !empty($_POST['mailSubscribe'])) {
        if (filter_var($_POST['mailSubscribe'], FILTER_VALIDATE_EMAIL)) {
            $usermail = $_POST['mailSubscribe'];
            //Vérification si mail existe déja
            $mailVerification = getUser($usermail);
            //Si le mail existe
            if ($mailVerification) {
                $fillingError['mailSubscribe'] = "Un compte est déjà existant avec cette adresse mail.";
            }else if (strlen($usermail) > 255) {
                $fillingError['mailSubscribe'] = '255 caractères maximum.';
            }
        } else {
            $fillingError['mailSubscribe'] = 'L\'adresse mail est incomplète.';
        }
    } else {
        $fillingError['mailSubscribe'] = 'Veuillez renseigner ce champ.';
    }              
    //On stocke dans des variables les $_POST
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
            $dateOfTheDay = date('Y-m-d');
            $dateTobeAdult = date('Y-m-d', strtotime('-18 year'));
            if ($_POST['dateOfBirth'] > $dateOfTheDay) {
                $fillingError['dateOfBirth'] = "Vérifier votre date de naissance.";
            }else if ($_POST['dateOfBirth'] > $dateTobeAdult){
                $fillingError['dateOfBirth'] = "Date invalide, vous devez avoir plus de 18 ans pour utiliser nos services.";
            } else {
                $userdateOfBirth = $_POST['dateOfBirth'];
            }
        }
    }
    if (isset($_POST['phoneNumber'])) {
        $userphoneNumber = $_POST['phoneNumber'];
        if (strlen($userphoneNumber)>20) {
            $fillingError['phoneNumber'] = "20 caractères maximum.";
        }
    }
    if (isset($_POST['passwordSubscribe1']) && isset($_POST['passwordSubscribe2']) && $_POST['passwordSubscribe1'] == $_POST['passwordSubscribe2']) {
        $userpassword = $_POST['passwordSubscribe1'];
        if (strlen($userpassword)>255) {
            $fillingError['password'] = "255 caractères maximum";
        }
    } else {
        $fillingError['passwordSubscribe1'] = "Les deux mots de passe ne sont pas identiques.";
    }
    if (empty($fillingError)) {
        //On enregistre la nouvelle adresse en base de donnée
        $addressId = insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry);
        if ($addressId) {
            //Création token
            $token = sha1($usermail.time());
            //On ajoute l'utilisateur à la base de donnée et on redirige vers la page de login
            if (insertNewUser($usercivility, $userName, $userfirstName, $userdateOfBirth, $userphoneNumber, $usermail, $userpassword, $token, $addressId)) {
                //On génère le lien à inscrire dans le mail
                global $mailLinkToSend;
                $link = $mailLinkToSend."action=registration&token=$token&mail=$usermail";
                //Création message à envoyer par mail
                $to = $usermail;
                $subject = "Confirmation de votre inscription As de la coloc";
                $body = 'Bonjour,'."\r\n".'Merci pour votre inscription sur le site Asdelacoloc.'."\r\n".''."\r\n".'Afin de finaliser votre inscription, veuillez cliquer sur le lien suivant s\'il vous plait :'."\r\n".''.$link.''."\r\n".''."\r\n".'Vous pourrez vous connecter avec votre adresse mail qui est votre identifiant.'."\r\n".'Et votre mot de passe saisie lors de l\'inscription.'."\r\n".'La connexion c\'est par ici : https://www.app.asdelacoloc.fr'."\r\n".''."\r\n".'Vous allez pouvoir déposer votre annonce, mais avant cela je vous suggère de consulter quelques recommandations en cliquant sur le lien ci-dessous :'."\r\n".'https://www.app.asdelacoloc.fr/explications/'."\r\n".''."\r\n".'Vous êtes sur le chemin de l\'automatisation de votre colocation grâce à Asdelacoloc, je vous dis à bientôt !'."\r\n".''."\r\n".'Aurélien';
                $headers[] = 'From: Asdelacoloc <no-reply@asdelacoloc.fr>'."\r\n".
                'Reply-To: no-reply@asdelacoloc.fr'."\r\n";
                //Envoi du mail à l'utilisateur
                mail($to, $subject, $body, implode("\r\n", $headers));
                //On définit un message de confirmation et on redirige vers la page de confirmation
                $message = "Votre inscription est bien enregistrée !";
                $message2 = "Vous allez recevoir un mail de demande de confirmation. Cliquez sur le lien dans l’email pour confirmer votre inscription.";
                //Affichage page de confirmation d'inscription
                require_once('view/frontEnd/v_message.php');
            } else {
                //On efface l'adresse créée
                deleteAddressBdd($addressId);
                $error = 'Problème technique. Veuillez réessayer ultérieurement.';
            }
        } else {
            $error = 'Problème technique. Veuillez réessayer ultérieurement.';
        }
    }
    require_once('view/frontEnd/v_subscribeForm.php');
}

//Validation de l'inscription
function validRegistration()
{
    $usermail = $_GET['mail'];
    $token = $_GET['token'];
    //On récupère les infos de l'utilisateur lié au mail présent dans le lien
    $userInfo = getUserByMail($usermail);
    if ($userInfo) {
        //On vérifie si le token récupéré dans le lien du mail correspond à celui en bdd
        if ($userInfo['user_token'] == $token) {
            //On enregistre la date de création de compte en bdd et on supprime le token
            if (validRegistrationBdd($usermail)) {
                //Création message à envoyer par mail à l'administrateur
                global $ownMail;
                global $addressSite;
                $to = $ownMail;
                $subject = "Nouvelle inscription";
                $body = 'Bonjour,'."\r\n".$userInfo['user_name'].' '.$userInfo['user_firstName'].' vient de s\'inscrire sur le site '.$addressSite.'';
                $headers[] = 'MIME-Version: 1.0';
                $headers[]= 'Content-type: text/html; charset=utf-8';
                $headers[] = 'From: Asdelacoloc <no-reply@asdelacoloc.fr>'."\r\n".
                'Reply-To: no-reply@asdelacoloc.fr'."\r\n";
                //Envoi du mail à l'administrateur
                mail($to, $subject, $body, implode("\r\n", $headers));
                $message = "Votre inscription a été validée !";
                $message2 = "Vous pouvez dès à présent vous connecter à votre espace personnel.";
                //Affichage page de confirmation d'inscription
                require_once('view/frontEnd/v_message.php');
            }
        } else {
            $error = "Veuillez contacter un administrateur du site.";
        }
    } else {
        $error = "Veuillez contacter un administrateur du site.";
    }
    require_once('view/frontEnd/v_error.php');
}