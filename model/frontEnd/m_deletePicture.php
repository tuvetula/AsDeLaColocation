<?php
require_once('model/bdd/bddConfig.php');
function deletePictureBdd($advertisementId){
    $db = connectBdd();
    $deletePicture = $db->prepare('DELETE FROM pictures WHERE advertisement_id="'.$advertisementId.'"');
    $deletePicture->execute();
}