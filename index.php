<?php
session_start();
require_once('controller/frontEnd/c_frontEnd.php');

//Si utilisateur connecté
if (isset($_SESSION['mail'])) {
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
        displayMyAccount();

    //Page Modifier mon compte (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="displayModifyMyAccount") {
        displayModifyMyAccount();

    //Page qui va modifier le compte User en bdd
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyMyAccount") {
        require_once('controller/frontEnd/c_modifyMyAccount.php');
        modifyMyAccount();

    //Page Mes annonces
    } elseif (isset($_GET['page']) && $_GET['page']=="myAdvertisements") {
        displayMyAdvertisements();

    //Page Ajouter une nouvelle annonce (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="displayAddAnAdvertisement") {
        displayAddAnAdvertisementForm();

    //Page qui ajoute une nouvelle annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="addAdvertisement") {
        require_once('controller/frontEnd/c_addNewAdvertisement.php');
        addANewAdvertisement();

    //Page qui supprime une annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="deleteAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_deleteAdvertisement.php');
        deleteAdvertisement($_GET['id']);

    //Page modifier une annonce (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        modifyAdvertisement($_GET['id']);
        
    //Page smodifier une annonce avec confirmation modification (Formulaire)
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyAdvertisement" && isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm']==1) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        modifyAdvertisement($_GET['id'], $_GET['confirm']);
            
    //Page qui enregistre la modification d'une annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="saveModificationAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        saveModifyAdvertisement($_GET['id']);

    //Page d'erreur
    } elseif (isset($_GET['page']) && $_GET['page']=="errorNewAdvertisement") {
        displayErrorNewAdvertisement();
    } else {
        displayHomeUser();
    }
    //------------------------------------------------------------------------------------------------------------
    //Si l'utilisateur est un admin
    if (isset($_SESSION['isAdmin'])) {
        if ($_SESSION['isAdmin']) {
            require_once('controller/backEnd/c_backEnd.php');
        }
    }
    //------------------------------------------------------------------------------------------------------------
} else {
    //Si utilisateur non-connecté
    if (isset($_POST['mail']) && isset($_POST['password'])) {
        login();
        if (isset($_SESSION['mail'])) {
            displayHomeUser();
        }
    }else if (isset($_GET['page']) && $_GET['page']=="displaySubscribeForm"){
        displaySubscribePage();
    }else if (isset($_GET['page']) && $_GET['page']=="saveSubscribe"){
        require_once('controller/frontEnd/c_addNewUser.php');
        saveSubscribeForm();
    }else if (isset($_GET['page']) && $_GET['page']=="subscribeConfirmation"){
        displayLoginPage();
    }else if (isset($_GET['error'])){
        displayLoginPage();
    }else {
        displayLoginPage();
    }
}
