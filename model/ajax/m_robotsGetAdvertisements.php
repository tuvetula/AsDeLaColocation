<?php
header('Content-Type: application/json');
//A activer sur site en ligne
//header("Access-Control-Allow-Origin: *");
require_once('../bdd/config.php');

if (isset($_GET['id']) && $_GET['id'] == $idJson) {
    //Stocke la date - 7 jours
    $date = date('Y-m-d', strtotime('-7 day'));
    //Stocke la date - 30 jours (pour republication seloger)
    $dateSeloger = date('Y-m-d', strtotime('-31 day'));
    //Stocke la date pour site erasmusu
    $dateErasmusu = date('Y-m-d', strtotime('-6 day'));

    //Connexion Base de donnée
    try {
        $bdd = new PDO($acces.$dbName, $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    
    $json = deletion($bdd);
    $json += publication($bdd);
    $json += publicationPictures($bdd);
    $json += republication($bdd, $date, $dateSeloger, $dateErasmusu);
    $json += republicationPictures($bdd, $date, $dateSeloger,$dateErasmusu);
    //Ecriture fichier json
    echo json_encode($json);
}
//DELETION: Annonce inactive + date non null
function deletion($bdd)
{
    //leboncoin deletion
    $requestdeleteLeboncoin=$bdd->prepare('SELECT 
    advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,users.user_loginSiteWeb,users.user_passwordSiteWeb FROM advertisements 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionLeboncoin IS NOT NULL');
    $requestdeleteLeboncoin->execute([
        ':isActive' => false,
    ]);
    $deletionLeboncoin = $requestdeleteLeboncoin->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeletion['d_Leboncoin'] = $deletionLeboncoin;

    //Lacartedescolocs deletion
    $requestdeleteLacartedesColocs=$bdd->prepare('SELECT 
    advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,users.user_loginSiteWeb,users.user_passwordSiteWeb FROM advertisements 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionLacartedescolocs IS NOT NULL');
    $requestdeleteLacartedesColocs->execute([
        ':isActive' => false,
    ]);
    $deletionLacartedescolocs = $requestdeleteLacartedesColocs->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeletion['d_Lacartedescolocs'] = $deletionLacartedescolocs;

    //Appartager deletion
    $requestdeleteAppartager=$bdd->prepare('SELECT advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,users.user_loginSiteWeb,users.user_passwordSiteWeb FROM advertisements 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionAppartager IS NOT NULL');
    $requestdeleteAppartager->execute([
        ':isActive' => false,
    ]);
    $deletionAppartager = $requestdeleteAppartager->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeletion['d_Appartager'] = $deletionAppartager;

    //Seloger deletion
    //PAS DE SUPPRESSION

    //Studapart deletion
    //PAS DE SUPPRESSION

    //Erasmusu deletion
    $requestdeleteErasmusu=$bdd->prepare('SELECT 
    advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,users.user_loginSiteWeb,users.user_passwordSiteWeb FROM advertisements 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionErasmusu IS NOT NULL');
    $requestdeleteErasmusu->execute([
        ':isActive' => false,
    ]);
    $deletionErasmusu = $requestdeleteErasmusu->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeletion['d_Erasmusu'] = $deletionErasmusu;

    //Roomlala deletion
    $requestdeleteRoomlala=$bdd->prepare('SELECT 
    advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,users.user_loginSiteWeb,users.user_passwordSiteWeb FROM advertisements 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionRoomlala IS NOT NULL');
    $requestdeleteRoomlala->execute([
        ':isActive' => false,
    ]);
    $deletionRoomlala = $requestdeleteRoomlala->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeletion['d_Roomlala'] = $deletionRoomlala;

    //Bubbleflat deletion
    $requestdeleteBubbleflat=$bdd->prepare('SELECT 
    advertisements.advertisement_id,advertisements.advertisement_title,advertisements.advertisement_description,users.user_loginSiteWeb,users.user_passwordSiteWeb FROM advertisements 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionBubbleflat IS NOT NULL');
    $requestdeleteBubbleflat->execute([
        ':isActive' => false,
    ]);
    $deletionBubbleflat = $requestdeleteBubbleflat->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeletion['d_Bubbleflat'] = $deletionBubbleflat;
    
    $json['deletion'] = $jsonDeletion;
    return $json;
}

//PUBLICATION: Annonce active + date vide
function publication($bdd)
{
    //Leboncoin Publication
    $requestPublicationLeboncoin=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionLeboncoin IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationLeboncoin->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationLeboncoin = $requestPublicationLeboncoin->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Leboncoin'] = $jsonPublicationLeboncoin;

    //Lacartedescolocs Publication
    $requestPublicationLacartedescolocs=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionLacartedescolocs IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationLacartedescolocs->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationLacartedescolocs = $requestPublicationLacartedescolocs->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Lacartedescolocs'] = $jsonPublicationLacartedescolocs;

    //Appartager Publication
    $requestPublicationAppartager=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionAppartager IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationAppartager->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationAppartager = $requestPublicationAppartager->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Appartager'] = $jsonPublicationAppartager;

    //Seloger Publication
    $requestPublicationSeloger=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionSeloger IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationSeloger->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationSeloger = $requestPublicationSeloger->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Seloger'] = $jsonPublicationSeloger;

    //Studapart Publication
    $requestPublicationStudapart=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionStudapart IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationStudapart->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationStudapart = $requestPublicationStudapart->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Studapart'] = $jsonPublicationStudapart;

    //Erasmusu Publication
    $requestPublicationErasmusu=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionErasmusu IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationErasmusu->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationErasmusu = $requestPublicationErasmusu->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Erasmusu'] = $jsonPublicationErasmusu;

    //Roomlala Publication
    $requestPublicationRoomlala=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionRoomlala IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationRoomlala->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationRoomlala = $requestPublicationRoomlala->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Roomlala'] = $jsonPublicationRoomlala;

    //Bubbleflat Publication
    $requestPublicationBubbleflat=$bdd->prepare('SELECT 
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisement_isActive=:isActive 
    AND advertisement_dateOfLastDiffusionBubbleflat IS NULL 
    AND users.user_isMember=:isMember');
    $requestPublicationBubbleflat->execute([
        ':isActive' => true,
        ':isMember' => true
    ]);
    $jsonPublicationBubbleflat = $requestPublicationBubbleflat->fetchAll(PDO::FETCH_ASSOC);
    $jsonPublication['p_Bubbleflat'] = $jsonPublicationBubbleflat;

    $json['publication'] = $jsonPublication;
    return $json;
}

//PUBLICATION PICTURES
function publicationPictures($bdd)
{
    //On récupère les photos
    $requestPicturesPublication=$bdd->prepare('SELECT 
    advertisements.advertisement_id,pictures.picture_fileName FROM advertisements 
    JOIN pictures ON advertisements.advertisement_id = pictures.advertisement_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND (advertisements.advertisement_dateOfLastDiffusionLeboncoin IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionLacartedescolocs IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionAppartager IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionSeloger IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionStudapart IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionErasmusu IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionRoomlala IS NULL
    OR advertisements.advertisement_dateOfLastDiffusionBubbleflat IS NULL)');
    
    $requestPicturesPublication->execute([
        ':isActive' => true
    ]);
    $jsonPublicationPictures = $requestPicturesPublication->fetchAll(PDO::FETCH_ASSOC);
    $requestPicturesPublication->closeCursor();
    $json['publication_Allpictures'] = $jsonPublicationPictures;

    return $json;
}
//REPUBLICATION: Annonce active + Date de + de 7 jours (6jours pour Erasmusu, 31 jours pour seloger)
function republication($bdd, $date, $dateSeloger,$dateErasmusu)
{
    //Leboncoin Republication
    $requestRepublicationLeboncoinData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionLeboncoin<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationLeboncoinData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        'isMember' => true
    ]);
    $jsonRepublicationLeboncoinData = $requestRepublicationLeboncoinData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationLeboncoinData->closeCursor();
    $jsonRepublication['r_Leboncoin'] = $jsonRepublicationLeboncoinData;
    
    //Lacartedescolocs Republication
    $requestRepublicationLacartedescolocsData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionLacartedescolocs<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationLacartedescolocsData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        'isMember' => true
    ]);
    $jsonRepublicationLacartedescolocsData = $requestRepublicationLacartedescolocsData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationLacartedescolocsData->closeCursor();
    $jsonRepublication['r_Lacartedescolocs'] = $jsonRepublicationLacartedescolocsData;

    //Appartager Republication
    $requestRepublicationAppartagerData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionAppartager<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationAppartagerData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        'isMember' => true
    ]);
    $jsonRepublicationAppartagerData = $requestRepublicationAppartagerData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationAppartagerData->closeCursor();
    $jsonRepublication['r_Appartager'] = $jsonRepublicationAppartagerData;

    //Seloger Republication
    $requestRepublicationSelogerData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionSeloger<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationSelogerData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $dateSeloger,
        'isMember' => true
    ]);
    $jsonRepublicationSelogerData = $requestRepublicationSelogerData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationSelogerData->closeCursor();
    $jsonRepublication['r_Seloger'] = $jsonRepublicationSelogerData;

    //Studapart Republication
    $requestRepublicationStudapartData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionStudapart<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationStudapartData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        'isMember' => true
    ]);
    $jsonRepublicationStudapartData = $requestRepublicationStudapartData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationStudapartData->closeCursor();
    $jsonRepublication['r_Studapart'] = $jsonRepublicationStudapartData;

    //Erasmusu Republication
    $requestRepublicationErasmusuData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionErasmusu<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationErasmusuData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $dateErasmusu,
        'isMember' => true
    ]);
    $jsonRepublicationErasmusuData = $requestRepublicationErasmusuData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationErasmusuData->closeCursor();
    $jsonRepublication['r_Erasmusu'] = $jsonRepublicationErasmusuData;

    //Roomlala Republication
    $requestRepublicationRoomlalaData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionRoomlala<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationRoomlalaData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        'isMember' => true
    ]);
    $jsonRepublicationRoomlalaData = $requestRepublicationRoomlalaData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationRoomlalaData->closeCursor();
    $jsonRepublication['r_Roomlala'] = $jsonRepublicationRoomlalaData;

    //Bubbleflat Republication
    $requestRepublicationBubbleflatData=$bdd->prepare('SELECT
    advertisements.*,
    addresses.*,
    users.user_phoneNumber,
    users.user_loginSiteWeb,
    users.user_passwordSiteWeb 
    FROM advertisements 
    JOIN addresses ON advertisements.address_id = addresses.address_id 
    JOIN users ON advertisements.user_id = users.user_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND advertisements.advertisement_dateOfLastDiffusionBubbleflat<=:dateOfLastDiffusion
    AND users.user_isMember=:isMember');
    
    $requestRepublicationBubbleflatData->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        'isMember' => true
    ]);
    $jsonRepublicationBubbleflatData = $requestRepublicationBubbleflatData->fetchAll(PDO::FETCH_ASSOC);
    $requestRepublicationBubbleflatData->closeCursor();
    $jsonRepublication['r_Bubbleflat'] = $jsonRepublicationBubbleflatData;

    $json['republication'] = $jsonRepublication;
    return $json;
}

