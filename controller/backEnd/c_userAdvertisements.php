<?php
require_once('model/backEnd/m_getUserAdvertisements.php');
require_once('model/backEnd/m_getUsers.php');
function displayUserAdvertisements($userId=null,$error=null, $message=null){
    if(isset($_GET['userId'])){
        $userId = $_GET['userId'];
    }
    $userInformation = getUserInformation($userId);
    $userAdvertisements = getUserAdvertisementsRegister($userId);
    //Mise en tableau des id des annonces de l'utilisateur
    $advertisementIdArray = array();
    foreach ($userAdvertisements as $key => $value) {
        array_push($advertisementIdArray, $userAdvertisements[$key]['advertisement_id']);
    }
    //Récupération de la photo Order 1 de chaque annonce
    $pictureFilename = array();
    foreach ($advertisementIdArray as $key => $value) {
        $pictureFilename[$value] = getAdvertisementPictureOrder1($value);
    }
    //Integration photos dans le tableau $userAdvertisements
    for ($i = 0 ; $i < count($userAdvertisements) ; $i++) {
        foreach ($pictureFilename as $key => $value) {
            if ($userAdvertisements[$i]['advertisement_id'] == $key && $pictureFilename[$key]!=false) {
                $userAdvertisements[$i]['picture_fileName'] = $value;
            }
        }
    }
    //Déclaration variable url bouton supprimer
    $deleteUrl = 'index.php?page=deleteAdvertisement&id=';
    //Importation de la fonction pour obtenir une description courte
    require_once('controller/frontEnd/functions/shortDescription.php');
    require_once('view/backEnd/v_userAdvertisementsDisplay.php');
}