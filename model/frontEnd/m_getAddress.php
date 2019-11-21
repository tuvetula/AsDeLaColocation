<?php
require_once('model/bdd/bddConfig.php');

//Verification si adresse existe
//Récupére adresse_id si le nom de la rue, le code postal, la ville et le pays correspondent.
function getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry)
{
    $db = connectBdd();
    $request = $db->prepare('SELECT address_id FROM addresses 
    WHERE address_street="'.$addressStreet.'" 
    && address_zipcode="'.$addressZipcode.'" 
    && address_city="'.$addressCity.'" 
    && address_country="'.$addressCountry.'"');
    $request->execute();
    $addressIdRequest = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $addressIdRequest;
}