<?php
require_once('model/bdd/bddConfig.php');

//Vérifie si le login existe en base de donnée
function getUser($postLogin)
{
    $postLoginOk = htmlentities(strip_tags($postLogin));
    $db = connectBdd();
    $answer = $db->prepare('SELECT * FROM users WHERE user_mail=:login');
    $answer->execute([
        ':login' => $postLoginOk
    ]);
    return $answer->fetch();
}

//Ajoute une nouvelle annonce en base de données
function insertNewAdvertisement($postArray)
{
    $isActive = false;
    $dateOfLastDiffusion = null;
    $availableDate = htmlentities(strip_tags($availableDate));
    $title = htmlentities(strip_tags($title));
    $description = htmlentities(strip_tags($description));
    $type = htmlentities(strip_tags($type));
    $category = htmlentities(strip_tags($category));
    $energyClassLetter = htmlentities(strip_tags($energyClassLetter));
    $energyClassNumber = htmlentities(strip_tags($energyClassNumber));
    $gesLetter = htmlentities(strip_tags($gesLetter));
    $gesNumber = htmlentities(strip_tags($gesNumber));
    $accomodationLivingAreaSize = htmlentities(strip_tags($accomodationLivingAreaSize));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));

}


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
    $titleOk = htmlentities(strip_tags($title));
    $contentOk = htmlentities(strip_tags($content));

    $db = connectBdd();
    $insert = $db->prepare('INSERT INTO voyagespost (title,content,image) VALUES (:title,:content,:image)');
    $insert->execute(array(
        ':title'=>$titleOk,
        ':content'=>$contentOk,
        ':image'=>$image
    ));
    return true;
}

//Récupérer tous les voyages
function getTravelsName()
{
    $db = connectBdd();
    $insert = $db->query('SELECT * FROM voyagespost');
    return $insert;
}

//Récupérer un voyage ciblé par son id
function getTravel($id)
{
    $db = connectBdd();
    $request = $db->query('SELECT * FROM voyagespost WHERE id="'.$id.'"');
    $requestOk = $request->fetch();
    $request->closeCursor();
    return $requestOk;
}

//Supprimer un voyage dans la base dedonnée
function deleteTravelInBdd($postTravelToDelete)
{
    $postTravelToDelete = htmlentities(strip_tags($postTravelToDelete));
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
    $title = htmlentities(strip_tags($title));
    $content = htmlentities(strip_tags($content));
    $id = htmlentities(strip_tags($id));

    $db = connectBdd();
    $modify = $db->prepare('UPDATE voyagespost SET title=:title,content=:content WHERE id=:id');
    $modify->execute([
        ':title'=>$title,
        ':content'=>$content,
        ':id'=>$id
    ]);
}
