<?php
session_start();
require_once('controller/frontEnd.php');

//Si utilisateur connecté
if(isset($_SESSION['login'])){
    require_once('controller/backEnd.php');

    if (isset($_GET['disconnect']) && $_GET['disconnect']==1){
    session_destroy();
    session_start();
    displayLoginPage();

    }else if(isset($_GET['page']) && $_GET['page']=="addAnAdvertisement"){
        displayAddAnAdvertisementForm();
    }else if(isset($_GET['page']) && $_GET['page']=="homeUser"){
        displayHomeUser();
    }else if (isset($_GET['page']) && $_GET['page']=="newAdvertisement"){
        addANewAdvertisement();
    }else{
        displayHomeUser();
    }

    //Si utilisateur non-connecté
}else if(isset($_POST['login']) && isset($_POST['password'])){
        //backendControl
        require_once('controller/backEnd.php');
        login();
    
        if(isset($_SESSION['login'])){
            displayHomeUser();
        }else{
            echo 'erreur de connexion';
        }

}else{
    displayLoginPage();
}