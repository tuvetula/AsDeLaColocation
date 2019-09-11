<?php
require_once('model/bdd/bddConfig.php');















//TP VOYAGES
//Enregistrement image dans le dossier public/images
function uploadImage($namePictureTmp, $namePicture, $uploadPictureDir)
{
    //Vérifie si le fichier a bien été chargé
    if (is_uploaded_file($namePictureTmp)) {
        return move_uploaded_file($namePictureTmp, $uploadPictureDir.$namePicture);
    } else {
        return false;
    }
}
//TP VOYAGES
//Supprimer un voyage dans la base dedonnée
function deleteTravelInBdd($postTravelToDelete)
{
    $postTravelToDelete = htmlspecialchars(strip_tags($postTravelToDelete));
    $db = connectBdd();
    
    //Supprime l'image du dossier ou elle est stockée
    $requestOk = getTravel($postTravelToDelete);
    unlink('public/images/'.$requestOk['image'].'');

    //Supprime de la base de donnée
    $delete = $db->prepare('DELETE FROM voyagespost WHERE id="'.$postTravelToDelete.'"');
    $delete->execute();
}

