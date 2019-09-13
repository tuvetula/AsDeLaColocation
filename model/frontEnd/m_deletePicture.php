<?php
require_once('model/bdd/bddConfig.php');

//Supprime toutes les photos d'une annonce
function deletePictureBdd($advertisementId){
    $db = connectBdd();
    $deletePicture = $db->prepare('DELETE FROM pictures WHERE advertisement_id="'.$advertisementId.'"');
    $deletePicture->execute();
}

//Supprime une photo
function deleteOnePicture($advertisementId,$pictureFileName){
    $db = connectBdd();
    $deletePicture = $db->prepare('DELETE FROM pictures WHERE advertisement_id="'.$advertisementId.'" AND picture_fileName="'.$pictureFileName.'"');
    $deletePicture->execute();
    return true;
}