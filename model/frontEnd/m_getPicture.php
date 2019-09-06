<?php

function getAdvertisementPictureOrder1($advertisementId){
    $db = connectBdd();
    $request = $db->query('SELECT picture_fileName FROM pictures WHERE advertisement_id="'.$advertisementId.'" AND picture_order="1"');
    $lastAddressId = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $lastAddressId['picture_fileName'];
}