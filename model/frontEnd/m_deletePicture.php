<?php
require_once('model/bdd/bddConfig.php');

//Supprime toutes les photos d'une annonce
function deletePictureBdd($advertisementId){
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    $deletePicture = $db->prepare('DELETE FROM pictures WHERE advertisement_id="'.$advertisementId.'"');
    $deletePicture->execute();
}

//Supprime une photo d'une annonce
function deleteOnePicture($advertisementId,$pictureFileName){
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));
    $pictureFileName = htmlspecialchars(strip_tags($pictureFileName));
    $db = connectBdd();
    $deletePicture = $db->prepare('DELETE FROM pictures WHERE advertisement_id="'.$advertisementId.'" AND picture_fileName="'.$pictureFileName.'"');
    $deletePicture->execute();
    return true;
}