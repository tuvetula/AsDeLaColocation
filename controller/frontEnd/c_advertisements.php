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

//Affichage de la page "Mes annonces"
function displayMyAdvertisements($error=null, $message=null)
{
    //Récupération annonces utilisateurs
    $userAdvertisements = getUserAdvertisementRegister($_SESSION['id']);
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
    require_once('view/frontEndUserConnected/v_advertisementsDisplay.php');
}

//Affichage page "Ajouter une annonce" (formulaire)
function displayAddAnAdvertisementForm()
{
    //Variable pour définir date minimum dans "disponible le"
    $dateOfTheDay=date('Y-m-d');

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
        require_once('view/frontEndUserConnected/v_advertisementModifyForm.php');
    } else {
        $error = "Erreur";
        require_once('view/frontEnd/v_error.php');
    }
}

//Traitement enregistrement nouvelle annonce ou modification annonce en base de donnée
function saveNewOrModifyAdvertisement()
{
    //Nous permet de savoir si il faut modifier une annonce ou en créer une nouvelle
    if (isset($_POST['id'])) {
        $advertisementIdToModify = $_POST['id'];
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
        $addressStreet = $_POST['street'];
    } else {
        $fillingError['street'] = 'Le numéro et nom de rue n\'est pas renseigné';
    }
    if (isset($_POST['zipcode']) && !empty($_POST['zipcode'])) {
        $addressZipcode = $_POST['zipcode'];
    } else {
        $fillingError['zipcode'] = 'Le code postal n\'est pas renseigné';
    }
    if (isset($_POST['city']) && !empty($_POST['city'])) {
        $addressCity = $_POST['city'];
    } else {
        $fillingError['city'] = 'Le nom de ville n\'est pas renseigné';
    }
    if (isset($_POST['country']) && !empty($_POST['country'])) {
        $addressCountry = $_POST['country'];
    } else {
        $fillingError['country'] = 'Le nom de pays n\'est renseigné';
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
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        if (strlen($_POST['title'])>80) {
            $fillingError['title'] = '80 caractères maximum';
        } else {
            $title = $_POST['title'];
        }
    } else {
        $fillingError['title'] = 'Veuillez renseigner ce champ';
    }
    //description
    if (isset($_POST['description']) && !empty($_POST['description'])) {
        if (strlen($_POST['description'])>3000) {
            $fillingError['description'] = '3000 caractères maximum';
        } else {
            $description = $_POST['description'];
        }
    } else {
        $fillingError['description'] = 'Veuillez renseigner ce champ';
    }
    //type
    if (isset($_POST['type']) && ($_POST['type'] == "Maison" || $_POST['type'] == "Appartement")) {
        $type = $_POST['type'];
    } else {
        $fillingError['type'] = 'Veuillez renseigner ce champ';
    }
    //Category
    if (isset($_POST['category']) && ($_POST['category'] == 'Location' || $_POST['category'] == 'Colocation' || $_POST['category'] == 'Sous-location' || $_POST['category'] == 'Courte-durée')) {
        $category = $_POST['category'];
    } else {
        $fillingError['category'] = 'Veuillez renseigner ce champ';
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
        $fillingError['energyClassNumber'] = 'Veuillez renseigner ce champ';
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
        $fillingError['gesNumber'] = 'Veuillez renseigner ce champ';
    }
    //accomodationLivingAreaSize
    if (isset($_POST['accomodationLivingAreaSize']) && !empty($_POST['accomodationLivingAreaSize'])) {
        if (filter_var($_POST['accomodationLivingAreaSize'], FILTER_VALIDATE_INT) || filter_var($_POST['accomodationLivingAreaSize'], FILTER_VALIDATE_FLOAT)) {
            $accomodationLivingAreaSize = $_POST['accomodationLivingAreaSize'];
        } else {
            $fillingError['accomodationLivingAreaSize'] = 'La valeur de ce champ doit être un nombre';
        }
    } else {
        $fillingError['accomodationLivingAreaSize'] = 'Veuillez renseigner ce champ';
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
        $fillingError['monthlyRentExcludingCharges'] = 'Veuillez renseigner ce champ';
    }
    //charges
    if (isset($_POST['charges']) && !empty($_POST['charges'])) {
        if (filter_var($_POST['charges'], FILTER_VALIDATE_INT) || filter_var($_POST['charges'], FILTER_VALIDATE_FLOAT)) {
            $charges = $_POST['charges'];
        } else {
            $fillingError['charges'] = "La valeur de ce champ doit être un nombre.";
        }
    } else {
        $fillingError['charges'] = 'Veuillez renseigner ce champ';
    }
    //suretyBond
    if (isset($_POST['suretyBond']) && !empty($_POST['suretyBond'])) {
        if (filter_var($_POST['suretyBond'], FILTER_VALIDATE_INT) || filter_var($_POST['suretyBond'], FILTER_VALIDATE_FLOAT)) {
            $suretyBond = $_POST['suretyBond'];
        } else {
            $fillingError['suretyBond'] = "La valeur de ce champ doit être un nombre.";
        }
    } else {
        $fillingError['suretyBond'] = 'Veuillez renseigner ce champ';
    }
    //financialRequirements
    if (isset($_POST['financialRequirements'])) {
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
    if (isset($_POST['eligibleForAids'])) {
        $eligibleForAids = $_POST['eligibleForAids'];
    } else {
        $eligibleForAids = 0;
    }
    if (isset($_POST['chargesIncludeCoOwnershipCharges'])) {
        $chargesIncludeCoOwnershipCharges = $_POST['chargesIncludeCoOwnershipCharges'];
    } else {
        $chargesIncludeCoOwnershipCharges = 0;
    }
    if (isset($_POST['chargesIncludeElectricity'])) {
        $chargesIncludeElectricity = $_POST['chargesIncludeElectricity'];
    } else {
        $chargesIncludeElectricity = 0;
    }
    if (isset($_POST['chargesIncludeHotWater'])) {
        $chargesIncludeHotWater = $_POST['chargesIncludeHotWater'];
    } else {
        $chargesIncludeHotWater = 0;
    }
    if (isset($_POST['chargesIncludeHeating'])) {
        $chargesIncludeHeating = $_POST['chargesIncludeHeating'];
    } else {
        $chargesIncludeHeating = 0;
    }
    if (isset($_POST['chargesIncludeInternet'])) {
        $chargesIncludeInternet = $_POST['chargesIncludeInternet'];
    } else {
        $chargesIncludeInternet = 0;
    }
    if (isset($_POST['chargesIncludeHomeInsurance'])) {
        $chargesIncludeHomeInsurance = $_POST['chargesIncludeHomeInsurance'];
    } else {
        $chargesIncludeHomeInsurance = 0;
    }
    if (isset($_POST['chargesIncludeBoilerInspection'])) {
        $chargesIncludeBoilerInspection = $_POST['chargesIncludeBoilerInspection'];
    } else {
        $chargesIncludeBoilerInspection = 0;
    }
    if (isset($_POST['chargesIncludeHouseholdGarbageTaxes'])) {
        $chargesIncludeHouseholdGarbageTaxes = $_POST['chargesIncludeHouseholdGarbageTaxes'];
    } else {
        $chargesIncludeHouseholdGarbageTaxes = 0;
    }
    if (isset($_POST['chargesIncludeCleaningService'])) {
        $chargesIncludeCleaningService = $_POST['chargesIncludeCleaningService'];
    } else {
        $chargesIncludeCleaningService = 0;
    }
    if (isset($_POST['isFurnished'])) {
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
        $fillingError['bedroomSize'] = 'Veuillez renseigner ce champ';
    }
    //bedroomType
    if (isset($_POST['bedroomType'])) {
        $bedroomType = $_POST['bedroomType'];
    }
    if (isset($_POST['bedType'])) {
        $bedType = $_POST['bedType'];
    }
    if (isset($_POST['bedroomHasDesk'])) {
        $bedroomHasDesk = $_POST['bedroomHasDesk'];
    } else {
        $bedroomHasDesk = 0;
    }
    if (isset($_POST['bedroomHasWardrobe'])) {
        $bedroomHasWardrobe = $_POST['bedroomHasWardrobe'];
    } else {
        $bedroomHasWardrobe = 0;
    }
    if (isset($_POST['bedroomHasChair'])) {
        $bedroomHasChair = $_POST['bedroomHasChair'];
    } else {
        $bedroomHasChair = 0;
    }
    if (isset($_POST['bedroomHasTv'])) {
        $bedroomHasTv = $_POST['bedroomHasTv'];
    } else {
        $bedroomHasTv = 0;
    }
    if (isset($_POST['bedroomHasArmchair'])) {
        $bedroomHasArmchair = $_POST['bedroomHasArmchair'];
    } else {
        $bedroomHasArmchair = 0;
    }
    if (isset($_POST['bedroomHasCoffeeTable'])) {
        $bedroomHasCoffeeTable = $_POST['bedroomHasCoffeeTable'];
    } else {
        $bedroomHasCoffeeTable = 0;
    }
    if (isset($_POST['bedroomHasBedside'])) {
        $bedroomHasBedside = $_POST['bedroomHasBedside'];
    } else {
        $bedroomHasBedside = 0;
    }
    if (isset($_POST['bedroomHasLamp'])) {
        $bedroomHasLamp = $_POST['bedroomHasLamp'];
    } else {
        $bedroomHasLamp = 0;
    }
    if (isset($_POST['bedroomHasCloset'])) {
        $bedroomHasCloset = $_POST['bedroomHasCloset'];
    } else {
        $bedroomHasCloset = 0;
    }
    if (isset($_POST['bedroomHasShelf'])) {
        $bedroomHasShelf = $_POST['bedroomHasShelf'];
    } else {
        $bedroomHasShelf = 0;
    }
    if (isset($_POST['handicapedAccessibility'])) {
        $handicapedAccessibility = $_POST['handicapedAccessibility'];
    } else {
        $handicapedAccessibility = 0;
    }
    if (isset($_POST['accomodationHasElevator'])) {
        $accomodationHasElevator = $_POST['accomodationHasElevator'];
    } else {
        $accomodationHasElevator = 0;
    }
    if (isset($_POST['accomodationHasCommonParkingLot'])) {
        $accomodationHasCommonParkingLot = $_POST['accomodationHasCommonParkingLot'];
    } else {
        $accomodationHasCommonParkingLot = 0;
    }
    if (isset($_POST['accomodationHasPrivateParkingPlace'])) {
        $accomodationHasPrivateParkingPlace = $_POST['accomodationHasPrivateParkingPlace'];
    } else {
        $accomodationHasPrivateParkingPlace = 0;
    }
    if (isset($_POST['accomodationHasGarden'])) {
        $accomodationHasGarden = $_POST['accomodationHasGarden'];
    } else {
        $accomodationHasGarden = 0;
    }
    if (isset($_POST['accomodationHasBalcony'])) {
        $accomodationHasBalcony = $_POST['accomodationHasBalcony'];
    } else {
        $accomodationHasBalcony = 0;
    }
    if (isset($_POST['accomodationHasTerrace'])) {
        $accomodationHasTerrace = $_POST['accomodationHasTerrace'];
    } else {
        $accomodationHasTerrace = 0;
    }
    if (isset($_POST['accomodationHasSwimmingPool'])) {
        $accomodationHasSwimmingPool = $_POST['accomodationHasSwimmingPool'];
    } else {
        $accomodationHasSwimmingPool = 0;
    }
    if (isset($_POST['accomodationHasTv'])) {
        $accomodationHasTv = $_POST['accomodationHasTv'];
    } else {
        $accomodationHasTv = 0;
    }
    if (isset($_POST['accomodationHasInternet'])) {
        $accomodationHasInternet = $_POST['accomodationHasInternet'];
    } else {
        $accomodationHasInternet = 0;
    }
    if (isset($_POST['accomodationHasWifi'])) {
        $accomodationHasWifi = $_POST['accomodationHasWifi'];
    } else {
        $accomodationHasWifi = 0;
    }
    if (isset($_POST['accomodationHasFiberOpticInternet'])) {
        $accomodationHasFiberOpticInternet = $_POST['accomodationHasFiberOpticInternet'];
    } else {
        $accomodationHasFiberOpticInternet = 0;
    }
    if (isset($_POST['accomodationHasNetflix'])) {
        $accomodationHasNetflix = $_POST['accomodationHasNetflix'];
    } else {
        $accomodationHasNetflix = 0;
    }
    if (isset($_POST['accomodationHasDoubleGlazing'])) {
        $accomodationHasDoubleGlazing = $_POST['accomodationHasDoubleGlazing'];
    } else {
        $accomodationHasDoubleGlazing = 0;
    }
    if (isset($_POST['accomodationHasAirConditioning'])) {
        $accomodationHasAirConditioning = $_POST['accomodationHasAirConditioning'];
    } else {
        $accomodationHasAirConditioning = 0;
    }
    if (isset($_POST['accomodationHasElectricHeating'])) {
        $accomodationHasElectricHeating = $_POST['accomodationHasElectricHeating'];
    } else {
        $accomodationHasElectricHeating = 0;
    }
    if (isset($_POST['accomodationHasIndividualGasHeating'])) {
        $accomodationHasIndividualGasHeating = $_POST['accomodationHasIndividualGasHeating'];
    } else {
        $accomodationHasIndividualGasHeating = 0;
    }
    if (isset($_POST['accomodationHasCollectiveGasHeating'])) {
        $accomodationHasCollectiveGasHeating = $_POST['accomodationHasCollectiveGasHeating'];
    } else {
        $accomodationHasCollectiveGasHeating = 0;
    }
    if (isset($_POST['accomodationHasHotWaterTank'])) {
        $accomodationHasHotWaterTank = $_POST['accomodationHasHotWaterTank'];
    } else {
        $accomodationHasHotWaterTank = 0;
    }
    if (isset($_POST['accomodationHasGasWaterHeater'])) {
        $accomodationHasGasWaterHeater = $_POST['accomodationHasGasWaterHeater'];
    } else {
        $accomodationHasGasWaterHeater = 0;
    }
    if (isset($_POST['accomodationHasFridge'])) {
        $accomodationHasFridge = $_POST['accomodationHasFridge'];
    } else {
        $accomodationHasFridge = 0;
    }
    if (isset($_POST['accomodationHasFreezer'])) {
        $accomodationHasFreezer = $_POST['accomodationHasFreezer'];
    } else {
        $accomodationHasFreezer = 0;
    }
    if (isset($_POST['accomodationHasOven'])) {
        $accomodationHasOven = $_POST['accomodationHasOven'];
    } else {
        $accomodationHasOven = 0;
    }
    if (isset($_POST['accomodationHasBakingTray'])) {
        $accomodationHasBakingTray = $_POST['accomodationHasBakingTray'];
    } else {
        $accomodationHasBakingTray = 0;
    }
    if (isset($_POST['accomodationHasWashingMachine'])) {
        $accomodationHasWashingMachine = $_POST['accomodationHasWashingMachine'];
    } else {
        $accomodationHasWashingMachine = 0;
    }
    if (isset($_POST['accomodationHasDishwasher'])) {
        $accomodationHasDishwasher = $_POST['accomodationHasDishwasher'];
    } else {
        $accomodationHasDishwasher = 0;
    }
    if (isset($_POST['accomodationHasMicrowaveOven'])) {
        $accomodationHasMicrowaveOven = $_POST['accomodationHasMicrowaveOven'];
    } else {
        $accomodationHasMicrowaveOven = 0;
    }
    if (isset($_POST['accomodationHasCoffeeMachine'])) {
        $accomodationHasCoffeeMachine = $_POST['accomodationHasCoffeeMachine'];
    } else {
        $accomodationHasCoffeeMachine = 0;
    }
    if (isset($_POST['accomodationHasPodCoffeeMachine'])) {
        $accomodationHasPodCoffeeMachine = $_POST['accomodationHasPodCoffeeMachine'];
    } else {
        $accomodationHasPodCoffeeMachine = 0;
    }
    if (isset($_POST['accomodationHasKettle'])) {
        $accomodationHasKettle = $_POST['accomodationHasKettle'];
    } else {
        $accomodationHasKettle = 0;
    }
    if (isset($_POST['accomodationHasToaster'])) {
        $accomodationHasToaster = $_POST['accomodationHasToaster'];
    } else {
        $accomodationHasToaster = 0;
    }
    if (isset($_POST['accomodationHasExtractorHood'])) {
        $accomodationHasExtractorHood = $_POST['accomodationHasExtractorHood'];
    } else {
        $accomodationHasExtractorHood = 0;
    }
    if (isset($_POST['animalsAllowed'])) {
        $animalsAllowed = $_POST['animalsAllowed'];
    } else {
        $animalsAllowed = 0;
    }
    if (isset($_POST['smokingIsAllowed'])) {
        $smokingIsAllowed = $_POST['smokingIsAllowed'];
    } else {
        $smokingIsAllowed = 0;
    }
    if (isset($_POST['authorizedParty'])) {
        $authorizedParty = $_POST['authorizedParty'];
    } else {
        $authorizedParty = 0;
    }
    if (isset($_POST['authorizedVisit'])) {
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
    if (isset($_POST['idealRoommateMinAge'])) {
        $idealRoommateMinAge = $_POST['idealRoommateMinAge'];
    }
    if (isset($_POST['idealRoommateMaxAge'])) {
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
        $fillingError['contactNameForVisit'] = 'Veuillez renseigner ce champ';
    }
    //contactPhoneNumberForVisit
    if (isset($_POST['contactPhoneNumberForVisit']) && !empty($_POST['contactPhoneNumberForVisit'])) {
        if (strlen($_POST['contactPhoneNumberForVisit'])>20) {
            $fillingError['contactPhoneNumberForVisit'] = '20 caractères maximum';
        } else {
            $contactPhoneNumberForVisit = $_POST['contactPhoneNumberForVisit'];
        }
    } else {
        $fillingError['contactPhoneNumberForVisit'] = 'Veuillez renseigner ce champ';
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
        $fillingError['contactMailForVisit'] = 'Veuillez renseigner ce champ';
    }
    //Résultat des contrôles
    if (!empty($fillingError)) {
        if (isset($_POST) && empty($_POST)) {
            header('Location:index.php?page=displayAddAnAdvertisement&error=pbTechnique');
            exit;
        }
        $_SESSION['fillingError'] = $fillingError;
        $_SESSION['postData'] = $_POST;
        if ($advertisementIdToModify) {
            header('Location:index.php?page=modifyAdvertisement&advertisementId='.$advertisementIdToModify);
        } else {
            header('Location:index.php?page=displayAddAnAdvertisement&error=fillingError');
        }
        exit;
    } else {
        if (isset($_SESSION['fillingError'])) {
            unset($_SESSION['fillingError']);
        }
        if (isset($_SESSION['postData'])) {
            unset($_SESSION['postData']);
        }
    }
    //Verification Titre identiques
    $titleVerification = getUserAdvertisementRegister($userId);
    $countTitle = 0;
    $advertisementIdWithSameTitle = "";
    foreach ($titleVerification as $key => $value) {
        if (strtolower($titleVerification[$key]['advertisement_title']) == strtolower($title)) {
            $countTitle++;
            $advertisementIdWithSameTitle = $titleVerification[$key]['advertisement_id'];
        }
    }
    if ($countTitle >= 1 && $advertisementIdToModify != $advertisementIdWithSameTitle && $advertisementIdToModify != null) {
        header('Location:index.php?page=modifyAdvertisement&advertisementId='.$advertisementIdToModify.'&error=title&title='.$title.'');
        exit;
    }
    if ($countTitle >= 1 && $advertisementIdToModify == null) {
        $_SESSION['postData'] = $_POST;
        header('Location:index.php?page=displayAddAnAdvertisement&error=title');
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
                    //On supprime les $_SESSIONS si existantes
                    if (isset($_SESSION['error'])) {
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['postData'])) {
                        unset($_SESSION['postData']);
                    }
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
                        $_SESSION['fileUploadEchec'] = 'Echec de l\'upload !';
                    }
                } else {
                    $_SESSION['postData'] = $_POST;
                    $_SESSION['error'] = array();
                    array_push($_SESSION['error'], $errors);
                    header("Location: index.php?page=displayAddAnAdvertisement&error=fillingError");
                    exit;
                }
            }
        }
    }
    //ENREGISTREMENT EN BASE DE DONNEE
    //AJOUT NOUVELLE ADRESSE
    if ($advertisementIdToModify) {
        //On récupère l'id de l'adresse à modifier
        $addressIdToModify = getAddressIdFromAdvertisement($advertisementIdToModify);
        modifyAddress($addressIdToModify, $addressStreet, $addressZipcode, $addressCity, $addressCountry);
    } else {
        if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
            //Recup l'id de la dernière addresse ajoutée en bdd
            $addressArray = getLastAddressId();
            $addressId = $addressArray['MAX(address_id)'];
        }
    }
    //AJOUT OU MODIFICATION ANNONCE
    if ($advertisementIdToModify) {
        if (saveModifyAdvertisementInBdd($isActive, $availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $otherRoommateSex, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressIdToModify, $advertisementIdToModify)) {
            $saveAdvertisement = true;
        } else {
            $saveAdvertisement = false;
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
                //Si on a bien récupéré l'id de l'annonce alors enregistrement photo en bdd
                if ($advertisementIdVerification) {
                    $advertisementId = $advertisementIdVerification['MAX(advertisement_id)'];
                }
            }
            //Si les photos ont bien été inséré en bdd alors on stocke dans la variable $_SESSION que l'annonce a bien été ajouté
            if (insertPictures($fileUpload, $advertisementId)) {
                if ($advertisementIdToModify) {
                    if ($_SESSION['isAdmin']) {
                        $message = 'L\'annonce a bien été modifiée';
                    } else {
                        $message = 'Votre annonce a bien été modifiée';
                    }
                } else {
                    $message = 'Votre nouvelle annonce a bien été ajoutée';
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
    if (verifyAdvertisementBelongsToUser($_SESSION['id'], $advertisementIdToDelete) || $_SESSION['isAdmin']==true) {
        
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
        //On récupère l'adress_id de l'annonce avant de la supprimer (peut servir pour suppression adresse)
        $addressId = getAddressIdFromAdvertisement($advertisementIdToDelete);
        //SI la demande vient d'un admin, on recupere l'id du user de l'annonce à supprimer
        if ($_SESSION['isAdmin']) {
            require_once('model/backEnd/m_getUsers.php');
            $userIdFromAdvertisementToDelete = getUserIdFromAdvertisementId($advertisementIdToDelete)['user_id'];
        }
        //SUPPRESSION ANNONCE
        if (deleteAdvertisementBdd($advertisementIdToDelete)) {
            //SUPPRESSION ADRESSE si l'adresse n'appartient à aucun utilisateur et aucune autre annonce
            //On vérifie si un user à cet address-id
            $usersWithAdvertisementAddressId = getUsersWithThisAddressId($addressId);
            if (!$usersWithAdvertisementAddressId) {
                //On verifie si une autre annonce à cet address_id
                $advertisementsWithSameAddressId = getAdvertisementsWithSameAddressId($addressId);
                if (empty($advertisementsWithSameAddressId)) {
                    //Si il y aucune annonce en retour, on supprime l'adresse
                    deleteAddressBdd($addressId);
                }
            }
            //Si la demande vient d'un admin
            if ($_SESSION['isAdmin']) {
                require_once('controller/backEnd/c_userAdvertisements.php');
                $message = 'L\'annonce a été supprimée';
                displayUserAdvertisements($userIdFromAdvertisementToDelete, null, $message);
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
