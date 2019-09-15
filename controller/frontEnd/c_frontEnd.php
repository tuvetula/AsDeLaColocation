<?php
require_once('model/frontEnd/m_getUser.php');

//Affichage page de connexion
function displayLoginPage()
{
    require_once('view/frontEnd/v_loginForm.php');
}

//Vérification login et mot de passe
function login()
{
    //On verifie si le mail existe en base de donnée
    $mailVerification = getUser($_POST['mailLogin']);
    if ($mailVerification) {
        //On vérifie si l'utilisateur a renseigné le bon mot de passe
        if (password_verify($_POST['passwordLogin'], $mailVerification['user_password'])) {
            //On vérifie si l'utilisateur est membre
            if ($mailVerification['user_isMember']==1) {
                $_SESSION['mail'] = $mailVerification['user_mail'];
                $_SESSION['id'] = $mailVerification['user_id'];
                $_SESSION['isAdmin'] = $mailVerification['user_isAdmin'];
                require_once('view/frontEndUserConnected/v_homeUser.php');
            } else {
                $error = "Accès refusé. Vous n'êtes pas membre.";
            }
        } else {
            $error = "Mauvais identifiant et/ou mot de passe.";
        }
    } else {
        $error = "Mauvais identifiant et/ou mot de passe.";
    }
    require_once('view/frontEnd/v_loginForm.php');
}

//Affichage page d'accueil utilisateur connecté
function displayHomeUser()
{
    require_once('view/frontEndUserConnected/v_homeUser.php');
}
