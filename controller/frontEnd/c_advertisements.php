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
function displayMyAdvertisements($error=null,$message=null)
{
    //Récupération annonces utilisateurs
    $userAdvertisements = getUserAdvertisement($_SESSION['id']);
    //Mise en tableau des id des annonces de l'utilisateur
    $advertisementIdArray = array();
    foreach ($userAdvertisements as $key => $value) {
        array_push($advertisementIdArray, $userAdvertisements[$key]['advertisement_id']);
    }
    //Récupération de la photo Order 1 de chaque annonce
    $pictureFilename = array();
    foreach ($advertisementIdArray as $key => $value) {
        $pictureFilename[$value] =getAdvertisementPictureOrder1($value);
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
function displayMofifyAdvertisementForm()
{
    //On récupère l'id de l'annonce à modifier
    $advertisementId = $_GET['advertisementId'];
    //On verifie si l'id de l'annonce($_GET['advertisementId]) appartient bien à l'utilisateur connecté
    $advertisementVerification = verifyAdvertisementBelongsToUser($_SESSION['id'],$advertisementId);
    if ($advertisementVerification){
        //On récupère les données de l'annonce et de l'adresse liée à l'annonce
        $advertisementData = getAdvertisementWithAddress($advertisementId);
        //On récupère les photos liées à l'annonce
        $advertisementPicture = getAdvertisementPictures($advertisementId);
        //On prépare une variable avec un lien pour bouton supprimer photos
        $deletePictureUrl = 'index.php?page=saveModificationAdvertisementDeletePicture&idAdvertisement='.$advertisementId.'';
        //On définit le chemin ou sont enregistrer les photos
        $picturePath = "public/pictures/users/";
    
        require_once('view/frontEndUserConnected/v_advertisementModifyForm.php');
    }else{
        $error = "Erreur";
        require_once('view/frontEnd/v_error.php');
    }
}

//Traitement enregistrement nouvelle annonce ou modification annonce en base de donnée
function saveNewOrModifyAdvertisement(){
    //Nous permet de savoir si il faut modifier une annonce ou en créer une nouvelle
    if (isset($_POST['id'])){
        $advertisementIdToModify = $_POST['id'];
    }else{
        $advertisementIdToModify = null;
    }
    
    //Boucle pour transformer les valeurs "on" en 1 (valeur vrai) des checkbox cochées
    foreach ($_POST as $key => $value) {
        if ($value === "on") {
            $_POST[$key] = 1;
        }
    }
    //Address $_POST
    if (isset($_POST['street'])) {
        $addressStreet = $_POST['street'];
    }
    if (isset($_POST['zipcode'])) {
        $addressZipcode = $_POST['zipcode'];
    }
    if (isset($_POST['city'])) {
        $addressCity = $_POST['city'];
    }
    if (isset($_POST['country'])) {
        $addressCountry = $_POST['country'];
    }

    //Advertisement $_POST
    if (isset($_POST['isActive'])) {
        $isActive = $_POST['isActive'];
    } else {
        $isActive = 0;
    }
    if (isset($_POST['availableDate'])) {
        $availableDate = $_POST['availableDate'];
    }
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    }
    if (isset($_POST['description'])) {
        $description = $_POST['description'];
    }
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    }
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    }
    if (isset($_POST['energyClassNumber'])) {
        $energyClassNumber = $_POST['energyClassNumber'];
    }
    
    $energyClassLetter = calculEnergyLetter($energyClassNumber);
    
    if (isset($_POST['gesNumber'])) {
        $gesNumber = $_POST['gesNumber'];
    }
    
    $gesLetter = calculGesLetter($gesNumber);
    
    if (isset($_POST['accomodationLivingAreaSize'])) {
        $accomodationLivingAreaSize = $_POST['accomodationLivingAreaSize'];
    }
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
    if (isset($_POST['monthlyRentExcludingCharges'])) {
        $monthlyRentExcludingCharges = $_POST['monthlyRentExcludingCharges'];
    }
    if (isset($_POST['charges'])) {
        $charges = $_POST['charges'];
    }
    if (isset($_POST['suretyBond'])) {
        $suretyBond = $_POST['suretyBond'];
    }
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
    if (isset($_POST['bedroomSize'])) {
        $bedroomSize = $_POST['bedroomSize'];
    }
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
    if (isset($_POST['contactNameForVisit'])) {
        $contactNameForVisit = $_POST['contactNameForVisit'];
    }
    if (isset($_POST['contactPhoneNumberForVisit'])) {
        $contactPhoneNumberForVisit = $_POST['contactPhoneNumberForVisit'];
    }
    if (isset($_POST['contactMailForVisit'])) {
        $contactMailForVisit = $_POST['contactMailForVisit'];
    }
    
    //Réorganisation du tableau $_FILES
    $filesArray = reArrayFiles($_FILES);

    //On verifie s'il y a des photos dans le tableau $filesArray
    if (!empty($filesArray[0]['name'])) {
        //Définition constante
        define("UPLOAD_REP_PHOTO", "public/pictures/users/");
        define("UPLOAD_SIZEMAX_PHOTO", 10000000); // La taille, en octets.
        define("UPLOAD_EXTENSION_PHOTO", "jpg,jpeg,png,gif");
        define("UPLOAD_MIMETYPE_PHOTO", "image/jpeg,image/png,image/gif");
            
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
                // Récupère l'extension d'un fichier
                $splFileInfo = new SplFileInfo($namePicture);
                $fileExtension = strtolower($splFileInfo->getExtension());
                    
                //Verification nombre de pixels png
                $pixelImage = getimagesize($namePictureTmp);
                if ($pixelImage[0]*$pixelImage[1]>1000000 && $fileExtension == 'png') {
                    $errors['pixel_err'] = "L'image png sera déformée";
                }
        
                // Récupère le type mime du fichier
                $fileMimeType = mime_content_type($namePictureTmp);
                    
                // On vérifie la taille, en octets, du fichier téléchargé
                if ($filesArray[$i]['size'] > UPLOAD_SIZEMAX_PHOTO) {
                    $errors['size'] = 'Taille de fichier supérieure à la taille maxi autorisée';
                }
                    
                // On vérifie l'extension
                if (!in_array($fileExtension, explode(',', constant('UPLOAD_EXTENSION_PHOTO')))) {
                    $errors['ext'] = 'L\'extension ne correspond pas aux extensions acceptées';
                }
                    
                // On vérifie le type mime
                if (!in_array($fileMimeType, explode(',', constant('UPLOAD_MIMETYPE_PHOTO')))) {
                    $errors['ext'] = 'L\'extension ne correspond pas aux extensions acceptées';
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
                        if ($pictureSize>1000000) {
                            if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
                                $img = imagecreatefromjpeg(UPLOAD_REP_PHOTO . $namePicture);
                                imagejpeg($img, UPLOAD_REP_PHOTO . $namePicture, $quality);
                                imagedestroy($img);
                            } elseif ($fileExtension == 'png') {
                                $pngQuality = ($quality - 100) / 11.111111;
                                $pngQuality = round(abs($pngQuality));
                                echo $pngQuality;
                                ini_set('memory_limit', '-1');
                                $img = imagecreatefrompng(UPLOAD_REP_PHOTO . $namePicture);
                                imagepng($img, UPLOAD_REP_PHOTO . $namePicture, 0, 9);
                                imagedestroy($img);
                            } elseif ($fileExtension == 'gif') {
                                $img = imagecreatefromgif(UPLOAD_REP_PHOTO . $namePicture);
                                imagegif($img, UPLOAD_REP_PHOTO . $namePicture, $quality);
                                imagedestroy($img);
                            }
                        }
                        $_SESSION['fileUploadSuccess'][$i] = 'Upload effectué avec succès !';
                        //Enregistrement nom de la photo dans tableau pour ensuite enregistrer en bdd
                        $fileUpload[$i] = $namePicture;
                    } else {
                        $_SESSION['fileUploadEchec'] = 'Echec de l\'upload !';
                    }
                } else {
                    $_SESSION['error'] = array();
                    array_push($_SESSION['error'], $errors);
                    // header("Location: index.php?page=errorNewAdvertisement");
                }
            }
        }
    }

    //ENREGISTREMENT EN BASE DE DONNEE

    //Vérification si l'adresse postale renseignée existe déja et si oui renvoi l'id
    $addressVerification = getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry);
    
    //Enregistrement annonce en bdd, si l'adresse existe déja ($addressVerification contient un id)
    if ($addressVerification) {
        $addressId = $addressVerification['address_id'];
        //On enregistre l'annonce selon si c'est une nouvelle annonce ou une modificatio
        if ($advertisementIdToModify) {
            if (saveModifyAdvertisementInBdd($isActive, $availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId, $advertisementIdToModify)) {
                $saveAdvertisement = true;
            } else {
                $saveAdvertisement = false;
            }
        } else {
            if (insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId)) {
                $saveAdvertisement = true;
            } else {
                $saveAdvertisement = false;
            }
        }
        //Vérification présence photos et enregistrement en bdd, Si l'annonce a bien été enregistré
        if ($saveAdvertisement) {

            //SUPPRESSION PHOTOS (page modification annonce)
            if (isset($_POST['pictureToDelete'])){
                foreach($_POST['pictureToDelete'] as $key => $value){
                    deleteOnePicture($advertisementIdToModify,$value);        
                    unlink('public/pictures/users/'.$value.'');
                }
                reorganizePictureOrder($advertisementIdToModify);
            }

            //AJOUT NOUVELLES PHOTOS
            //On recupére id de l'annonce pour laquelle on veut ajouter les photos
            if (!empty($fileUpload)) {
                if ($advertisementIdToModify) {
                    //On récupère l'id de l'annonce qui a été passée en argument en appel à cette fonction
                    $advertisementId = $advertisementIdToModify;
                } else {
                    //On récupère l'id de la derniere annonce
                    $advertisementIdVerification = getLastAdvertisementId();
                    //Si on a bien récupéré l'id de l'annonce alors enregistrement photo en bdd
                    if ($advertisementIdVerification) {
                        $advertisementId = $advertisementIdVerification['MAX(advertisement_id)'];
                    }
                }
                //Si les photos ont bien été inséré en bdd alors on stocke dans la variable $_SESSION que l'annonce a bien été ajouté
                if (insertPictures($fileUpload, $advertisementId)) {
                    if($advertisementIdToModify){
                        $message = 'Votre annonce a bien été modifiée';
                    }else{
                        $message = 'Votre nouvelle annonce a bien été ajoutée';
                    }
                } else {
                    $error ='Aucune annonce ne correspond pour vos photos!';
                }
            }else{
                if($advertisementIdToModify){
                    $message = 'Votre annonce a bien été modifiée';
                }else{
                    $message = 'Votre nouvelle annonce a bien été ajoutée';
                }
            }
        } else {
            $error = 'Problème technique. Veuillez réessayer ultérieurement';
        }
    } else {
        //AJOUT ADRESSE
        //AJOUT NOUVELLE ADRESSE
        //Si l'adresse a bien été ajouté en bdd alors on ajoute l'annonce
        if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
            //Recup l'id de la dernière addresse ajoutée en bdd
            $addressArray = getLastAddressId();
            $addressId = $addressArray['MAX(address_id)'];

            //AJOUT OU MODIFICATION ANNONCE
            if ($advertisementIdToModify){
                if(saveModifyAdvertisementInBdd($isActive, $availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId, $advertisementIdToModify)){
                    $saveAdvertisement = true;
                }else{
                    $saveAdvertisement = false;
                }
            }else{
                if(insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId)){
                    $saveAdvertisement = true;
                }else{
                    $saveAdvertisement = false;
                }
            }
            //Si l'annonce a bien été enregistré alors vérification s'il y a des photos
            if ($saveAdvertisement) {

                //SUPPRESSION PHOTOS (page modification annonce)
                if (isset($_POST['pictureToDelete'])){
                    foreach($_POST['pictureToDelete'] as $key => $value){
                        deleteOnePicture($advertisementIdToModify,$value);
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
                        $advertisementIdVerification = getLastAdvertisementId();
                        //Si on a bien récupéré l'id de l'annonce alors enregistrement photo en bdd
                        if ($advertisementIdVerification) {
                            $advertisementId = $advertisementIdVerification['MAX(advertisement_id)'];
                        }
                    }
                    //Si les photos ont bien été inséré en bdd alors on stocke dans la variable $_SESSION que l'annonce a bien été ajouté
                    if (insertPictures($fileUpload, $advertisementId)) {
                        if($advertisementIdToModify){
                            $message = 'Votre annonce a bien été modifiée';
                        }else{
                            $message = 'Votre nouvelle annonce a bien été ajoutée';
                        }
                    } else {
                        $error ='Aucune annonce ne correspond pour vos photos!';                    }
                }else{
                    if($advertisementIdToModify){
                        $message = 'Votre annonce a bien été modifiée';
                    }else{
                        $message = 'Votre nouvelle annonce a bien été ajoutée';
                    }
                }
            } else {
                $error = 'Problème technique. Veuillez réessayer ultérieurement';
            }
        } else {
            $error = 'Problème technique. Veuillez réessayer ultérieurement';
        }
    }
    //Appel de la fonction pour afficher la liste des annonces de l'utilisateur en passant en argument les messages d'erreur ou de confirmation
    if(isset($error)){
        displayMyAdvertisements($error);
    }else if (isset($message)){
        displayMyAdvertisements(null,$message);
    }else{
        displayMyAdvertisements();
    }
}

