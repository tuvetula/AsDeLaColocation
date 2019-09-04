<?php
require_once('model/bdd/bddConfig.php');

//Vérifie si le login existe en base de donnée
function getUser($postLogin)
{
    $postLogin = htmlentities(strip_tags($postLogin));
    $db = connectBdd();
    $answer = $db->prepare('SELECT * FROM users WHERE user_mail=:login');
    $answer->execute([
        ':login' => $postLogin
    ]);
    return $answer->fetch();
}

//Ajoute une nouvelle adresse
function insertNewAdress($addressStreet,$addressZipcode,$addressCity,$addressCountry){
    $addressStreet = htmlentities(strip_tags($addressStreet));
    $addressZipcode = htmlentities(strip_tags($addressZipcode));
    $addressCity = htmlentities(strip_tags($addressCity));
    $addressCountry = htmlentities(strip_tags($addressCountry));
    $db = connectBdd();
    $insertAddress = $db->prepare('INSERT INTO addresses (address_street,address_zipcode,address_city,address_country) VALUES (:addressStreet,:addressZipcode,:addressCity,:addressCountry)');
    $insertAddress->execute(array(
        ':addressStreet'=>$addressStreet,
        ':addressZipcode'=>$addressZipcode,
        ':addressCity'=>$addressCity,
        ':addressCountry'=>$addressCountry
    ));
    return true;
}

