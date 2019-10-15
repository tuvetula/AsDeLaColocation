<?php
require_once('model/backEnd/m_getUsers.php');
function displayUsers($error=null,$message=null){
    $usersArray = getUsersForAdmin();
    //Déclaration variable url bouton supprimer
    $deleteUrl = 'index.php?page=deleteUser&id=';
    require_once('view/backEnd/v_usersDisplay.php'); 
}