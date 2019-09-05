<?php
require_once('model/bdd/bddConfig.php');

//récupère MAX(address_id) de la dernière addresse saisie en bdd
function getLastAddressId(){
    $db = connectBdd();
    $request = $db->query('SELECT MAX(address_id) FROM addresses');
    $lastAddressId = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $lastAddressId;
}

//Récupére adresse_id si le nom de la rue, le code postal, la ville et le pays correspondent.
function getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry)
{
    $db = connectBdd();
    $request = $db->query('SELECT address_id FROM addresses 
    WHERE address_street="'.$addressStreet.'" 
    AND address_zipcode="'.$addressZipcode.'" 
    AND address_city="'.$addressCity.'" 
    AND address_country="'.$addressCountry.'"');
    $addressIdRequest = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $addressIdRequest;
}