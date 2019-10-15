<?php
require_once('model/bdd/bddConfig.php');

//Récupère titre, description, isActive de toutes les annonces d'un utilisateur
function getUserAdvertisementsRegister($userId)
{
    $db = connectBdd();
    $request = $db->query('SELECT advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,advertisements.advertisement_isActive
    FROM advertisements 
    WHERE advertisements.user_id="'.$userId.'" 
    && advertisements.advertisement_isRegister=1');
    $userAdvertisements = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $userAdvertisements;
}
