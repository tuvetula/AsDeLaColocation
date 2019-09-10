<?php
require_once('model/bdd/bddConfig.php');

function modifyAddress($addressId,$addressStreet,$addressZipcode,$addressCity,$addressCountry){
    $addressId = htmlspecialchars(strip_tags($addressId));
    $addressStreet = htmlspecialchars(strip_tags($addressStreet));
    $addressZipcode = htmlspecialchars(strip_tags($addressZipcode));
    $addressCity = htmlspecialchars(strip_tags($addressCity));
    $addressCountry = htmlspecialchars(strip_tags($addressCountry));

    $db = connectBdd();
    $modifyAddress = $db->prepare('UPDATE addresses SET 
    address_street=:street,
    address_zipcode=:zipcode,
    address_city=:city,
    address_country=:country
    WHERE address_id="'.$addressId.'"');
    $modifyAddress->execute(array(
        ':street'=> $addressStreet,
        ':zipcode'=> $addressZipcode,
        ':city'=> $addressCity,
        ':country'=> $addressCountry
    ));
}