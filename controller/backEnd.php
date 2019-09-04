<?php
require_once('model/backEnd/modelBackEnd.php');

//Vérification login et mot de passe
function login()
{
    $login = getUser($_POST['login']);
    if ($login) {
        if (password_verify($_POST['password'], $login['user_password'])) {
            $_SESSION['login'] = $login['user_mail'];
            $_SESSION['id'] = $login['user_id'];
            $_SESSION['isAdmin'] = $login['user_isAdmin'];
        }
    }
}
//Affichage page d'accueil utilisateur connecté
function displayHomeUser()
{
    require_once('view/backEnd/displayHomeUser.php');
}
//Affichage Formulaire d'ajout d'une nouvelle annonce
function displayAddAnAdvertisementForm()
{
    require_once('view/backEnd/displayPostAnAdvertisement.php');
}
//Ajouter une nouvelle annonce
function addANewAdvertisement()
{
    //Boucle pour transformer les valeurs "on" en 1 (valeur vrai)
    foreach($_POST as $key => $value){
        if ($value === "on"){
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
    //Advertisement $_POST//Advertisement
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
    if (isset($_POST['energyClassLetter'])) {
        $energyClassLetter = $_POST['energyClassLetter'];
    }
    if (isset($_POST['energyClassNumber'])) {
        $energyClassNumber = $_POST['energyClassNumber'];
    }
    if (isset($_POST['gesLetter'])) {
        $gesLetter = $_POST['gesLetter'];
    }
    if (isset($_POST['gesNumber'])) {
        $gesNumber = $_POST['gesNumber'];
    }
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
    //Vérification si l'adresse existe déja
    $addressVerif = getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry);
    //Action (si l'adresse existe déja=>insertion annonce en base de donnée, sinon insertion addresse puis insertion annonce)
    if ($addressVerif) {
        $addressId = $addressVerif['address_id'];
        insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId);
    }else{
        if (insertNewAdress($addressStreet, $addressZipcode, $addressCity, $addressCountry)) {
            //Recup adress-id de l'annonce à ajouter
            $addressArray = getAddressId($addressStreet, $addressZipcode, $addressCity, $addressCountry);
            $addressId = $addressArray['address_id'];
            
            insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId);
        }
    }
    require_once('view/backEnd/displayHomeUser.php');
   
}













//VOYAGES TP
function displayTravelsConnected()
{
    $travels = getTravels();
    $pageEnCours="index";
    require('view/backEnd/displayTravelsConnected.php');
}
//VOAYGES TP
function displayAddTravel($message=null)
{
    $pageEnCours = "ajouter";
    require('view/backEnd/displayAddTravel.php');
}
//VOAYGES TP
function displayDeleteTravel()
{
    $pageEnCours = "supprimer";
    $insert = getTravelsName();
    require('view/backEnd/displayDeleteTravel.php');
}
//VOAYGES TP
function deleteTravel()
{
    $postTravelToDelete= $_POST['deleteTravel'];
    deleteTravelInBdd($postTravelToDelete);
    displayDeleteTravel();
}
//VOAYGES TP
function displayModifyTravel()
{
    $pageEnCours = "modifier";
    $insert = getTravelsName();
    require('view/backEnd/displayModifyTravel.php');
}
//VOAYGES TP
function displayModifyTravelOk()
{
    $pageEnCours = "modifier";
    $postTravelToModify= $_POST['modifyTravel'];
    $requestOk = (getTravel($postTravelToModify));
    require('view/backEnd/displayModifyTravel.php');
}
//VOAYGES TP
function modifyTravel()
{
    $id = $_GET['idTravel'];
    $title = $_POST['titleModify'];
    $content = $_POST['contentModify'];
    modifyTravelInBdd($title, $content, $id);
    displayModifyTravel();
}
//VOAYGES TP
function writeNewTravelInBdd()
{
    if (!empty($_FILES['image']['name'])) {
        $uploadPictureDir = 'public/images/';
        $namePictureTmp = $_FILES['image']['tmp_name'];
        $namePicture = uniqid().$_FILES['image']['name'];
        $extensions = array('png', 'gif', 'jpg', 'jpeg');
        if (uploadImage($namePictureTmp, $namePicture, $uploadPictureDir)) {
            if (insertNewTravel($_POST['title'], $_POST['content'], $namePicture)) {
                displayAddTravel('insertion Ok');
            }
        }
    } else {
        if (insertNewTravel($_POST['title'], $_POST['content'])) {
            displayAddTravel('insertion Ok');
        }
    }
}
