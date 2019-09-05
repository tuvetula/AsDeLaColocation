<?php

function displayLoginPage(){
    require('view/frontEnd/displayLoginForm.php');
}
















//VOYAGE TP
function displayTravels(){
    $travels = getTravels();
    $pageEnCours="index";
    require('view/frontEnd/displayTravels.php');
}

function displayLogins(){
    $pageEnCours='loginmdp';
    require('view/frontEnd/displayLoginForm.php');
}

function displayPage(){
    switch($_GET['page']){
        case 'voyages':
            displayTravels();
            break;

        case 'loginForm':
            displayLogins();
            break;

        default:
            displayTravels();
            break;
    }
}