//Récupére adresse_id si le nom de la rue, le code postal, la ville et le pays correspondent.
function getAddressId($addressStreet,$addressZipcode,$addressCity,$addressCountry){
    $db = connectBdd();
    $request = $db->query('SELECT address_id FROM addresses 
    WHERE address_street="'.$addressStreet.'" 
    AND address_zipcode="'.$addressZipcode.'" 
    AND address_city="'.$addressCity.'" 
    AND address_country="'.$addressCountry.'"');
    $requestOk = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $requestOk;
}

//Ajoute une nouvelle annonce en base de données
function insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId)
{
    $isActive = 0;
    $dateOfLastDiffusion = null;
    $availableDate = htmlentities(strip_tags($availableDate));
    $title = htmlentities(strip_tags($title));
    $description = htmlentities(strip_tags($description));
    $type = htmlentities(strip_tags($type));
    $category = htmlentities(strip_tags($category));
    $energyClassLetter = htmlentities(strip_tags($energyClassLetter));
    $energyClassNumber = htmlentities(strip_tags($energyClassNumber));
    $gesLetter = htmlentities(strip_tags($gesLetter));
    $gesNumber = htmlentities(strip_tags($gesNumber));
    $accomodationLivingAreaSize = htmlentities(strip_tags($accomodationLivingAreaSize));
    $accomodationFloor = htmlentities(strip_tags($accomodationFloor));
    $buildingNbOfFloors = htmlentities(strip_tags($buildingNbOfFloors));
    $accomodationNbOfRooms = htmlentities(strip_tags($accomodationNbOfRooms));
    $accomodationNbOfBedrooms = htmlentities(strip_tags($accomodationNbOfBedrooms));
    $accomodationNbOfBathrooms = htmlentities(strip_tags($accomodationNbOfBathrooms));
    $nbOfBedroomsToRent = htmlentities(strip_tags($nbOfBedroomsToRent));
    $monthlyRentExcludingCharges = htmlentities(strip_tags($monthlyRentExcludingCharges));
    $charges = htmlentities(strip_tags($charges));
    $suretyBond = htmlentities(strip_tags($suretyBond));
    $financialRequirements = htmlentities(strip_tags($financialRequirements));
    $guarantorLiving = htmlentities(strip_tags($guarantorLiving));
    $solvencyRatio = htmlentities(strip_tags($solvencyRatio));
    $eligibleForAids = htmlentities(strip_tags($eligibleForAids));
    $chargesIncludeCoOwnershipCharges = htmlentities(strip_tags($chargesIncludeCoOwnershipCharges));
    $chargesIncludeElectricity = htmlentities(strip_tags($chargesIncludeElectricity));
    $chargesIncludeHotWater = htmlentities(strip_tags($chargesIncludeHotWater));
    $chargesIncludeHeating = htmlentities(strip_tags($chargesIncludeHeating));
    $chargesIncludeInternet = htmlentities(strip_tags($chargesIncludeInternet));
    $chargesIncludeHomeInsurance = htmlentities(strip_tags($chargesIncludeHomeInsurance));
    $chargesIncludeBoilerInspection = htmlentities(strip_tags($chargesIncludeBoilerInspection));
    $chargesIncludeHouseholdGarbageTaxes = htmlentities(strip_tags($chargesIncludeHouseholdGarbageTaxes));
    $chargesIncludeCleaningService = htmlentities(strip_tags($chargesIncludeCleaningService));
    $isFurnished = htmlentities(strip_tags($isFurnished));
    $kitchenUse = htmlentities(strip_tags($kitchenUse));
    $livingRoomUse = htmlentities(strip_tags($livingRoomUse));
    $bedroomSize = htmlentities(strip_tags($bedroomSize));
    $bedroomType = htmlentities(strip_tags($bedroomType));
    $bedType = htmlentities(strip_tags($bedType));
    $bedroomHasDesk = htmlentities(strip_tags($bedroomHasDesk));
    $bedroomHasWardrobe = htmlentities(strip_tags($bedroomHasWardrobe));
    $bedroomHasChair = htmlentities(strip_tags($bedroomHasChair));
    $bedroomHasTv = htmlentities(strip_tags($bedroomHasTv));
    $bedroomHasArmchair = htmlentities(strip_tags($bedroomHasArmchair));
    $bedroomHasCoffeeTable = htmlentities(strip_tags($bedroomHasCoffeeTable));
    $bedroomHasBedside = htmlentities(strip_tags($bedroomHasBedside));
    $bedroomHasLamp = htmlentities(strip_tags($bedroomHasLamp));
    $bedroomHasCloset = htmlentities(strip_tags($bedroomHasCloset));
    $bedroomHasShelf = htmlentities(strip_tags($bedroomHasShelf));
    $handicapedAccessibility = htmlentities(strip_tags($handicapedAccessibility));
    $accomodationHasElevator = htmlentities(strip_tags($accomodationHasElevator));
    $accomodationHasCommonParkingLot = htmlentities(strip_tags($accomodationHasCommonParkingLot));
    $accomodationHasPrivateParkingPlace = htmlentities(strip_tags($accomodationHasPrivateParkingPlace));
    $accomodationHasGarden = htmlentities(strip_tags($accomodationHasGarden));
    $accomodationHasBalcony = htmlentities(strip_tags($accomodationHasBalcony));
    $accomodationHasTerrace = htmlentities(strip_tags($accomodationHasTerrace));
    $accomodationHasSwimmingPool = htmlentities(strip_tags($accomodationHasSwimmingPool));
    $accomodationHasTv = htmlentities(strip_tags($accomodationHasTv));
    $accomodationHasInternet = htmlentities(strip_tags($accomodationHasInternet));
    $accomodationHasWifi = htmlentities(strip_tags($accomodationHasWifi));
    $accomodationHasFiberOpticInternet = htmlentities(strip_tags($accomodationHasFiberOpticInternet));
    $accomodationHasNetflix = htmlentities(strip_tags($accomodationHasNetflix));
    $accomodationHasDoubleGlazing = htmlentities(strip_tags($accomodationHasDoubleGlazing));
    $accomodationHasAirConditioning = htmlentities(strip_tags($accomodationHasAirConditioning));
    $accomodationHasElectricHeating = htmlentities(strip_tags($accomodationHasElectricHeating));
    $accomodationHasIndividualGasHeating = htmlentities(strip_tags($accomodationHasIndividualGasHeating));
    $accomodationHasCollectiveGasHeating = htmlentities(strip_tags($accomodationHasCollectiveGasHeating));
    $accomodationHasHotWaterTank = htmlentities(strip_tags($accomodationHasHotWaterTank));
    $accomodationHasGasWaterHeater = htmlentities(strip_tags($accomodationHasGasWaterHeater));
    $accomodationHasFridge = htmlentities(strip_tags($accomodationHasFridge));
    $accomodationHasFreezer = htmlentities(strip_tags($accomodationHasFreezer));
    $accomodationHasOven = htmlentities(strip_tags($accomodationHasOven));
    $accomodationHasBakingTray = htmlentities(strip_tags($accomodationHasBakingTray));
    $accomodationHasWashingMachine = htmlentities(strip_tags($accomodationHasWashingMachine));
    $accomodationHasDishwasher = htmlentities(strip_tags($accomodationHasDishwasher));
    $accomodationHasMicrowaveOven = htmlentities(strip_tags($accomodationHasMicrowaveOven));
    $accomodationHasCoffeeMachine = htmlentities(strip_tags($accomodationHasCoffeeMachine));
    $accomodationHasPodCoffeeMachine = htmlentities(strip_tags($accomodationHasPodCoffeeMachine));
    $accomodationHasKettle = htmlentities(strip_tags($accomodationHasKettle));
    $accomodationHasToaster = htmlentities(strip_tags($accomodationHasToaster));
    $accomodationHasExtractorHood = htmlentities(strip_tags($accomodationHasExtractorHood));
    $animalsAllowed = htmlentities(strip_tags($animalsAllowed));
    $smokingIsAllowed = htmlentities(strip_tags($smokingIsAllowed));
    $authorizedParty = htmlentities(strip_tags($authorizedParty));
    $authorizedVisit = htmlentities(strip_tags($authorizedVisit));
    $nbOfOtherRoommatePresent = htmlentities(strip_tags($nbOfOtherRoommatePresent));
    $renterSituation = htmlentities(strip_tags($renterSituation));
    $idealRoommateSex = htmlentities(strip_tags($idealRoommateSex));
    $idealRoommateSituation = htmlentities(strip_tags($idealRoommateSituation));
    $idealRoommateMinAge = htmlentities(strip_tags($idealRoommateMinAge));
    $idealRoommateMaxAge = htmlentities(strip_tags($idealRoommateMaxAge));
    $locationMinDuration = htmlentities(strip_tags($locationMinDuration));
    $rentWithoutVisit = htmlentities(strip_tags($rentWithoutVisit));
    $contactNameForVisit = htmlentities(strip_tags($contactNameForVisit));
    $contactPhoneNumberForVisit = htmlentities(strip_tags($contactPhoneNumberForVisit));
    $contactMailForVisit = htmlentities(strip_tags($contactMailForVisit));
    $addressId = htmlentities(strip_tags($addressId));
    $userId = htmlentities(strip_tags($_SESSION['id']));
    
    $db = connectBdd();
    $insert = $db->prepare('INSERT INTO advertisements (
    advertisement_isActive,
    advertisement_dateOfLastDiffusion,
    advertisement_availableDate,
    advertisement_title,
    advertisement_description,
    advertisement_type,
    advertisement_category,
    advertisement_energyClassLetter,
    advertisement_energyClassNumber,
    advertisement_gesLetter,
    advertisement_gesNumber,
    advertisement_accomodationLivingAreaSize,
    advertisement_accomodationFloor,
    advertisement_buildingNbOfFloors,
    advertisement_accomodationNbOfRooms,
    advertisement_accomodationNbOfBedrooms,
    advertisement_accomodationNbOfBathrooms,
    advertisement_nbOfBedroomsToRent,
    advertisement_monthlyRentExcludingCharges,
    advertisement_charges,
    advertisement_suretyBond,
    advertisement_financialRequirements,
    advertisement_guarantorLiving,
    advertisement_solvencyRatio,
    advertisement_eligibleForAids,
    advertisement_chargesIncludeCoOwnershipCharges,
    advertisement_chargesIncludeElectricity,
    advertisement_chargesIncludeHotWater,
    advertisement_chargesIncludeHeating,
    advertisement_chargesIncludeInternet,
    advertisement_chargesIncludeHomeInsurance,
    advertisement_chargesIncludeBoilerInspection,
    advertisement_chargesIncludeHouseholdGarbageTaxes,
    advertisement_chargesIncludeCleaningService,
    advertisement_isFurnished,
    advertisement_kitchenUse,
    advertisement_livingRoomUse,
    advertisement_bedroomSize,
    advertisement_bedroomType,
    advertisement_bedType,
    advertisement_bedroomHasDesk,
    advertisement_bedroomHasWardrobe,
    advertisement_bedroomHasChair,
    advertisement_bedroomHasTv,
    advertisement_bedroomHasArmchair,
    advertisement_bedroomHasCoffeeTable,
    advertisement_bedroomHasBedside,
    advertisement_bedroomHasLamp,
    advertisement_bedroomHasCloset,
    advertisement_bedroomHasShelf,
    advertisement_handicapedAccessibility,
    advertisement_accomodationHasElevator,
    advertisement_accomodationHasCommonParkingLot,
    advertisement_accomodationHasPrivateParkingPlace,
    advertisement_accomodationHasGarden,
    advertisement_accomodationHasBalcony,
    advertisement_accomodationHasTerrace,
    advertisement_accomodationHasSwimmingPool,
    advertisement_accomodationHasTv,
    advertisement_accomodationHasInternet,
    advertisement_accomodationHasWifi,
    advertisement_accomodationHasFiberOpticInternet,
    advertisement_accomodationHasNetflix,
    advertisement_accomodationHasDoubleGlazing,
    advertisement_accomodationHasAirConditioning,
    advertisement_accomodationHasElectricHeating,
    advertisement_accomodationHasIndividualGasHeating,
    advertisement_accomodationHasCollectiveGasHeating,
    advertisement_accomodationHasHotWaterTank,
    advertisement_accomodationHasGasWaterHeater,
    advertisement_accomodationHasFridge,
    advertisement_accomodationHasFreezer,
    advertisement_accomodationHasOven,
    advertisement_accomodationHasBakingTray,
    advertisement_accomodationHasWashingMachine,
    advertisement_accomodationHasDishwasher,
    advertisement_accomodationHasMicrowaveOven,
    advertisement_accomodationHasCoffeeMachine,
    advertisement_accomodationHasPodCoffeeMachine,
    advertisement_accomodationHasKettle,
    advertisement_accomodationHasToaster,
    advertisement_accomodationHasExtractorHood,
    advertisement_animalsAllowed,
    advertisement_smokingIsAllowed,
    advertisement_authorizedParty,
    advertisement_authorizedVisit,
    advertisement_nbOfOtherRoommatePresent,
    advertisement_renterSituation,
    advertisement_idealRoommateSex,
    advertisement_idealRoommateSituation,
    advertisement_idealRoommateMinAge,
    advertisement_idealRoommateMaxAge,
    advertisement_locationMinDuration,
    advertisement_rentWithoutVisit,
    advertisement_contactNameForVisit,
    advertisement_contactPhoneNumberForVisit,
    advertisement_contactMailForVisit,
    address_id,
    user_id
    ) VALUES (
    :isActive,
    :dateOfLastDiffusion,
    :availableDate,
    :title,
    :description,
    :type,
    :category,
    :energyClassLetter,
    :energyClassNumber,
    :gesLetter,
    :gesNumber,
    :accomodationLivingAreaSize,
    :accomodationFloor,
    :buildingNbOfFloors,
    :accomodationNbOfRooms,
    :accomodationNbOfBedrooms,
    :accomodationNbOfBathrooms,
    :nbOfBedroomsToRent,
    :monthlyRentExcludingCharges,
    :charges,
    :suretyBond,
    :financialRequirements,
    :guarantorLiving,
    :solvencyRatio,
    :eligibleForAids,
    :chargesIncludeCoOwnershipCharges,
    :chargesIncludeElectricity,
    :chargesIncludeHotWater,
    :chargesIncludeHeating,
    :chargesIncludeInternet,
    :chargesIncludeHomeInsurance,
    :chargesIncludeBoilerInspection,
    :chargesIncludeHouseholdGarbageTaxes,
    :chargesIncludeCleaningService,
    :isFurnished,
    :kitchenUse,
    :livingRoomUse,
    :bedroomSize,
    :bedroomType,
    :bedType,
    :bedroomHasDesk,
    :bedroomHasWardrobe,
    :bedroomHasChair,
    :bedroomHasTv,
    :bedroomHasArmchair,
    :bedroomHasCoffeeTable,
    :bedroomHasBedside,
    :bedroomHasLamp,
    :bedroomHasCloset,
    :bedroomHasShelf,
    :handicapedAccessibility,
    :accomodationHasElevator,
    :accomodationHasCommonParkingLot,
    :accomodationHasPrivateParkingPlace,
    :accomodationHasGarden,
    :accomodationHasBalcony,
    :accomodationHasTerrace,
    :accomodationHasSwimmingPool,
    :accomodationHasTv,
    :accomodationHasInternet,
    :accomodationHasWifi,
    :accomodationHasFiberOpticInternet,
    :accomodationHasNetflix,
    :accomodationHasDoubleGlazing,
    :accomodationHasAirConditioning,
    :accomodationHasElectricHeating,
    :accomodationHasIndividualGasHeating,
    :accomodationHasCollectiveGasHeating,
    :accomodationHasHotWaterTank,
    :accomodationHasGasWaterHeater,
    :accomodationHasFridge,
    :accomodationHasFreezer,
    :accomodationHasOven,
    :accomodationHasBakingTray,
    :accomodationHasWashingMachine,
    :accomodationHasDishwasher,
    :accomodationHasMicrowaveOven,
    :accomodationHasCoffeeMachine,
    :accomodationHasPodCoffeeMachine,
    :accomodationHasKettle,
    :accomodationHasToaster,
    :accomodationHasExtractorHood,
    :animalsAllowed,
    :smokingIsAllowed,
    :authorizedParty,
    :authorizedVisit,
    :nbOfOtherRoommatePresent,
    :renterSituation,
    :idealRoommateSex,
    :idealRoommateSituation,
    :idealRoommateMinAge,
    :idealRoommateMaxAge,
    :locationMinDuration,
    :rentWithoutVisit,
    :contactNameForVisit,
    :contactPhoneNumberForVisit,
    :contactMailForVisit,
    :addressId,
    :userId
    )');
    $insert->execute(array(
    ':isActive'=> $isActive,
    ':dateOfLastDiffusion'=> $dateOfLastDiffusion,
    ':availableDate'=> $availableDate,
    ':title'=> $title,
    ':description'=> $description,
    ':type'=> $type,
    ':category'=> $category,
    ':energyClassLetter'=> $energyClassLetter,
    ':energyClassNumber'=> $energyClassNumber,
    ':gesLetter'=> $gesLetter,
    ':gesNumber'=> $gesNumber,
    ':accomodationLivingAreaSize'=> $accomodationLivingAreaSize,
    ':accomodationFloor'=> $accomodationFloor,
    ':buildingNbOfFloors'=> $buildingNbOfFloors,
    ':accomodationNbOfRooms'=> $accomodationNbOfRooms,
    ':accomodationNbOfBedrooms'=> $accomodationNbOfBedrooms,
    ':accomodationNbOfBathrooms'=> $accomodationNbOfBathrooms,
    ':nbOfBedroomsToRent'=> $nbOfBedroomsToRent,
    ':monthlyRentExcludingCharges'=> $monthlyRentExcludingCharges,
    ':charges'=> $charges,
    ':suretyBond'=> $suretyBond,
    ':financialRequirements'=> $financialRequirements,
    ':guarantorLiving'=> $guarantorLiving,
    ':solvencyRatio'=> $solvencyRatio,
    ':eligibleForAids'=> $eligibleForAids,
    ':chargesIncludeCoOwnershipCharges'=> $chargesIncludeCoOwnershipCharges,
    ':chargesIncludeElectricity'=> $chargesIncludeElectricity,
    ':chargesIncludeHotWater'=> $chargesIncludeHotWater,
    ':chargesIncludeHeating'=> $chargesIncludeHeating,
    ':chargesIncludeInternet'=> $chargesIncludeInternet,
    ':chargesIncludeHomeInsurance'=> $chargesIncludeHomeInsurance,
    ':chargesIncludeBoilerInspection'=> $chargesIncludeBoilerInspection,
    ':chargesIncludeHouseholdGarbageTaxes'=> $chargesIncludeHouseholdGarbageTaxes,
    ':chargesIncludeCleaningService'=> $chargesIncludeCleaningService,
    ':isFurnished'=> $isFurnished,
    ':kitchenUse'=> $kitchenUse,
    ':livingRoomUse'=> $livingRoomUse,
    ':bedroomSize'=> $bedroomSize,
    ':bedroomType'=> $bedroomType,
    ':bedType'=> $bedType,
    ':bedroomHasDesk'=> $bedroomHasDesk,
    ':bedroomHasWardrobe'=> $bedroomHasWardrobe,
    ':bedroomHasChair'=> $bedroomHasChair,
    ':bedroomHasTv'=> $bedroomHasTv,
    ':bedroomHasArmchair'=> $bedroomHasArmchair,
    ':bedroomHasCoffeeTable'=> $bedroomHasCoffeeTable,
    ':bedroomHasBedside'=> $bedroomHasBedside,
    ':bedroomHasLamp'=> $bedroomHasLamp,
    ':bedroomHasCloset'=> $bedroomHasCloset,
    ':bedroomHasShelf'=> $bedroomHasShelf,
    ':handicapedAccessibility'=> $handicapedAccessibility,
    ':accomodationHasElevator'=> $accomodationHasElevator,
    ':accomodationHasCommonParkingLot'=> $accomodationHasCommonParkingLot,
    ':accomodationHasPrivateParkingPlace'=> $accomodationHasPrivateParkingPlace,
    ':accomodationHasGarden'=> $accomodationHasGarden,
    ':accomodationHasBalcony'=> $accomodationHasBalcony,
    ':accomodationHasTerrace'=> $accomodationHasTerrace,
    ':accomodationHasSwimmingPool'=> $accomodationHasSwimmingPool,
    ':accomodationHasTv'=> $accomodationHasTv,
    ':accomodationHasInternet'=> $accomodationHasInternet,
    ':accomodationHasWifi'=> $accomodationHasWifi,
    ':accomodationHasFiberOpticInternet'=> $accomodationHasFiberOpticInternet,
    ':accomodationHasNetflix'=> $accomodationHasNetflix,
    ':accomodationHasDoubleGlazing'=> $accomodationHasDoubleGlazing,
    ':accomodationHasAirConditioning'=> $accomodationHasAirConditioning,
    ':accomodationHasElectricHeating'=> $accomodationHasElectricHeating,
    ':accomodationHasIndividualGasHeating'=> $accomodationHasIndividualGasHeating,
    ':accomodationHasCollectiveGasHeating'=> $accomodationHasCollectiveGasHeating,
    ':accomodationHasHotWaterTank'=> $accomodationHasHotWaterTank,
    ':accomodationHasGasWaterHeater'=> $accomodationHasGasWaterHeater,
    ':accomodationHasFridge'=> $accomodationHasFridge,
    ':accomodationHasFreezer'=> $accomodationHasFreezer,
    ':accomodationHasOven'=> $accomodationHasOven,
    ':accomodationHasBakingTray'=> $accomodationHasBakingTray,
    ':accomodationHasWashingMachine'=> $accomodationHasWashingMachine,
    ':accomodationHasDishwasher'=> $accomodationHasDishwasher,
    ':accomodationHasMicrowaveOven'=> $accomodationHasMicrowaveOven,
    ':accomodationHasCoffeeMachine'=> $accomodationHasCoffeeMachine,
    ':accomodationHasPodCoffeeMachine'=> $accomodationHasPodCoffeeMachine,
    ':accomodationHasKettle'=> $accomodationHasKettle,
    ':accomodationHasToaster'=> $accomodationHasToaster,
    ':accomodationHasExtractorHood'=> $accomodationHasExtractorHood,
    ':animalsAllowed'=> $animalsAllowed,
    ':smokingIsAllowed'=> $smokingIsAllowed,
    ':authorizedParty'=> $authorizedParty,
    ':authorizedVisit'=> $authorizedVisit,
    ':nbOfOtherRoommatePresent'=> $nbOfOtherRoommatePresent,
    ':renterSituation'=> $renterSituation,
    ':idealRoommateSex'=> $idealRoommateSex,
    ':idealRoommateSituation'=> $idealRoommateSituation,
    ':idealRoommateMinAge'=> $idealRoommateMinAge,
    ':idealRoommateMaxAge'=> $idealRoommateMaxAge,
    ':locationMinDuration'=> $locationMinDuration,
    ':rentWithoutVisit'=> $rentWithoutVisit,
    ':contactNameForVisit'=> $contactNameForVisit,
    ':contactPhoneNumberForVisit'=> $contactPhoneNumberForVisit,
    ':contactMailForVisit'=> $contactMailForVisit,
    ':addressId'=> $addressId,
    ':userId'=> $userId
    ));
}


