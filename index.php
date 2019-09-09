<?php
session_start();
require_once('controller/frontEnd/c_frontEnd.php');

//Si utilisateur connecté
if (isset($_SESSION['login'])) {
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
    //Page Modifier mon compte
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyMyAccount" && isset($_GET['id']) && $_GET['id'] == $_SESSION['id']) {
        modifyMyAccount();
    //Page d'erreur
    } elseif (isset($_GET['page']) && $_GET['page']=="errorNewAdvertisement") {
        displayErrorNewAdvertisement();
    //Page Mes annonces
    } elseif (isset($_GET['page']) && $_GET['page']=="myAdvertisements") {
        displayMyAdvertisements();
    //Page Ajouter une nouvelle annonce
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
    //Page suite à confirmation de modification d'annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyAdvertisement" && isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm']==1) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        modifyAdvertisement($_GET['id'], $_GET['confirm']);
    //Page modifier une annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="modifyAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        modifyAdvertisement($_GET['id']);
    //Page qui enregistre la modification d'une annonce
    } elseif (isset($_GET['page']) && $_GET['page']=="saveModificationAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        saveModifyAdvertisement($_GET['id']);
    } else {
        displayHomeUser();
    }
    //Si l'utilisateur est un admin
    if (isset($_SESSION['isAdmin'])) {
        if ($_SESSION['isAdmin']) {
            require_once('controller/backEnd/c_backEnd.php');
        }
    }
} else {
    //Si utilisateur non-connecté
    if (isset($_POST['login']) && isset($_POST['password'])) {
        login();
        
        if (isset($_SESSION['login'])) {
            displayHomeUser();
        } else {
            echo 'erreur de connexion';
        }
    } else {
        displayLoginPage();
    }
}
