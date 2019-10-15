<?php
require_once('model/bdd/bddConfig.php');
//Supprime une annonce avec son id et les photos liées à l'annonce
function deleteAdvertisementBdd($advertisementId){
    $db = connectBdd();
    $delete = $db->prepare('UPDATE advertisements SET 
    advertisement_isRegister=:isRegister,
    advertisement_isActive=:isActive
    WHERE advertisement_id="'.$advertisementId.'"');
    $delete->execute(array(
        ':isRegister'=> 0,
        ':isActive'=> 0
    ));
    return true;
}