//Enregistrement image dans le dossier public/images
function uploadImage($namePictureTmp, $namePicture, $uploadPictureDir)
{
    //Vérifie si le fichier a bien été chargé
    if (is_uploaded_file($namePictureTmp)) {
        return move_uploaded_file($namePictureTmp, $uploadPictureDir.$namePicture);
    } else {
        return false;
    }
}






//TP VOYAGES

//Ajouter un voyage
function insertNewTravel($title, $content, $image=null)
{
    $titleOk = htmlentities(strip_tags($title));
    $contentOk = htmlentities(strip_tags($content));

    $db = connectBdd();
    $insert = $db->prepare('INSERT INTO voyagespost (title,content,image) VALUES (:title,:content,:image)');
    $insert->execute(array(
        ':title'=>$titleOk,
        ':content'=>$contentOk,
        ':image'=>$image
    ));
    return true;
}


//Récupérer un voyage ciblé par son id
function getTravel($id)
{
    $db = connectBdd();
    $request = $db->query('SELECT * FROM voyagespost WHERE id="'.$id.'"');
    $requestOk = $request->fetch();
    $request->closeCursor();
    return $requestOk;
}

//Supprimer un voyage dans la base dedonnée
function deleteTravelInBdd($postTravelToDelete)
{
    $postTravelToDelete = htmlentities(strip_tags($postTravelToDelete));
    $db = connectBdd();
    
    //Supprime l'image du dossier ou elle est stockée
    $requestOk = getTravel($postTravelToDelete);
    unlink('public/images/'.$requestOk['image'].'');

    //Supprime de la base de donnée
    $delete = $db->prepare('DELETE FROM voyagespost WHERE id="'.$postTravelToDelete.'"');
    $delete->execute();
}

//Modifier un voyage dans le base dedonnée
function modifyTravelInBdd($title, $content, $id)
{
    $title = htmlentities(strip_tags($title));
    $content = htmlentities(strip_tags($content));
    $id = htmlentities(strip_tags($id));

    $db = connectBdd();
    $modify = $db->prepare('UPDATE voyagespost SET title=:title,content=:content WHERE id=:id');
    $modify->execute([
        ':title'=>$title,
        ':content'=>$content,
        ':id'=>$id
    ]);
}