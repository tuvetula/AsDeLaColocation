<?php
session_start();
require_once('controller/frontEnd/c_frontEnd.php');
require_once('controller/frontEnd/c_forgetPassword.php');

//Si utilisateur connecté
if (isset($_SESSION['mail']) && isset($_SESSION['isAdmin'])) {
    require_once('controller/frontEnd/c_myAccount.php');
    require_once('controller/frontEnd/c_advertisements.php');
    
    //Déconnexion utilisateur
    if (isset($_GET['disconnect']) && $_GET['disconnect']==1) {
        session_destroy();
        session_start();
        displayLoginPage();

    //Page d'accueil utilisateur
    } elseif (isset($_GET['page']) && $_GET['page']=="homeUser") {
        displayHomeUser();

    //Page Mon compte
    } elseif (isset($_GET['page']) && $_GET['page']=="displayMyAccount") {
        if(isset($_GET['userId'])){
            displayMyAccount($_GET['userId']);
        }else{
            displayMyAccount();
        }
    //Page Modifier mon compte (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="displayModifyMyAccount") {
        if(isset($_GET['userId'])){
            displayModifyMyAccount($_GET['userId']);
        }else{
            displayModifyMyAccount();
        }
    //Page qui va modifier le compte User en bdd
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyMyAccount") {
        if(isset($_GET['userId'])){
            modifyMyAccount($_GET['userId']);
        }else{
            modifyMyAccount();
        }

    //Page Mes annonces
    } elseif (isset($_GET['page']) && $_GET['page']=="myAdvertisements") {
        displayMyAdvertisements();

    //Page Ajouter une nouvelle annonce (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="displayAddAnAdvertisement") {
        displayAddAnAdvertisementForm();
        
    //Page modifier une annonce (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyAdvertisement" && isset($_GET['advertisementId'])) {
        displayMofifyAdvertisementForm();
       
    //Page qui enregistre une nouvelle annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="addAdvertisement") {
        saveNewOrModifyAdvertisement();

    //Page qui enregistre la modification d'une annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="saveModificationAdvertisement") {
        saveNewOrModifyAdvertisement();

    //Page qui supprime une annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="deleteAdvertisement" && isset($_GET['id'])) {
        deleteAdvertisement($_GET['id']);

    //Page qui enregistre la suppression photos de la page "modifier annonce"
    } elseif (isset($_GET['page']) && $_GET['page']=="saveModificationAdvertisementDeletePicture" && isset($_GET['idAdvertisement'])) {
        saveModificationAdvertisementDeletePicture();
        
    //Affichage page modification mot de passe
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyPassword") {
        displayChangePasswordPage();
    
    //Traitement qui enregistre le nouveau mot de passe
    } elseif (isset($_POST['passwordReinitialization1']) && isset($_POST['passwordReinitialization2']) && isset($_POST['userMail'])) {
        saveNewPasswordAfterReinitialization();

    //Page d'accueil utilisateur
    } else {
        //Si l'utilisateur est un admin
        if ($_SESSION['isAdmin']) {
            require_once('controller/backEnd/c_users.php');
            require_once('controller/backEnd/c_userAdvertisements.php');
            if(isset($_GET['page']) && $_GET['page']=="displayUsers"){
                displayUsers();
            }else if (isset($_GET['page']) && $_GET['page']=="displayUserAdvertisement"  && isset($_GET['userId'])){
                displayUserAdvertisements();
            }else{
                displayHomeUser();
            }
        } else {
            displayHomeUser();
        }
    }
    //------------------------------------------------------------------------------------------------------------
} else {
    //Si utilisateur non-connecté
    //Verification id et mot de passe de connexion
    if (isset($_POST['mailLogin']) && isset($_POST['passwordLogin'])) {
        login();

    //Affichage page mot de passe oublié (mail à saisir)
    } elseif (isset($_GET['page']) && $_GET['page']=="forgetPassword") {
        displayforgetPasswordPage();

    //Traitement mot de passe oublié (après saisie mail pour récupération)
    } elseif (isset($_POST['mailForgetPassword'])) {
        forgetPassword();

    //Affichage page réinitialisation mot de passe (après clique sur lien reçu par mail)
    } elseif (isset($_GET['token']) && isset($_GET['mailLink'])) {
        displayTypeNewPassword();

    //Traitement enregistrement nouveau mot de passe (après saisie de 2 nouveaux mots de passe)
    } elseif (isset($_POST['passwordReinitialization1']) && isset($_POST['passwordReinitialization2']) && isset($_POST['userMail'])) {
        saveNewPasswordAfterReinitialization();

    //Affichage page d'inscription
    } elseif (isset($_GET['page']) && $_GET['page']=="displaySubscribeForm") {
        require_once('controller/frontEnd/c_subscribe.php');
        displaySubscribePage();

    //Traitement inscription (après saisie formulaire d'inscription)
    } elseif (isset($_GET['page']) && $_GET['page']=="saveSubscribe") {
        require_once('controller/frontEnd/c_subscribe.php');
        saveSubscribeForm();
    
    //Affichage page de connexion
    } else {
        displayLoginPage();
    }
}