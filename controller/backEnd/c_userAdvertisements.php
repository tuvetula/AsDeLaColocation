<?php
require_once('model/backEnd/m_getUserAdvertisements.php');
require_once('model/backEnd/m_getUsers.php');
require_once('model/frontEnd/m_getAdvertisement.php');
function displayUserAdvertisements($userId=null,$error=null, $message=null){
    if(isset($_GET['userId'])){
        $userId = $_GET['userId'];
    }
    $userInformation = getUserInformation($userId);
    $userAdvertisements = getUserAdvertisementRegisterWithPictureOrder1($userId);
    //Déclaration variable url bouton supprimer
    $deleteUrl = 'index.php?page=deleteAdvertisement&id=';
    //Importation de la fonction pour obtenir une description courte
    require_once('controller/frontEnd/functions/shortDescription.php');
    require_once('view/backEnd/v_userAdvertisementsDisplay.php');
}