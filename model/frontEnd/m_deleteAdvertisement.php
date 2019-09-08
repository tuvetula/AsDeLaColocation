<?php
require_once('model/bdd/bddConfig.php');
require_once('model/frontEnd/m_getPicture.php');
require_once('model/frontEnd/m_deletePicture.php');

function deleteAdvertisementBdd($advertisementId){
    $advertisementIdToDeleteBdd = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    
    //Supprime l'image du dossier ou elle est stockée
    $picturesRequest = getAdvertisementPictures($advertisementIdToDeleteBdd);
    if(!empty($picturesRequest)){
        deletePictureBdd($advertisementIdToDeleteBdd);
        foreach($picturesRequest as $key => $value){
            unlink('public/pictures/users/'.$picturesRequest[$key]['picture_fileName'].'');
        }
    }
    var_dump($picturesRequest);

    //Supprime de la base de donnée
    $delete = $db->prepare('DELETE FROM advertisements WHERE advertisement_id="'.$advertisementId.'"');
    $delete->execute();
}