//REPUBLICATION PICTURES
function republicationPictures($bdd, $date, $dateSeloger, $dateErasmusu)
{
    //On récupère les photos
    $requestPicturesRepublication=$bdd->prepare('SELECT 
    advertisements.advertisement_id,pictures.picture_fileName FROM advertisements 
    JOIN pictures ON advertisements.advertisement_id = pictures.advertisement_id
    WHERE advertisements.advertisement_isActive=:isActive 
    AND (advertisements.advertisement_dateOfLastDiffusionLeboncoin<=:dateOfLastDiffusion
    OR advertisements.advertisement_dateOfLastDiffusionLacartedescolocs<=:dateOfLastDiffusion
    OR advertisements.advertisement_dateOfLastDiffusionAppartager<=:dateOfLastDiffusion
    OR advertisements.advertisement_dateOfLastDiffusionSeloger<=:dateOfLastDiffusionSeloger
    OR advertisements.advertisement_dateOfLastDiffusionStudapart<=:dateOfLastDiffusion
    OR advertisements.advertisement_dateOfLastDiffusionErasmusu<=:dateOfLastDiffusionErasmusu
    OR advertisements.advertisement_dateOfLastDiffusionRoomlala<=:dateOfLastDiffusion
    OR advertisements.advertisement_dateOfLastDiffusionBubbleflat<=:dateOfLastDiffusion)');
    
    $requestPicturesRepublication->execute([
        ':isActive' => true,
        ':dateOfLastDiffusion' => $date,
        ':dateOfLastDiffusionSeloger' =>$dateSeloger,
        ':dateOfLastDiffusionErasmusu' =>$dateErasmusu
    ]);
    $jsonRepublicationPictures = $requestPicturesRepublication->fetchAll(PDO::FETCH_ASSOC);
    $requestPicturesRepublication->closeCursor();
    $json['republication_Allpictures'] = $jsonRepublicationPictures;

    return $json;
}