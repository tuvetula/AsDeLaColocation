<?php
require_once('model/bdd/bddConfig.php');

//Récupère l'adress_id d'une annonce (utilisation: Pour modification annonce)
function getAddressIdFromAdvertisement($advertisementId){
    $db = connectBdd();
    $request = $db->query('SELECT address_id FROM advertisements WHERE advertisement_id='.$advertisementId.'');
    $addressIdFromAdvertisement = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $addressIdFromAdvertisement['address_id'];
}

//Récupère MAX(advertisement_id) de la dernière annonce saisie en bdd
function getLastAdvertisementId($userId){
    $db = connectBdd();
    $request = $db->query('SELECT MAX(advertisement_id) 
    FROM advertisements
    WHERE user_id='.$userId.'');
    $lastAdvertisementId = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $lastAdvertisementId;
}
//Récupère le titre d'une annonce (affichage page modifier annonce utilisateur non admin)
function getTitleFromAdvertisement($advertisementId){
    $db = connectBdd();
    $request = $db->prepare('SELECT advertisement_title
    FROM advertisements
    WHERE advertisement_id=:advertisementId');
    $request->execute([
        ':advertisementId'=>$advertisementId
    ]);
    $advertisementTitle = $request->fetch(PDO::FETCH_ASSOC);
    return $advertisementTitle;
}
//Récupere tous les titres des annonces isRegister=1 d'un utilisateur
function getUserAdvertisementTitleRegister($userId){
    $db = connectBdd();
    $request = $db->query('SELECT a.advertisement_id,a.advertisement_title 
    FROM advertisements AS a
    WHERE a.user_id="'.$userId.'" && a.advertisement_isRegister="1"');
    $userAdvertisements = $request->fetchAll(PDO::FETCH_ASSOC);
    return $userAdvertisements;
}
//Récupere toutes les annonces isRegister=1 d'un utilisateur avec photo order1 descendant (affichage page "mes annonces")
function getUserAdvertisementRegisterWithPictureOrder1($userId){
    $db = connectBdd();
    $request = $db->query('SELECT a.advertisement_id,a.advertisement_title,a.advertisement_description,a.advertisement_isActive,
    p.picture_fileName,p.picture_order 
    FROM advertisements AS a
    LEFT JOIN pictures AS p ON a.advertisement_id = p.advertisement_id && p.picture_order="1"
    WHERE a.user_id="'.$userId.'" && a.advertisement_isRegister="1"
    ORDER BY a.advertisement_id DESC');
    $userAdvertisements = $request->fetchAll(PDO::FETCH_ASSOC);
    return $userAdvertisements;
}

//Verifie si un id_advertisement et un id_user renvoi bien une annonce
function verifyAdvertisementBelongsToUser($userId, $advertisementId)
{
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    $request = $db->query('SELECT advertisement_id FROM advertisements WHERE user_id='.$userId.' AND advertisement_id='.$advertisementId.'');
    $userAdvertisements = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $userAdvertisements;
}

//Récupère une annonce et son adresse (avec user_id et advertisement_id)
function getAdvertisementWithAddress($advertisementId)
{
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));
    $db = connectBdd();
    $request = $db->query('SELECT * FROM advertisements 
    join addresses on advertisements.address_id = addresses.address_id
    join users on advertisements.user_id = users.user_id 
    WHERE advertisements.advertisement_id='.$advertisementId.' 
    ORDER BY advertisements.advertisement_id DESC');
    $userAdvertisementWithAddress = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $userAdvertisementWithAddress;
}