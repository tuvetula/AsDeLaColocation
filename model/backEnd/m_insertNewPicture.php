<?php
require_once('model/bdd/bddConfig.php');

//Enregistrement photo(s) dans la table pictures
function insertPictures($fileUpload,$advertisementId){
    foreach($fileUpload as $key => $value){ 
        $pictureFileName = $fileUpload[$key];
        $db = connectBdd();
        $insertPicture = $db->prepare('INSERT INTO pictures (picture_fileName,advertisement_id) VALUES (:pictureFileName,:advertisementId)');
        $insertPicture->execute(array(
            ':pictureFileName'=>$pictureFileName,
            ':advertisementId'=>$advertisementId
        ));
    }
    return true;
}