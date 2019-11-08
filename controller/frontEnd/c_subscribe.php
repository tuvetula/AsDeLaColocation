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
                        if (isset($_POST['loginSiteWeb'])) {
                            $userloginSiteWeb = $_POST['loginSiteWeb'];
                        }
                        if (isset($_POST['passwordSiteWeb'])) {
                            $userpasswordSiteWeb = $_POST['passwordSiteWeb'];
                        }
                     
                        //On enregistre la nouvelle adresse en base de donnée
                        if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
                            //On récupère l'id de l'adresse que l'on vient de créer et on le stocke dans une variable
                            $addressId = getLastAddressId()['MAX(address_id)'];
                            //On ajoute l'utilisateur à la base de donnée et on redirige vers la page de login
                            if (insertNewUser($userName, $userfirstName, $userphoneNumber, $usermail, $userpassword, $userloginSiteWeb, $userpasswordSiteWeb, $addressId)) {
                                //On définit un message de confirmation et on redirige vers la page de confirmation
                                $message = "Votre inscription est bien enregistrée !";
                                $message2 = "Un membre de notre équipe va valider votre inscription sous 72 heures, vous pourrez ensuite vous connecter à votre compte. Merci et à très bientôt.";
                                //Création message à envoyer par mail
                                global $ownMail;
                                $to = $ownMail;
                                $subject = "Nouvelle inscription";
                                $body = 'Bonjour, '."\r\n".$userName.' '.$userfirstName.' vient de s\'inscrire sur le site moncompte.asdelacoloc.fr';
                                $headers[] = 'MIME-Version: 1.0';
                                $headers[]= 'Content-type: text/html; charset=utf-8';
                                //Envoi du mail
                                mail($to, $subject, $body, implode("\r\n", $headers));
                                //Affichage page de confirmation d'inscription
                                require_once('view/frontEnd/v_message.php');
                            }else{
                                //On efface l'adresse créée
                                deleteAddressBdd($addressId);
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
