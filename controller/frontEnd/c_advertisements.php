<?php
require_once('model/frontEnd/m_insertNewAdvertisement.php');
require_once('model/frontEnd/m_insertNewPicture.php');
require_once('model/frontEnd/m_insertNewAddress.php');
require_once('model/frontEnd/m_getAddress.php');
require_once('model/frontEnd/m_getAdvertisement.php');
require_once('model/frontEnd/m_getPicture.php');
require_once('model/frontEnd/m_getUser.php');
require_once('model/frontEnd/m_modifyAdvertisement.php');
require_once('model/frontEnd/m_modifyPicture.php');
require_once('model/frontEnd/m_deleteAdvertisement.php');
require_once('model/frontEnd/m_deletePicture.php');
require_once('model/frontEnd/m_deleteAddress.php');
require_once('controller/frontEnd/functions/rearrangeDataFilesArray.php');
require_once('controller/frontEnd/functions/calculEnergyGesLetter.php');
require_once('controller/frontEnd/functions/calculDayMonthAccountCreationDate.php');

//Affichage de la page "Mes annonces"
function displayMyAdvertisements($error=null, $message=null)
{
    //Récupération annonces utilisateurs
    $userAdvertisements = getUserAdvertisementRegisterWithPictureOrder1($_SESSION['id']);
    //Déclaration variable url bouton supprimer
    $deleteUrl = 'index.php?page=deleteAdvertisement&id=';
    //Importation de la fonction pour obtenir une description courte
    require_once('controller/frontEnd/functions/shortDescription.php');
    //Appel de la vue
    require_once('view/frontEndUserConnected/v_advertisementsDisplay.php');
}
//Affichage page "Ajouter une annonce" (formulaire)
function displayAddAnAdvertisementForm()
{
    require_once('view/frontEndUserConnected/v_advertisementAddForm.php');
}
//Affichage page "modifier une annonce" (formulaire)
function displayModifyAdvertisementForm()
{
    //On récupère l'id de l'annonce à modifier
    $advertisementId = $_GET['advertisementId'];
    //Si la demande vient d'un admin, on recupere l'id du propriétaire de l'annonce à modifier
    if ($_SESSION['isAdmin']) {
        require_once('model/backEnd/m_getUsers.php');
        $userId = getUserIdFromAdvertisementId($advertisementId)['user_id'];
    } else {
        $userId = $_SESSION['id'];
    }
    //On verifie si l'id de l'annonce($_GET['advertisementId]) appartient bien à l'utilisateur connecté ou si la demande vient d'un admin
    if (verifyAdvertisementBelongsToUser($_SESSION['id'], $advertisementId) || $_SESSION['isAdmin']==true) {
        //On récupère les données de l'annonce et de l'adresse liée à l'annonce
        $advertisementData = getAdvertisementWithAddress($advertisementId);
        //On récupère les photos liées à l'annonce
        $advertisementPicture = getAdvertisementPictures($advertisementId);
        //On prépare une variable avec un lien pour bouton supprimer photos
        $deletePictureUrl = 'index.php?page=saveModificationAdvertisementDeletePicture&idAdvertisement='.$advertisementId.'';
        //On définit le chemin ou sont enregistrer les photos
        $picturePath = "public/pictures/users/";
        if($_SESSION['isAdmin']){
            require_once('view/backEnd/v_advertisementModifyFormAdmin.php');
        }else{
            require_once('view/frontEndUserConnected/v_advertisementModifyForm.php');
        }
    } else {
        $error = "Erreur";
        require_once('view/frontEnd/v_error.php');
    }
}
//Traitement enregistrement nouvelle annonce ou modification annonce en base de donnée
function saveNewOrModifyAdvertisement()
{
    $errorEmptyField = 'Veuillez renseigner ce champ';
    //Nous permet de savoir si il faut modifier une annonce ou en créer une nouvelle
    if (isset($_POST['id'])) {
        if(filter_var($_POST['id'],FILTER_VALIDATE_INT)){
            $advertisementIdToModify = $_POST['id'];
        }
        //Si modif vient d'un admin, on recupère l'id du propriétaire de l'annonce qui est modifiée
        if ($_SESSION['isAdmin']) {
            require_once('model/backEnd/m_getUsers.php');
            $userId = getUserIdFromAdvertisementId($advertisementIdToModify)['user_id'];
        } else {
            $userId = $_SESSION['id'];
        }
    } else {
        $advertisementIdToModify = null;
        $userId = $_SESSION['id'];
    }
    
    //Boucle pour transformer les valeurs "on" en 1 (valeur vrai) des checkbox cochées
    foreach ($_POST as $key => $value) {
        if ($value === "on") {
            $_POST[$key] = 1;
        }
    }
    //On créé un tableau pour stocker les erreurs
    $fillingError = array();
    
    //Address $_POST
    if (isset($_POST['street']) && !empty($_POST['street'])) {
        if(strlen($_POST['street'])>255){
            $fillingError['street'] = '255 caractères maximum.';
        }else{
            $addressStreet = $_POST['street'];
        }
    } else {
        $fillingError['street'] = $errorEmptyField;
    }
    if (isset($_POST['zipcode']) && !empty($_POST['zipcode'])) {
        if(strlen($_POST['zipcode'])>20){
            $fillingError['zipcode'] = '20 caractères maximum.';
        }else{
            $addressZipcode = $_POST['zipcode'];
        }
    } else {
        $fillingError['zipcode'] = $errorEmptyField;
    }
    if (isset($_POST['city']) && !empty($_POST['city'])) {
        if(strlen($_POST['city'])>60){
            $fillingError['city'] = '60 caractères maximum.';
        }else{
            $addressCity = $_POST['city'];
        }
    } else {
        $fillingError['city'] = $errorEmptyField;
    }
    if (isset($_POST['country']) && !empty($_POST['country'])) {
        if(strlen($_POST['country'])>60){
            $fillingError['country'] = '60 caractères maximum.';
        }else{
            $addressCountry = $_POST['country'];
        }
    } else {
        $fillingError['country'] = $errorEmptyField;
    }
    //Advertisement $_POST
    if (isset($_POST['isActive']) && $_POST['isActive'] == 1) {
        $isActive = $_POST['isActive'];
    } else {
        $isActive = 0;
    }
    if (isset($_POST['availableDate']) && !empty($_POST['availableDate'])) {
        $availableDate = $_POST['availableDate'];
    } else {
        $fillingError['availableDate'] = 'La date n\'est pas valable.';
    }
    //title
    if (isset($_POST['title'])){
        if(!empty($_POST['title'])) {
            if (strlen($_POST['title'])>80) {
                $fillingError['title'] = '80 caractères maximum';
            } else {
                //Verification Titre identiques si nouvelle annonce ou modification par un admin
                //On récupère tous les titres et id des annonces isRegister=1 de l'utilisateur
                if(($advertisementIdToModify && $_SESSION['isAdmin']) || !$advertisementIdToModify){
                    if($advertisementIdToModify){
                        $titleVerification = getUserAdvertisementTitleRegister($userId,$advertisementIdToModify);
                    }else{
                        $titleVerification = getUserAdvertisementTitleRegister($userId);
                    }
                    foreach ($titleVerification as $key => $value) {
                        if (strtolower($titleVerification[$key]['advertisement_title']) == strtolower($_POST['title'])) {
                            $fillingError['title'] = "Vous avez déja utilisé ce titre dans une autre annonce.";
                        }
                    }
                    if(!isset($fillingError['title'])){
                        $title = $_POST['title'];
                    }
                }
            }
        } else {
            $fillingError['title'] = $errorEmptyField;
        }
    } 
    //description
    if (isset($_POST['description']) && !empty($_POST['description'])) {
        if (strlen($_POST['description'])>3000) {
            $fillingError['description'] = '3000 caractères maximum';
        } else {
            $description = $_POST['description'];
        }
    } else {
        $fillingError['description'] = $errorEmptyField;
    }
    //type
    if (isset($_POST['type']) && ($_POST['type'] == "Maison" || $_POST['type'] == "Appartement")) {
        $type = $_POST['type'];
    } else {
        $fillingError['type'] = $errorEmptyField;
    }
    //Category
    if (isset($_POST['category']) && ($_POST['category'] == 'Location' || $_POST['category'] == 'Colocation' || $_POST['category'] == 'Sous-location' || $_POST['category'] == 'Courte-durée')) {
        $category = $_POST['category'];
    } else {
        $fillingError['category'] = $errorEmptyField;
    }
    //energyClassNumber
    if (isset($_POST['energyClassNumber']) && !empty($_POST['energyClassNumber'])) {
        if (filter_var($_POST['energyClassNumber'], FILTER_VALIDATE_INT) || filter_var($_POST['energyClassNumber'], FILTER_VALIDATE_FLOAT)) {
            $energyClassNumber = $_POST['energyClassNumber'];
            $energyClassLetter = calculEnergyLetter($energyClassNumber);
        } else {
            $fillingError['energyClassNumber'] = "La valeur de ce champ doit être un nombre";
        }
    } else {
        $fillingError['energyClassNumber'] = $errorEmptyField;
    }
    //gesNumber
    if (isset($_POST['gesNumber']) && !empty($_POST['gesNumber'])) {
        if (filter_var($_POST['gesNumber'], FILTER_VALIDATE_INT) || filter_var($_POST['gesNumber'], FILTER_VALIDATE_FLOAT)) {
            $gesNumber = $_POST['gesNumber'];
            $gesLetter = calculGesLetter($gesNumber);
        } else {
            $fillingError['gesNumber'] = "La valeur de ce champ doit être un nombre";
        }
    } else {
        $fillingError['gesNumber'] = $errorEmptyField;
    }
    //accomodationLivingAreaSize
    if (isset($_POST['accomodationLivingAreaSize']) && !empty($_POST['accomodationLivingAreaSize'])) {
        if (filter_var($_POST['accomodationLivingAreaSize'], FILTER_VALIDATE_INT) || filter_var($_POST['accomodationLivingAreaSize'], FILTER_VALIDATE_FLOAT)) {
            $accomodationLivingAreaSize = $_POST['accomodationLivingAreaSize'];
        } else {
            $fillingError['accomodationLivingAreaSize'] = 'La valeur de ce champ doit être un nombre';
        }
    } else {
        $fillingError['accomodationLivingAreaSize'] = $errorEmptyField;
    }
    //accomodationFloor
    if (isset($_POST['accomodationFloor'])) {
        $accomodationFloor = $_POST['accomodationFloor'];
    }
    if (isset($_POST['buildingNbOfFloors'])) {
        $buildingNbOfFloors = $_POST['buildingNbOfFloors'];
    }
    if (isset($_POST['accomodationNbOfRooms'])) {
        $accomodationNbOfRooms = $_POST['accomodationNbOfRooms'];
    }
    if (isset($_POST['accomodationNbOfBedrooms'])) {
        $accomodationNbOfBedrooms = $_POST['accomodationNbOfBedrooms'];
    }
    if (isset($_POST['accomodationNbOfBathrooms'])) {
        $accomodationNbOfBathrooms = $_POST['accomodationNbOfBathrooms'];
    }
    if (isset($_POST['nbOfBedroomsToRent'])) {
        $nbOfBedroomsToRent = $_POST['nbOfBedroomsToRent'];
    }
    //monthlyRentExcludingCharges
    if (isset($_POST['monthlyRentExcludingCharges']) && !empty($_POST['monthlyRentExcludingCharges'])) {
        if (filter_var($_POST['monthlyRentExcludingCharges'], FILTER_VALIDATE_INT) || filter_var($_POST['monthlyRentExcludingCharges'], FILTER_VALIDATE_FLOAT)) {
            $monthlyRentExcludingCharges = $_POST['monthlyRentExcludingCharges'];
        } else {
            $fillingError['monthlyRentExcludingCharges'] = "La valeur de ce champ doit être un nombre";
        }
    } else {
        $fillingError['monthlyRentExcludingCharges'] = $errorEmptyField;
    }
    //charges
    if (isset($_POST['charges']) && !empty($_POST['charges'])) {
        if (filter_var($_POST['charges'], FILTER_VALIDATE_INT) || filter_var($_POST['charges'], FILTER_VALIDATE_FLOAT)) {
            $charges = $_POST['charges'];
        } else {
            $fillingError['charges'] = "La valeur de ce champ doit être un nombre.";
        }
    } else {
        $fillingError['charges'] = $err;
    }
    //suretyBond
    if (isset($_POST['suretyBond']) && !empty($_POST['suretyBond'])) {
        if (filter_var($_POST['suretyBond'], FILTER_VALIDATE_INT) || filter_var($_POST['suretyBond'], FILTER_VALIDATE_FLOAT)) {
            $suretyBond = $_POST['suretyBond'];
        } else {
            $fillingError['suretyBond'] = "La valeur de ce champ doit être un nombre.";
        }
    } else {
        $fillingError['suretyBond'] = $err;
    }
    //financialRequirements
    if (isset($_POST['financialRequirements']) && $_POST['financialRequirements'] == 1) {
        $financialRequirements = $_POST['financialRequirements'];
    } else {
        $financialRequirements = 0;
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['solvencyRatio'])) {
        $solvencyRatio = $_POST['solvencyRatio'];
    }
    if (isset($_POST['eligibleForAids']) && $_POST['eligibleForAids'] == 1) {
        $eligibleForAids = $_POST['eligibleForAids'];
    } else {
        $eligibleForAids = 0;
    }
    if (isset($_POST['chargesIncludeCoOwnershipCharges']) && $_POST['chargesIncludeCoOwnershipCharges'] == 1) {
        $chargesIncludeCoOwnershipCharges = $_POST['chargesIncludeCoOwnershipCharges'];
    } else {
        $chargesIncludeCoOwnershipCharges = 0;
    }
    if (isset($_POST['chargesIncludeElectricity']) && $_POST['chargesIncludeElectricity'] == 1) {
        $chargesIncludeElectricity = $_POST['chargesIncludeElectricity'];
    } else {
        $chargesIncludeElectricity = 0;
    }
    if (isset($_POST['chargesIncludeHotWater']) && $_POST['chargesIncludeHotWater'] == 1) {
        $chargesIncludeHotWater = $_POST['chargesIncludeHotWater'];
    } else {
        $chargesIncludeHotWater = 0;
    }
    if (isset($_POST['chargesIncludeHeating']) && $_POST['chargesIncludeHeating'] == 1) {
        $chargesIncludeHeating = $_POST['chargesIncludeHeating'];
    } else {
        $chargesIncludeHeating = 0;
    }
    if (isset($_POST['chargesIncludeInternet']) && $_POST['chargesIncludeInternet'] == 1) {
        $chargesIncludeInternet = $_POST['chargesIncludeInternet'];
    } else {
        $chargesIncludeInternet = 0;
    }
    if (isset($_POST['chargesIncludeHomeInsurance']) && $_POST['chargesIncludeHomeInsurance'] == 1) {
        $chargesIncludeHomeInsurance = $_POST['chargesIncludeHomeInsurance'];
    } else {
        $chargesIncludeHomeInsurance = 0;
    }
    if (isset($_POST['chargesIncludeBoilerInspection']) && $_POST['chargesIncludeBoilerInspection'] == 1) {
        $chargesIncludeBoilerInspection = $_POST['chargesIncludeBoilerInspection'];
    } else {
        $chargesIncludeBoilerInspection = 0;
    }
    if (isset($_POST['chargesIncludeHouseholdGarbageTaxes']) && $_POST['chargesIncludeHouseholdGarbageTaxes'] == 1) {
        $chargesIncludeHouseholdGarbageTaxes = $_POST['chargesIncludeHouseholdGarbageTaxes'];
    } else {
        $chargesIncludeHouseholdGarbageTaxes = 0;
    }
    if (isset($_POST['chargesIncludeCleaningService']) && $_POST['chargesIncludeCleaningService'] == 1) {
        $chargesIncludeCleaningService = $_POST['chargesIncludeCleaningService'];
    } else {
        $chargesIncludeCleaningService = 0;
    }
    if (isset($_POST['isFurnished']) && $_POST['isFurnished'] == 1) {
        $isFurnished = $_POST['isFurnished'];
    } else {
        $isFurnished = 0;
    }
    if (isset($_POST['kitchenUse'])) {
        $kitchenUse = $_POST['kitchenUse'];
    }
    if (isset($_POST['livingRoomUse'])) {
        $livingRoomUse = $_POST['livingRoomUse'];
    }
    //bedroomSize
    if (isset($_POST['bedroomSize']) && !empty($_POST['bedroomSize'])) {
        if (filter_var($_POST['bedroomSize'], FILTER_VALIDATE_INT) || filter_var($_POST['bedroomSize'], FILTER_VALIDATE_FLOAT)) {
            $bedroomSize = $_POST['bedroomSize'];
        } else {
            $fillingError['bedroomSize'] = 'La valeur de ce champ doit être un nombre';
        }
    } else {
        $fillingError['bedroomSize'] = $errorEmptyField;
    }
    //bedroomType
    if (isset($_POST['bedroomType'])) {
        $bedroomType = $_POST['bedroomType'];
    }
    if (isset($_POST['bedType'])) {
        $bedType = $_POST['bedType'];
    }
    if (isset($_POST['bedroomHasDesk']) && $_POST['bedroomHasDesk'] == 1) {
        $bedroomHasDesk = $_POST['bedroomHasDesk'];
    } else {
        $bedroomHasDesk = 0;
    }
    if (isset($_POST['bedroomHasWardrobe']) && $_POST['bedroomHasWardrobe'] == 1) {
        $bedroomHasWardrobe = $_POST['bedroomHasWardrobe'];
    } else {
        $bedroomHasWardrobe = 0;
    }
    if (isset($_POST['bedroomHasChair']) && $_POST['bedroomHasChair'] == 1) {
        $bedroomHasChair = $_POST['bedroomHasChair'];
    } else {
        $bedroomHasChair = 0;
    }
    if (isset($_POST['bedroomHasTv']) && $_POST['bedroomHasTv'] == 1) {
        $bedroomHasTv = $_POST['bedroomHasTv'];
    } else {
        $bedroomHasTv = 0;
    }
    if (isset($_POST['bedroomHasArmchair']) && $_POST['bedroomHasArmchair'] == 1) {
        $bedroomHasArmchair = $_POST['bedroomHasArmchair'];
    } else {
        $bedroomHasArmchair = 0;
    }
    if (isset($_POST['bedroomHasCoffeeTable']) && $_POST['bedroomHasCoffeeTable'] == 1) {
        $bedroomHasCoffeeTable = $_POST['bedroomHasCoffeeTable'];
    } else {
        $bedroomHasCoffeeTable = 0;
    }
    if (isset($_POST['bedroomHasBedside']) && $_POST['bedroomHasBedside'] == 1) {
        $bedroomHasBedside = $_POST['bedroomHasBedside'];
    } else {
        $bedroomHasBedside = 0;
    }
    if (isset($_POST['bedroomHasLamp']) && $_POST['bedroomHasLamp'] == 1) {
        $bedroomHasLamp = $_POST['bedroomHasLamp'];
    } else {
        $bedroomHasLamp = 0;
    }
    if (isset($_POST['bedroomHasCloset']) && $_POST['bedroomHasCloset'] == 1) {
        $bedroomHasCloset = $_POST['bedroomHasCloset'];
    } else {
        $bedroomHasCloset = 0;
    }
    if (isset($_POST['bedroomHasShelf']) && $_POST['bedroomHasShelf'] == 1) {
        $bedroomHasShelf = $_POST['bedroomHasShelf'];
    } else {
        $bedroomHasShelf = 0;
    }
    if (isset($_POST['handicapedAccessibility']) && $_POST['handicapedAccessibility'] == 1) {
        $handicapedAccessibility = $_POST['handicapedAccessibility'];
    } else {
        $handicapedAccessibility = 0;
    }
    if (isset($_POST['accomodationHasElevator']) && $_POST['accomodationHasElevator'] == 1) {
        $accomodationHasElevator = $_POST['accomodationHasElevator'];
    } else {
        $accomodationHasElevator = 0;
    }
    if (isset($_POST['accomodationHasCommonParkingLot']) && $_POST['accomodationHasCommonParkingLot'] == 1) {
        $accomodationHasCommonParkingLot = $_POST['accomodationHasCommonParkingLot'];
    } else {
        $accomodationHasCommonParkingLot = 0;
    }
    if (isset($_POST['accomodationHasPrivateParkingPlace']) && $_POST['accomodationHasPrivateParkingPlace'] == 1) {
        $accomodationHasPrivateParkingPlace = $_POST['accomodationHasPrivateParkingPlace'];
    } else {
        $accomodationHasPrivateParkingPlace = 0;
    }
    if (isset($_POST['accomodationHasGarden']) && $_POST['accomodationHasGarden'] == 1) {
        $accomodationHasGarden = $_POST['accomodationHasGarden'];
    } else {
        $accomodationHasGarden = 0;
    }
    if (isset($_POST['accomodationHasBalcony']) && $_POST['accomodationHasBalcony'] == 1) {
        $accomodationHasBalcony = $_POST['accomodationHasBalcony'];
    } else {
        $accomodationHasBalcony = 0;
    }
    if (isset($_POST['accomodationHasTerrace']) && $_POST['accomodationHasTerrace'] == 1) {
        $accomodationHasTerrace = $_POST['accomodationHasTerrace'];
    } else {
        $accomodationHasTerrace = 0;
    }
    if (isset($_POST['accomodationHasSwimmingPool']) && $_POST['accomodationHasSwimmingPool'] == 1) {
        $accomodationHasSwimmingPool = $_POST['accomodationHasSwimmingPool'];
    } else {
        $accomodationHasSwimmingPool = 0;
    }
    if (isset($_POST['accomodationHasTv']) && $_POST['accomodationHasTv'] == 1) {
        $accomodationHasTv = $_POST['accomodationHasTv'];
    } else {
        $accomodationHasTv = 0;
    }
    if (isset($_POST['accomodationHasInternet']) && $_POST['accomodationHasInternet'] == 1) {
        $accomodationHasInternet = $_POST['accomodationHasInternet'];
    } else {
        $accomodationHasInternet = 0;
    }
    if (isset($_POST['accomodationHasWifi']) && $_POST['accomodationHasWifi'] == 1) {
        $accomodationHasWifi = $_POST['accomodationHasWifi'];
    } else {
        $accomodationHasWifi = 0;
    }
    if (isset($_POST['accomodationHasFiberOpticInternet']) && $_POST['accomodationHasFiberOpticInternet'] == 1) {
        $accomodationHasFiberOpticInternet = $_POST['accomodationHasFiberOpticInternet'];
    } else {
        $accomodationHasFiberOpticInternet = 0;
    }
    if (isset($_POST['accomodationHasNetflix']) && $_POST['accomodationHasNetflix'] == 1) {
        $accomodationHasNetflix = $_POST['accomodationHasNetflix'];
    } else {
        $accomodationHasNetflix = 0;
    }
    if (isset($_POST['accomodationHasDoubleGlazing']) && $_POST['accomodationHasDoubleGlazing'] == 1) {
        $accomodationHasDoubleGlazing = $_POST['accomodationHasDoubleGlazing'];
    } else {
        $accomodationHasDoubleGlazing = 0;
    }
    if (isset($_POST['accomodationHasAirConditioning']) && $_POST['accomodationHasAirConditioning'] == 1) {
        $accomodationHasAirConditioning = $_POST['accomodationHasAirConditioning'];
    } else {
        $accomodationHasAirConditioning = 0;
    }
    if (isset($_POST['accomodationHasElectricHeating']) && $_POST['accomodationHasElectricHeating'] == 1) {
        $accomodationHasElectricHeating = $_POST['accomodationHasElectricHeating'];
    } else {
        $accomodationHasElectricHeating = 0;
    }
    if (isset($_POST['accomodationHasIndividualGasHeating']) && $_POST['accomodationHasIndividualGasHeating'] == 1) {
        $accomodationHasIndividualGasHeating = $_POST['accomodationHasIndividualGasHeating'];
    } else {
        $accomodationHasIndividualGasHeating = 0;
    }
    if (isset($_POST['accomodationHasCollectiveGasHeating']) && $_POST['accomodationHasCollectiveGasHeating'] == 1) {
        $accomodationHasCollectiveGasHeating = $_POST['accomodationHasCollectiveGasHeating'];
    } else {
        $accomodationHasCollectiveGasHeating = 0;
    }
    if (isset($_POST['accomodationHasHotWaterTank']) && $_POST['accomodationHasHotWaterTank'] == 1) {
        $accomodationHasHotWaterTank = $_POST['accomodationHasHotWaterTank'];
    } else {
        $accomodationHasHotWaterTank = 0;
    }
    if (isset($_POST['accomodationHasGasWaterHeater']) && $_POST['accomodationHasGasWaterHeater'] == 1) {
        $accomodationHasGasWaterHeater = $_POST['accomodationHasGasWaterHeater'];
    } else {
        $accomodationHasGasWaterHeater = 0;
    }
    if (isset($_POST['accomodationHasFridge']) && $_POST['accomodationHasFridge'] == 1) {
        $accomodationHasFridge = $_POST['accomodationHasFridge'];
    } else {
        $accomodationHasFridge = 0;
    }
    if (isset($_POST['accomodationHasFreezer']) && $_POST['accomodationHasFreezer'] == 1) {
        $accomodationHasFreezer = $_POST['accomodationHasFreezer'];
    } else {
        $accomodationHasFreezer = 0;
    }
    if (isset($_POST['accomodationHasOven']) && $_POST['accomodationHasOven'] == 1) {
        $accomodationHasOven = $_POST['accomodationHasOven'];
    } else {
        $accomodationHasOven = 0;
    }
    if (isset($_POST['accomodationHasBakingTray'])  && $_POST['accomodationHasBakingTray'] == 1) {
        $accomodationHasBakingTray = $_POST['accomodationHasBakingTray'];
    } else {
        $accomodationHasBakingTray = 0;
    }
    if (isset($_POST['accomodationHasWashingMachine'])  && $_POST['accomodationHasWashingMachine'] == 1) {
        $accomodationHasWashingMachine = $_POST['accomodationHasWashingMachine'];
    } else {
        $accomodationHasWashingMachine = 0;
    }
    if (isset($_POST['accomodationHasDishwasher']) && $_POST['accomodationHasDishwasher'] == 1) {
        $accomodationHasDishwasher = $_POST['accomodationHasDishwasher'];
    } else {
        $accomodationHasDishwasher = 0;
    }
    if (isset($_POST['accomodationHasMicrowaveOven']) && $_POST['accomodationHasMicrowaveOven'] == 1) {
        $accomodationHasMicrowaveOven = $_POST['accomodationHasMicrowaveOven'];
    } else {
        $accomodationHasMicrowaveOven = 0;
    }
    if (isset($_POST['accomodationHasCoffeeMachine']) && $_POST['accomodationHasCoffeeMachine'] == 1) {
        $accomodationHasCoffeeMachine = $_POST['accomodationHasCoffeeMachine'];
    } else {
        $accomodationHasCoffeeMachine = 0;
    }
    if (isset($_POST['accomodationHasPodCoffeeMachine']) && $_POST['accomodationHasPodCoffeeMachine'] == 1) {
        $accomodationHasPodCoffeeMachine = $_POST['accomodationHasPodCoffeeMachine'];
    } else {
        $accomodationHasPodCoffeeMachine = 0;
    }
    if (isset($_POST['accomodationHasKettle']) && $_POST['accomodationHasKettle'] == 1) {
        $accomodationHasKettle = $_POST['accomodationHasKettle'];
    } else {
        $accomodationHasKettle = 0;
    }
    if (isset($_POST['accomodationHasToaster']) && $_POST['accomodationHasToaster'] == 1) {
        $accomodationHasToaster = $_POST['accomodationHasToaster'];
    } else {
        $accomodationHasToaster = 0;
    }
    if (isset($_POST['accomodationHasExtractorHood']) && $_POST['accomodationHasExtractorHood'] == 1) {
        $accomodationHasExtractorHood = $_POST['accomodationHasExtractorHood'];
    } else {
        $accomodationHasExtractorHood = 0;
    }
    if (isset($_POST['animalsAllowed']) && $_POST['animalsAllowed'] == 1) {
        $animalsAllowed = $_POST['animalsAllowed'];
    } else {
        $animalsAllowed = 0;
    }
    if (isset($_POST['smokingIsAllowed']) && $_POST['smokingIsAllowed'] == 1) {
        $smokingIsAllowed = $_POST['smokingIsAllowed'];
    } else {
        $smokingIsAllowed = 0;
    }
    if (isset($_POST['authorizedParty']) && $_POST['authorizedParty'] == 1) {
        $authorizedParty = $_POST['authorizedParty'];
    } else {
        $authorizedParty = 0;
    }
    if (isset($_POST['authorizedVisit']) && $_POST['authorizedVisit'] == 1) {
        $authorizedVisit = $_POST['authorizedVisit'];
    } else {
        $authorizedVisit = 0;
    }
    if (isset($_POST['nbOfOtherRoommatePresent'])) {
        $nbOfOtherRoommatePresent = $_POST['nbOfOtherRoommatePresent'];
    }
    if (isset($_POST['roommateSex'])) {
        $otherRoommateSex = $_POST['roommateSex'];
    }
    if (isset($_POST['renterSituation'])) {
        $renterSituation = $_POST['renterSituation'];
    }
    if (isset($_POST['idealRoommateSex'])) {
        $idealRoommateSex = $_POST['idealRoommateSex'];
    }
    if (isset($_POST['idealRoommateSituation'])) {
        $idealRoommateSituation = $_POST['idealRoommateSituation'];
    }
    if (isset($_POST['idealRoommateMinAge']) && strlen($_POST['idealRoommateMinAge']) < 3) {
        $idealRoommateMinAge = $_POST['idealRoommateMinAge'];
    }
    if (isset($_POST['idealRoommateMaxAge']) && strlen($_POST['idealRoommateMaxAge']) < 3) {
        $idealRoommateMaxAge = $_POST['idealRoommateMaxAge'];
    }
    if (isset($_POST['locationMinDuration'])) {
        $locationMinDuration = $_POST['locationMinDuration'];
    }
    if (isset($_POST['rentWithoutVisit'])) {
        $rentWithoutVisit = $_POST['rentWithoutVisit'];
    } else {
        $rentWithoutVisit = 0;
    }
    //contactNameForVisit
    if (isset($_POST['contactNameForVisit']) && !empty($_POST['contactNameForVisit'])) {
        if (strlen($_POST['contactNameForVisit'])>125) {
            $fillingError['contactNameForVisit'] = '125 caractères maximum';
        } else {
            $contactNameForVisit = $_POST['contactNameForVisit'];
        }
    } else {
        $fillingError['contactNameForVisit'] = $errorEmptyField;
    }
    //contactPhoneNumberForVisit
    if (isset($_POST['contactPhoneNumberForVisit']) && !empty($_POST['contactPhoneNumberForVisit'])) {
        if (strlen($_POST['contactPhoneNumberForVisit'])>20) {
            $fillingError['contactPhoneNumberForVisit'] = '20 caractères maximum';
        } else {
            $contactPhoneNumberForVisit = $_POST['contactPhoneNumberForVisit'];
        }
    } else {
        $fillingError['contactPhoneNumberForVisit'] = $errorEmptyField;
    }
    //contactMailForVisit
    if (isset($_POST['contactMailForVisit']) && !empty($_POST['contactMailForVisit'])) {
        if (strlen($_POST['contactMailForVisit']) > 255) {
            $fillingError['contactMailForVisit'] = '255 caractères maximum';
        } else {
            if (filter_var($_POST['contactMailForVisit'], FILTER_VALIDATE_EMAIL)) {
                $contactMailForVisit = $_POST['contactMailForVisit'];
            } else {
                $fillingError['contactMailForVisit'] = 'L\'adresse mail est incomplète';
            }
        }
    } else {
        $fillingError['contactMailForVisit'] = $errorEmptyField;
    }
    //Contrôle nombre de photos
    $nbOfpictures = 0;
    if ($advertisementIdToModify) {
        //On récupère le nombre de photos en bdd
        $pictureInBddArray = getAdvertisementPictures($advertisementIdToModify);
        $numberOfPictureInBdd = count($pictureInBddArray);
        $nbOfpictures+=$numberOfPictureInBdd;

        if (isset($_POST['pictureToDelete'])) {
            $numberPictureToDelete = count($_POST['pictureToDelete']);
            $nbOfpictures-=$numberPictureToDelete;
        }
        if (isset($_FILES) && !empty($_FILES['file']['name'][0])) {
            $numberNewPictures = count($_FILES['file']['name']);
            $nbOfpictures+=$numberNewPictures;

        }
    } else {
        if (isset($_FILES)) {
            $numberNewPictures = count($_FILES['file']['name']);
            $nbOfpictures+=$numberNewPictures;
        }
    }
    if ($nbOfpictures>10) {
        $fillingError['file'] = "Votre annonce peut contenir 10 photos maximum.";
    } else if ($nbOfpictures < 1){
        $fillingError['file'] = "Votre annonce doit contenir au moins une photo.";
    }
    //Résultat des contrôles
    if (!empty($fillingError)) {
        if (isset($_POST) && empty($_POST)) {
            header('Location:index.php?page=displayAddAnAdvertisement&error=pbTechnique');
            exit;
        }
        if ($advertisementIdToModify) {
            $postData = $_POST;
            $advertisementPicture = getAdvertisementPictures($advertisementIdToModify);
            $picturePath = "public/pictures/users/";
            if($_SESSION['isAdmin']){
                if ($userId != $_SESSION['id']){
                    $userData = getUserById($userId);
                }
                require_once('view/backEnd/v_advertisementModifyFormAdmin.php');
            }else{
                $titleData = getTitleFromAdvertisement($advertisementIdToModify);
                require_once('view/frontEndUserConnected/v_advertisementModifyForm.php');
            }
        } else {
            $postData = $_POST;
            require_once('view/frontEndUserConnected/v_advertisementAddForm.php');
        }
        exit;
    }
    //Réorganisation du tableau $_FILES
    $filesArray = reArrayFiles($_FILES);
    //On verifie s'il y a des photos dans le tableau $filesArray
    if (!empty($filesArray[0]['name'])) {
        //Définition constante
        define("UPLOAD_REP_PHOTO", "public/pictures/users/");
        define("UPLOAD_EXTENSION_PHOTO", "jpg,jpeg,png,gif");
        define("UPLOAD_MIMETYPE_PHOTO", "image/jpeg,image/png,image/gif");
        define("UPLOAD_SIZEMAX_PHOTO", 10000000); // La taille, en octets.
    
        // Messages d'erreurs de chargement de fichiers
        $array_upload_err = [
            UPLOAD_ERR_OK => "Valeur : 0. Aucune erreur, le téléchargement est correct.",
            UPLOAD_ERR_INI_SIZE => "Valeur : 1. La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini.",
            UPLOAD_ERR_FORM_SIZE => "Valeur : 2. La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.",
            UPLOAD_ERR_PARTIAL => "Valeur : 3. Le fichier n'a été que partiellement téléchargé.",
            UPLOAD_ERR_NO_FILE => "Valeur : 4. Aucun fichier n'a été téléchargé.",
            UPLOAD_ERR_NO_TMP_DIR => "Valeur : 6. Un dossier temporaire est manquant.",
            UPLOAD_ERR_CANT_WRITE => "Valeur : 7. Échec de l'écriture du fichier sur le disque.",
            UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté l'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause.",
            ];
        //Création Tableau pour stocker nom des photos uploadées
        $fileUpload = array();
        //Boucle upload photos
        for ($i = 0 ; $i < count($filesArray) ; $i++) {
            $namePictureTmp = $filesArray[$i]['tmp_name'];
            $namePicture = $filesArray[$i]['name'];
            //Création Tableau pour stocker les erreurs
            $errors = array();
            //Vérification si un fichier a bien été téléchargé
            if ($filesArray[$i]['error'] != 0) {
                $errors['upload_err'] = $array_upload_err[$filesArray[$i]['error']];
            } else {
                //VERIFICATION EXTENSION
                // Récupère l'extension d'un fichier
                $splFileInfo = new SplFileInfo($namePicture);
                $fileExtension = strtolower($splFileInfo->getExtension());
                if (!in_array($fileExtension, explode(',', constant('UPLOAD_EXTENSION_PHOTO')))) {
                    $errors['extension'] = 'L\'extension ne correspond pas aux extensions acceptées';
                } else {
                    //VERIFICATION TYPE MIME
                    // Récupère le type mime du fichier
                    $fileMimeType = mime_content_type($namePictureTmp);
                    if (!in_array($fileMimeType, explode(',', constant('UPLOAD_MIMETYPE_PHOTO')))) {
                        $errors['typeMime'] = 'L\'extension ne correspond pas aux extensions acceptées';
                    } else {
                        //VERIFICATION TAILLE IMAGE
                        // On vérifie la taille, en octets, du fichier téléchargé
                        if ($filesArray[$i]['size'] > UPLOAD_SIZEMAX_PHOTO) {
                            $errors['size'] = 'Taille de fichier supérieure à la taille maxi autorisée';
                        } else {
                            //Verification nombre de pixels png
                            $pixelImage = getimagesize($namePictureTmp);
                            if ($pixelImage[0]*$pixelImage[1]>1000000 && $fileExtension == 'png') {
                                $errors['pixel_err'] = "L'image png sera déformée";
                            }
                        }
                    }
                }
                if (empty($errors)) {
                    //On génère un nom unique pour la photo
                    $namePicture = uniqid().'.'.$fileExtension;
                    //Calcul pourcentage qualité à appliquer
                    $quality=floor((1000000*100)/$filesArray[$i]['size']);
                    //Récupère la taille de la photo
                    $pictureSize = $filesArray[$i]['size'];
                    //On enregistre la photo dans le dossier
                    if (move_uploaded_file($namePictureTmp, UPLOAD_REP_PHOTO . $namePicture)) {
                        //On compresse si taille plus de 1mo
                        if ($pictureSize>1000000) {
                            if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
                                $img = imagecreatefromjpeg(UPLOAD_REP_PHOTO . $namePicture);
                                imagejpeg($img, UPLOAD_REP_PHOTO . $namePicture, $quality);
                                imagedestroy($img);
                            } elseif ($fileExtension == 'png') {
                                $pngQuality = ($quality - 100) / 11.111111;
                                $pngQuality = round(abs($pngQuality));
                                ini_set('memory_limit', '-1');
                                $img = imagecreatefrompng(UPLOAD_REP_PHOTO . $namePicture);
                                imagepng($img, UPLOAD_REP_PHOTO . $namePicture, $quality);
                                imagedestroy($img);
                            } elseif ($fileExtension == 'gif') {
                                $img = imagecreatefromgif(UPLOAD_REP_PHOTO . $namePicture);
                                imagegif($img, UPLOAD_REP_PHOTO . $namePicture, $quality);
                                imagedestroy($img);
                            }
                        }
                        //Enregistrement nom de la photo dans tableau pour ensuite enregistrer en bdd
                        $fileUpload[$i] = $namePicture;
                    } else {
                        $error['moveUpload'] = 'Echec de l\'upload !';
                        $postData = $_POST;
                        require_once('view/frontEndUserConnected/v_advertisementAddForm.php');
                        exit;
                    }
                } else {
                    $postData = $_POST;
                    require_once('view/frontEndUserConnected/v_advertisementAddForm.php');
                    exit;
                }
            }
        }
    }
    //ENREGISTREMENT EN BASE DE DONNEES
    //AJOUT NOUVELLE ADRESSE
    if ($advertisementIdToModify) {
        //On récupère l'id de l'adresse à modifier
        $addressIdToModify = getAddressIdFromAdvertisement($advertisementIdToModify);
        modifyAddress($addressIdToModify, $addressStreet, $addressZipcode, $addressCity, $addressCountry);
    } else {
        $addressId = insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry);
    }
    //AJOUT OU MODIFICATION ANNONCE
    if ($advertisementIdToModify) {
        if($_SESSION['isAdmin']){
            require_once('model/backEnd/m_modifyAdvertisement.php');
            if (saveModifyAdvertisementInBddAdmin($isActive, $availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $otherRoommateSex, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressIdToModify, $advertisementIdToModify)) {
                $saveAdvertisement = true;
            } else {
                $saveAdvertisement = false;
            }
        }else{
            if (saveModifyAdvertisementInBdd($isActive, $availableDate, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $otherRoommateSex, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressIdToModify, $advertisementIdToModify)) {
                $saveAdvertisement = true;
            } else {
                $saveAdvertisement = false;
            }
        }
    } else {
        if (insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $otherRoommateSex, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId, $_SESSION['id'])) {
            $saveAdvertisement = true;
        } else {
            $saveAdvertisement = false;
        }
    }
    //Si l'annonce a bien été enregistré alors vérification s'il y a des photos
    if ($saveAdvertisement) {
        //SUPPRESSION PHOTOS (page modification annonce)
        if (isset($_POST['pictureToDelete'])) {
            foreach ($_POST['pictureToDelete'] as $key => $value) {
                deleteOnePicture($advertisementIdToModify, $value);
                unlink('public/pictures/users/'.$value.'');
            }
            reorganizePictureOrder($advertisementIdToModify);
        }
        //AJOUT NOUVELLES PHOTOS
        //On vérifie s'il y a des photos à enregistrer et si oui, recupération id de la dernière annonce
        if (!empty($fileUpload)) {
            if ($advertisementIdToModify) {
                //On récupère l'id de l'annonce qui a été passée en argument en appel à cette fonction
                $advertisementId = $advertisementIdToModify;
            } else {
                //On récupère l'id de la derniere annonce
                $advertisementIdVerification = getLastAdvertisementId($_SESSION['id']);
                //On vérifie qu'on bien récupéré l'id et le stocke dans une variable
                if ($advertisementIdVerification) {
                    $advertisementId = $advertisementIdVerification['MAX(advertisement_id)'];
                }
            }
            //Si les photos ont bien été inséré en bdd alors on stocke dans la variable $message que l'annonce a bien été ajouté
            if (insertPictures($fileUpload, $advertisementId)) {
                if ($advertisementIdToModify) {
                    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                        $message = 'L\'annonce a bien été modifiée';
                    } else {
                        $message = 'Votre annonce a bien été modifiée';
                    }
                } else {
                    $message = 'Votre nouvelle annonce a bien été ajoutée';
                    // On récupère l'adresse mail de l'utilisateur
                    $userInfos = getUserById($userId);
                    $userMail = $userInfos['user_mail'];
                    $dayMonth = calculAccountCreationDateDayMonth($userInfos['user_accountCreationDate']);
                    if($userInfos['user_passwordSiteWeb']){
                        $userPassword = $userInfos['user_passwordSiteWeb'];
                    }else{
                        $userPassword = 'Coloc'.$userInfos['user_id'].$dayMonth;
                    }
                    //Création message à envoyer par mail
                    $to = $userMail;
                    $subject = "Asdelacoloc - Votre dépôt d'annonce";
                    $body = 'Bonjour,'."\r\n".'';
                    $body.= 'Votre annonce va se diffuser sur tous les sites pour lesquels votre compte a pu être créé.'."\r\n"."\r\n".'';
                    $body.= 'D\'ici 48h environ, pour consulter vos messages sur chaques sites, merci de vous connecter avec les identifiants ci-dessous :'."\r\n".'';
                    $body.= 'Identifiant : '.$userMail.''."\r\n".'';
                    $body.= 'Mot de passe : '.$userPassword.''."\r\n"."\r\n".'';
                    $body.= 'Veuillez ne jamais modifier votre titre sur les sites où l\'annonce est diffusée.'."\r\n".'';
                    $body.= 'Si vous devez effectuer une modification de vos descriptions, veuillez le faire sur le site app.asdelacoloc.fr'."\r\n"."\r\n".'';
                    $body.= 'Merci.'."\r\n".'';
                    $body.= 'A bientôt'."\r\n"."\r\n".'';
                    $body.= 'Aurélien'."\r\n".'';
                    $body.= 'Asdelacoloc.fr';
                    $headers[] = 'From: Asdelacoloc <no-reply@asdelacoloc.fr>'."\r\n".
                    'Reply-To: no-reply@asdelacoloc.fr'."\r\n";
                    //Envoi du mail à l'utilisateur
                    mail($to, utf8_decode($subject), utf8_decode($body), implode("\r\n", $headers));
                }
            } else {
                $error ='Aucune annonce ne correspond pour vos photos!';
            }
        } else {
            if ($advertisementIdToModify) {
                if ($_SESSION['isAdmin']) {
                    $message = 'L\'annonce a bien été modifiée';
                } else {
                    $message = 'Votre annonce a bien été modifiée';
                }
            } else {
                $message = 'Votre nouvelle annonce a bien été ajoutée';
                // On récupère l'adresse mail de l'utilisateur
                $userInfos = getUserById($userId);
                $userMail = $userInfos['user_mail'];
                $dayMonth = calculAccountCreationDateDayMonth($userInfos['user_accountCreationDate']);
                if($userInfos['user_passwordSiteWeb']){
                    $userPassword = $userInfos['user_passwordSiteWeb'];
                }else{
                    $userPassword = 'Coloc'.$userInfos['user_id'].$dayMonth;
                }
                //Création message à envoyer par mail
                $to = $userMail;
                $subject = "Asdelacoloc - Votre dépôt d'annonce";
                $body = 'Bonjour,'."\r\n".'';
                $body.= 'Votre annonce va se diffuser sur tous les sites pour lesquels votre compte a pu être créé.'."\r\n"."\r\n".'';
                $body.= 'D\'ici 48h environ, pour consulter vos messages sur chaques sites, merci de vous connecter avec les identifiants ci-dessous :'."\r\n".'';
                $body.= 'Identifiant : '.$userMail.''."\r\n".'';
                $body.= 'Mot de passe : '.$userPassword.''."\r\n"."\r\n".'';
                $body.= 'Merci.'."\r\n".'';
                $body.= 'A bientôt'."\r\n"."\r\n".'';
                $body.= 'Aurélien'."\r\n".'';
                $body.= 'Asdelacoloc.fr';
                $headers[] = 'From: Asdelacoloc <no-reply@asdelacoloc.fr>'."\r\n".
                'Reply-To: no-reply@asdelacoloc.fr'."\r\n";
                //Envoi du mail à l'utilisateur
                mail($to, $subject, $body, implode("\r\n", $headers));
            }
        }
    } else {
        $error = 'Problème technique. Veuillez réessayer ultérieurement';
    }
        
    //Appel de la fonction pour afficher la liste des annonces de l'utilisateur en passant en argument les messages d'erreur ou de confirmation
    if (isset($error)) {
        if ($_SESSION['isAdmin'] && $_SESSION['id']!=$userId) {
            require('controller/backEnd/c_userAdvertisements.php');
            displayUserAdvertisements($userId, $error, null);
        } else {
            displayMyAdvertisements($error);
        }
    } elseif (isset($message)) {
        if ($_SESSION['isAdmin'] && $_SESSION['id']!=$userId) {
            require('controller/backEnd/c_userAdvertisements.php');
            displayUserAdvertisements($userId, null, $message);
        } else {
            displayMyAdvertisements(null, $message);
        }
    } else {
        displayMyAdvertisements();
    }
}
//Supprime une annonce
function deleteAdvertisement($advertisementIdToDelete)
{
    //On vérifie si l'annonce qui doit etre supprimée appartient à l'utilisateur connecté ou si la demande vient d'un admin
    $verifyAdvertisementBelongsToUser = verifyAdvertisementBelongsToUser($_SESSION['id'], $advertisementIdToDelete);
    if ($verifyAdvertisementBelongsToUser || $_SESSION['isAdmin']==true) {
        
        //SUPPRESSION PHOTOS
        $picturesRequest = getAdvertisementPictures($advertisementIdToDelete);
        if (!empty($picturesRequest)) {
            //On supprime toutes les photos liées à l'annonce dans la base de donnée
            deletePictureBdd($advertisementIdToDelete);
            //On supprime les photos du dossier public/pictures/users
            foreach ($picturesRequest as $key => $value) {
                unlink('public/pictures/users/'.$picturesRequest[$key]['picture_fileName'].'');
            }
        }
        //On ne supprime pas l'adresse car l'annonce n'est pas vraiment supprimée (isRegister=0)
        //SI la demande vient d'un admin, on recupere l'id du user de l'annonce à supprimer
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            require_once('model/backEnd/m_getUsers.php');
            $userIdFromAdvertisementToDelete = getUserIdFromAdvertisementId($advertisementIdToDelete)['user_id'];
        }
        //SUPPRESSION ANNONCE (passe le champ isRegister à 0)
        if (deleteAdvertisementBdd($advertisementIdToDelete)) {
            //Si la demande vient d'un admin
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                //Si l'annonce supprimée appartient à l'admin
                if ($verifyAdvertisementBelongsToUser) {
                    $message = 'Votre annonce a été supprimée.';
                    displayMyAdvertisements(null, $message);
                } else {
                    require_once('controller/backEnd/c_userAdvertisements.php');
                    $message = 'L\'annonce a été supprimée';
                    displayUserAdvertisements($userIdFromAdvertisementToDelete, null, $message);
                }
            } else {
                //On appelle la fonction qui affiche la page "mes annonces"
                $message = 'Votre annonce a été supprimée.';
                displayMyAdvertisements(null, $message);
            }
        } else {
            $error = "Problème technique. Veuillez réessayer ultérieurement.";
            displayMyAdvertisements($error);
        }
    } else {
        //Sinon l'annonce n'appartient pas à l'utilisateur connecté
        $error = "Problème technique.";
        displayMyAdvertisements($error);
    }
}