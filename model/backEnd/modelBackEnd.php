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

//Ajouter un voyage
function insertNewTravel($title, $content, $image=null)
{
    $titleOk = htmlspecialchars(strip_tags($title));
    $contentOk = htmlspecialchars(strip_tags($content));

    $db = connectBdd();
    $insert = $db->prepare('INSERT INTO voyagespost (title,content,image) VALUES (:title,:content,:image)');
    $insert->execute(array(
        ':title'=>$titleOk,
        ':content'=>$contentOk,
        ':image'=>$image
    ));
    return true;
}

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

//Modifier un voyage dans le base dedonnée
function modifyTravelInBdd($title, $content, $id)
{
    $title = htmlspecialchars(strip_tags($title));
    $content = htmlspecialchars(strip_tags($content));
    $id = htmlspecialchars(strip_tags($id));

    $db = connectBdd();
    $modify = $db->prepare('UPDATE voyagespost SET title=:title,content=:content WHERE id=:id');
    $modify->execute([
        ':title'=>$title,
        ':content'=>$content,
        ':id'=>$id
    ]);
}
