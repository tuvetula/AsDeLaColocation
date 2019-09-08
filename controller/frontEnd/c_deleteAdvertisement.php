<?php
require_once('model/frontEnd/m_deleteAdvertisement.php');
function deleteAdvertisement($advertisementIdToDelete){
    //Verification si le $_GET['id'](id de l'annonce) appartient bien à $_SESSION['id](utilisateur connecté)
    if(verifyAdvertisement($_SESSION['id'],$advertisementIdToDelete)){
        deleteAdvertisementBdd($advertisementIdToDelete);
        header('Location:index.php?page=myAdvertisements');
    }else{
        echo 'coucou KO';
    }
}