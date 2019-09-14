<?php
require_once('model/bdd/bddConfig.php');
require_once('model/frontEnd/m_getPicture.php');
require_once('model/frontEnd/m_getAdvertisement.php');
require_once('model/frontEnd/m_getUser.php');


//Supprime une annonce avec son id et les photos liées à l'annonce
function deleteAdvertisementBdd($advertisementId){
    $advertisementIdToDeleteBdd = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    $delete = $db->prepare('DELETE FROM advertisements WHERE advertisement_id="'.$advertisementId.'"');
    $delete->execute();
    return true;
}