<?php
require_once('model/bdd/bddConfig.php');

//Enregistrement photo(s) dans la table pictures
function insertPictures($fileUpload,$advertisementId){
    $pictureOrder = 0;
    foreach($fileUpload as $key => $value){ 
        $pictureOrder++;
        $pictureFileName = $fileUpload[$key];
        $db = connectBdd();
        $insertPicture = $db->prepare('INSERT INTO pictures (picture_fileName,picture_order,advertisement_id) VALUES (:pictureFileName,:pictureOrder,:advertisementId)');
        $insertPicture->execute(array(
            ':pictureFileName'=>$pictureFileName,
            ':pictureOrder'=>$pictureOrder,
            ':advertisementId'=>$advertisementId
        ));
    }
    return true;
}