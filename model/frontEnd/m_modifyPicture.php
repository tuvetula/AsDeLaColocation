<?php
require_once('model/bdd/bddConfig.php');
require_once('model/frontEnd/m_getPicture.php');

//Modifie picture_order des photos d'une annonce (suite à suppression photos dans modifier une annonce)
function reorganizePictureOrder($advertisementId){
    $advertisementPictures = getAdvertisementPictures($advertisementId);
}
