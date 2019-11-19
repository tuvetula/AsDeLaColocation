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
        if (strlen($_POST['mailSubscribe']) > 255) {
            $error = '255 caractères maximum';
        } else {
            if (filter_var($_POST['mailSubscribe'], FILTER_VALIDATE_EMAIL)) {
                $usermail = $_POST['mailSubscribe'];
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
                     
                        //On enregistre la nouvelle adresse en base de donnée
                        if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
                            //On récupère l'id de l'adresse que l'on vient de créer et on le stocke dans une variable
                            $addressId = getLastAddressId()['MAX(address_id)'];
                            //Création token
                            $token = sha1($usermail.time());
                            //On ajoute l'utilisateur à la base de donnée et on redirige vers la page de login
                            if (insertNewUser($userName, $userfirstName, $userphoneNumber, $usermail, $userpassword, $token, $addressId)) {
                                //On génère le lien à inscrire dans le mail
                                global $mailLinkToSend;
                                $link = $mailLinkToSend."action=registration&token=$token&mail=$usermail";
                                //Création message à envoyer par mail
                                $to = $usermail;
                                $subject = "Confirmation de votre inscription As de la coloc";
                                $body = 'Bonjour,'."\r\n".'veuillez cliquer sur le lien suivant pour confirmer votre inscription :'."\r\n".''.$link.'';
                                $headers[] = 'From: Asdelacoloc <no-reply@asdelacoloc.fr>'."\r\n".
                                'Reply-To: no-reply@asdelacoloc.fr'."\r\n";
                                //Envoi du mail à l'utilisateur
                                mail($to, $subject, $body, implode("\r\n", $headers));
                                //On définit un message de confirmation et on redirige vers la page de confirmation
                                $message = "Votre inscription est bien enregistrée !";
                                $message2 = "Vous allez recevoir un mail de demande de confirmation. Cliquez sur le lien dans l’email pour confirmer votre inscription";
                                //Affichage page de confirmation d'inscription
                                require_once('view/frontEnd/v_message.php');
                            } else {
                                //On efface l'adresse créée
                                deleteAddressBdd($addressId);
                                $error = 'Problème technique. Veuillez réessayer ultérieurement';
                            }
                        }
                    } else {
                        $error = "Les deux mots de passe ne sont pas identiques.";
                    }
                } else {
                    $error = "Un compte est déjà existant avec cette adresse mail.";
                }
            } else {
                $error = 'L\'adresse mail est incomplète';
            }
        }
    } else {
        $error = 'Veuillez renseigner ce champ';
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
                $message = "Votre inscription a été validée!";
                $message2 = "Vous pouvez dès à présent vous connecter à votre espace personnel";
                //Affichage page de confirmation d'inscription
                require_once('view/frontEnd/v_message.php');
            }
        } else {
            $error = "Veuillez contacter un administrateur du site";
        }
    } else {
        $error = "Veuillez contacter un administrateur du site";
    }
    require_once('view/frontEnd/v_error.php');
}