<?php
require_once('model/bdd/bddConfig.php');

//Supprime une addresse
function deleteAddressBdd($addressId){
    $addressId = htmlspecialchars(strip_tags($addressId));
    $db = connectBdd();
    $delete = $db->prepare('DELETE FROM addresses WHERE address_id="'.$addressId.'"');
    $delete->execute();
    return true;
}