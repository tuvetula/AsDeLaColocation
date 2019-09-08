<?php
require_once('model/frontEnd/m_modifyAdvertisement.php');
require_once('model/frontEnd/m_getAdvertisement.php');

function modifyAdvertisement($advertisementId){
    $advertisementData = verifyAdvertisement($_SESSION['id'],$advertisementId);
    

    require_once('view/frontEnd/displayModifyAdvertisement.php');
}