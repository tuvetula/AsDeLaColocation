<?php
header('Content-Type: application/json');
require_once('../../bdd/config.php');
//Stocke la date - 7 jours
$date = date('Y-m-d', strtotime('-7 day'));
// echo $date;

//Connexion Base de donnée
try {
    $bdd = new PDO($acces.$dbName,$login,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//Requete Suppression: Annonce inactive + date non null
$request=$bdd->prepare('SELECT * FROM advertisements 
                        join users on advertisements.user_id = users.user_id
                        where advertisement_isActive=:isActive 
                        AND advertisement_dateOfLastDiffusionSeloger IS NOT NULL');

$request->execute([
    ':isActive' => false,
]);

$deletion = $request->fetchAll(PDO::FETCH_ASSOC);
$json['Deletion'] = $deletion;

//Requete Publication: Annonce active + date vide
$request1=$bdd->prepare('SELECT * FROM advertisements 
                        join addresses on advertisements.address_id = addresses.address_id 
                        join users on advertisements.user_id = users.user_id
                        join pictures on advertisements.advertisement_id = pictures.advertisement_id
                        where advertisement_isActive=:isActive 
                        AND advertisement_dateOfLastDiffusionSeloger IS NULL');

$request1->execute([
    ':isActive' => true,
]);
$jsonPublication = $request1->fetchAll(PDO::FETCH_ASSOC);
$json['Publication'] = $jsonPublication;


//Requete RePublication: Annonce active + Date de + de 7 jours
//On récupère les datas
$requestData=$bdd->prepare('SELECT advertisements.advertisement_id,
advertisements.advertisement_availableDate,
advertisements.advertisement_title,
advertisements.advertisement_description,
advertisements.advertisement_type,
advertisements.advertisement_category,
advertisements.advertisement_energyClassLetter,
advertisements.advertisement_energyClassNumber,
advertisements.advertisement_gesLetter,
advertisements.advertisement_gesNumber,
advertisements.advertisement_accomodationLivingAreaSize,
advertisements.advertisement_accomodationFloor,
advertisements.advertisement_buildingNbOfFloors,
advertisements.advertisement_accomodationNbOfRooms,
advertisements.advertisement_accomodationNbOfBedrooms,
advertisements.advertisement_accomodationNbOfBathrooms,
advertisements.advertisement_nbOfBedroomsToRent,
advertisements.advertisement_monthlyRentExcludingCharges,
advertisements.advertisement_charges,
advertisements.advertisement_suretyBond,
advertisements.advertisement_financialRequirements,
advertisements.advertisement_guarantorLiving,
advertisements.advertisement_solvencyRatio,
advertisements.advertisement_eligibleForAids,
advertisements.advertisement_chargesIncludeCoOwnershipCharges,
advertisements.advertisement_chargesIncludeElectricity,
advertisements.advertisement_chargesIncludeHotWater,
advertisements.advertisement_chargesIncludeHeating,
advertisements.advertisement_chargesIncludeInternet,
advertisements.advertisement_chargesIncludeHomeInsurance,
advertisements.advertisement_chargesIncludeBoilerInspection,
advertisements.advertisement_chargesIncludeHouseholdGarbageTaxes,
advertisements.advertisement_chargesIncludeCleaningService,
advertisements.advertisement_isFurnished,
advertisements.advertisement_kitchenUse,
advertisements.advertisement_livingRoomUse,
advertisements.advertisement_bedroomSize,
advertisements.advertisement_bedroomType,
advertisements.advertisement_bedType,
advertisements.advertisement_bedroomHasDesk,
advertisements.advertisement_bedroomHasWardrobe,
advertisements.advertisement_bedroomHasChair,
advertisements.advertisement_bedroomHasTv,
advertisements.advertisement_bedroomHasArmchair,
advertisements.advertisement_bedroomHasCoffeeTable,
advertisements.advertisement_bedroomHasBedside,
advertisements.advertisement_bedroomHasLamp,
advertisements.advertisement_bedroomHasCloset,
advertisements.advertisement_bedroomHasShelf,
advertisements.advertisement_handicapedAccessibility,
advertisements.advertisement_accomodationHasElevator,
advertisements.advertisement_accomodationHasCommonParkingLot,
advertisements.advertisement_accomodationHasPrivateParkingPlace,
advertisements.advertisement_accomodationHasGarden,
advertisements.advertisement_accomodationHasBalcony,
advertisements.advertisement_accomodationHasTerrace,
advertisements.advertisement_accomodationHasSwimmingPool,
advertisements.advertisement_accomodationHasTv,
advertisements.advertisement_accomodationHasInternet,
advertisements.advertisement_accomodationHasWifi,
advertisements.advertisement_accomodationHasFiberOpticInternet,
advertisements.advertisement_accomodationHasNetflix,
advertisements.advertisement_accomodationHasDoubleGlazing,
advertisements.advertisement_accomodationHasAirConditioning,
advertisements.advertisement_accomodationHasElectricHeating,
advertisements.advertisement_accomodationHasIndividualGasHeating,
advertisements.advertisement_accomodationHasCollectiveGasHeating,
advertisements.advertisement_accomodationHasHotWaterTank,
advertisements.advertisement_accomodationHasGasWaterHeater,
advertisements.advertisement_accomodationHasFridge,
advertisements.advertisement_accomodationHasFreezer,
advertisements.advertisement_accomodationHasOven,
advertisements.advertisement_accomodationHasBakingTray,
advertisements.advertisement_accomodationHasWashingMachine,
advertisements.advertisement_accomodationHasDishwasher,
advertisements.advertisement_accomodationHasMicrowaveOven,
advertisements.advertisement_accomodationHasCoffeeMachine,
advertisements.advertisement_accomodationHasPodCoffeeMachine,
advertisements.advertisement_accomodationHasKettle,
advertisements.advertisement_accomodationHasToaster,
advertisements.advertisement_accomodationHasExtractorHood,
advertisements.advertisement_animalsAllowed,
advertisements.advertisement_smokingIsAllowed,
advertisements.advertisement_authorizedParty,
advertisements.advertisement_authorizedVisit,
advertisements.advertisement_nbOfOtherRoommatePresent,
advertisements.advertisement_renterSituation,
advertisements.advertisement_idealRoommateSex,
advertisements.advertisement_idealRoommateSituation,
advertisements.advertisement_idealRoommateMinAge,
advertisements.advertisement_idealRoommateMaxAge,
advertisements.advertisement_locationMinDuration,
advertisements.advertisement_rentWithoutVisit,
advertisements.advertisement_contactNameForVisit,
advertisements.advertisement_contactPhoneNumberForVisit,
advertisements.advertisement_contactMailForVisit,
addresses.address_street,
addresses.address_zipcode,
addresses.address_city,
addresses.address_country,
users.user_loginSiteWeb,
users.user_passwordSiteWeb FROM advertisements 
                        JOIN addresses ON advertisements.address_id = addresses.address_id 
                        JOIN users ON advertisements.user_id = users.user_id
                        WHERE advertisements.advertisement_isActive=:isActive 
                        AND advertisements.advertisement_dateOfLastDiffusionSeloger<=:dateOfLastDiffusion');

$requestData->execute([
    ':isActive' => true,
    ':dateOfLastDiffusion' => $date
]);
$jsonRepublicationData = $requestData->fetchAll(PDO::FETCH_ASSOC);
$requestData->closeCursor();
//On récupère les photos
$requestPictures=$bdd->prepare('SELECT advertisements.advertisement_id,pictures.picture_fileName FROM advertisements 
                        JOIN pictures ON advertisements.advertisement_id = pictures.advertisement_id
                        WHERE advertisements.advertisement_isActive=:isActive 
                        AND advertisements.advertisement_dateOfLastDiffusionSeloger<=:dateOfLastDiffusion');

$requestPictures->execute([
    ':isActive' => true,
    ':dateOfLastDiffusion' => $date
]);
$jsonRepublicationPictures = $requestPictures->fetchAll(PDO::FETCH_ASSOC);
$requestPictures->closeCursor();

$json['Republication'] = $jsonRepublicationData;
$json['RepublicationPictures'] = $jsonRepublicationPictures;

//Ecriture fichier json
echo json_encode($json);