//Supprime une annonce
function deleteAdvertisement($advertisementIdToDelete){
    //On vérifie si l'annonce qui doit etre supprimée appartient à l'utilisateur connecté
    if (verifyAdvertisementBelongsToUser($_SESSION['id'], $advertisementIdToDelete)) {
        
        //SUPPRESSION PHOTOS
        $picturesRequest = getAdvertisementPictures($advertisementIdToDelete);
        if(!empty($picturesRequest)){
            //On supprime toutes les photos liées à l'annonce dans la base de donnée
            deletePictureBdd($advertisementIdToDelete);
            //On supprime les photos du dossier public/pictures/users
            foreach($picturesRequest as $key => $value){
                unlink('public/pictures/users/'.$picturesRequest[$key]['picture_fileName'].'');
            }
        }
        //On récupère l'adress_id de l'annonce avant de la supprimer (peut servir pour suppression adresse)
        $addressId = getAddressIdFromAdvertisement($advertisementIdToDelete);
        
        //SUPPRESSION ANNONCE
        if(deleteAdvertisementBdd($advertisementIdToDelete)){

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
            //On appelle la fonction qui affiche la page "mes annonces"
            $message = 'Votre annonce a été supprimée.';
            displayMyAdvertisements(null,$message);
        }else{
            $error = "Problème technique. Veuillez réessayer ultérieurement.";
            displayMyAdvertisements($error);
        }
    } else {
        //Sinon l'annonce n'appartient pas à l'utilisateur connecté
        $error = "Problème technique.";
        displayMyAdvertisements($error);
    }
}

//Traitement enregistrement suppression photos dans modification annonce en base de donnée
// function saveModificationAdvertisementDeletePicture(){
//     $advertisementId = $_GET['idAdvertisement'];
//     if(!empty($_POST)){
//         foreach($_POST['picture'] as $key => $value){
//             deleteOnePicture($advertisementId,$_POST['picture'][$key]);
//         }
//     }
//     header('Location:index.php?page=modifyAdvertisement&advertisementId='.$advertisementId.'#modifyAdvertisementDeletePictureForm');
// }