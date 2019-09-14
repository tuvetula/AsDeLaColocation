<?php

function getAdvertisementPictureOrder1($advertisementId){
    $db = connectBdd();
    $request = $db->query('SELECT picture_fileName FROM pictures WHERE advertisement_id="'.$advertisementId.'" AND picture_order="1"');
    $pictureFilename = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $pictureFilename['picture_fileName'];
}

//Récupère les photos liées à une annonce
function getAdvertisementPictures($advertisementId){
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    $request = $db->query('SELECT picture_id,picture_fileName,picture_order FROM pictures WHERE advertisement_id="'.$advertisementId.'" ORDER BY picture_order');
    $picturesRequest = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $picturesRequest;
}