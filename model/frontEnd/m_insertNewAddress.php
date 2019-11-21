<?php
require_once('model/bdd/bddConfig.php');

//Ajoute une nouvelle adresse
function insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)
{
    $addressStreet = htmlspecialchars(strip_tags($addressStreet));
    $addressZipcode = htmlspecialchars(strip_tags($addressZipcode));
    $addressCity = htmlspecialchars(strip_tags($addressCity));
    $addressCountry = htmlspecialchars(strip_tags($addressCountry));
    $db = connectBdd();
    $insertAddress = $db->prepare('INSERT INTO addresses (address_street,address_zipcode,address_city,address_country) 
    VALUES (:addressStreet,:addressZipcode,:addressCity,:addressCountry)');
    $insertAddressExecute = $insertAddress->execute(array(
    ':addressStreet'=>$addressStreet,
    ':addressZipcode'=>$addressZipcode,
    ':addressCity'=>ucfirst($addressCity),
    ':addressCountry'=>ucfirst($addressCountry)
));
    if ($insertAddressExecute) {
        return $db->lastInsertId();
    } else {
        return false;
    }
}
