<?php
require_once('model/bdd/bddConfig.php');
require_once('model/frontEnd/m_getPicture.php');

//Modifie picture_order des photos d'une annonce (suite à suppression photos dans modifier une annonce)
function reorganizePictureOrder($advertisementId){
    $advertisementPictures = getAdvertisementPictures($advertisementId);
    $pictureOrder = 0;
    foreach($advertisementPictures as $key => $value){ 
        $pictureOrder++;
        $pictureFileName = $advertisementPictures[$key]['picture_fileName'];
        $db = connectBdd();
        $insertPicture = $db->prepare('UPDATE pictures 
        SET picture_order=:pictureOrder 
        WHERE picture_fileName="'.$pictureFileName.'"');
        $insertPicture->execute(array(
            ':pictureOrder'=>$pictureOrder
        ));
    }
    return true;
}
