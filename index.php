<?php
session_start();
require_once('controller/frontEnd/c_frontEnd.php');

//Si utilisateur connecté
if(isset($_SESSION['login'])){
    if (isset($_GET['disconnect']) && $_GET['disconnect']==1) {
        session_destroy();
        session_start();
        displayLoginPage();
    }else if (isset($_GET['page']) && $_GET['page']=="errorNewAdvertisement"){
        displayErrorNewAdvertisement();
    } else if(isset($_GET['page']) && $_GET['page']=="myAdvertisements"){
        displayMyAdvertisements();
    } elseif (isset($_GET['page']) && $_GET['page']=="displayAddAnAdvertisement") {
        displayAddAnAdvertisementForm();
    } elseif (isset($_GET['page']) && $_GET['page']=="homeUser") {
        displayHomeUser();
    } elseif (isset($_GET['page']) && $_GET['page']=="addAdvertisement") {
        require_once('controller/frontEnd/c_addNewAdvertisement.php');
        addANewAdvertisement();
    }elseif (isset($_GET['page']) && $_GET['page']=="deleteAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_deleteAdvertisement.php');
        deleteAdvertisement($_GET['id']);
    }elseif (isset($_GET['page']) && $_GET['page']=="modifyAdvertisement" && isset($_GET['id'])) {
        require_once('controller/frontEnd/c_modifyAdvertisement.php');
        modifyAdvertisement($_GET['id']);
    } else {
        displayHomeUser();
    }
    //Si l'utilisateur est un admin
    if (isset($_SESSION['isAdmin'])){
        if($_SESSION['isAdmin']){
            require_once('controller/backEnd/c_backEnd.php');
        }
    }

}else{
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
