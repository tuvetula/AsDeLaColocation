<?php
require_once('model/bdd/bddConfig.php');

//Ajoute une nouvelle annonce en base de données
function insertNewAdvertisement($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId)
{
    $isActive = 0;
    $dateOfLastDiffusion = null;
    $availableDate = htmlspecialchars(strip_tags($availableDate));
    $title = htmlspecialchars(strip_tags($title));
    $description = htmlspecialchars(strip_tags($description));
    $type = htmlspecialchars(strip_tags($type));
    $category = htmlspecialchars(strip_tags($category));
    $energyClassLetter = htmlspecialchars(strip_tags($energyClassLetter));
    $energyClassNumber = htmlspecialchars(strip_tags($energyClassNumber));
    $gesLetter = htmlspecialchars(strip_tags($gesLetter));
    $gesNumber = htmlspecialchars(strip_tags($gesNumber));
    $accomodationLivingAreaSize = htmlspecialchars(strip_tags($accomodationLivingAreaSize));
    $accomodationFloor = htmlspecialchars(strip_tags($accomodationFloor));
    $buildingNbOfFloors = htmlspecialchars(strip_tags($buildingNbOfFloors));
    $accomodationNbOfRooms = htmlspecialchars(strip_tags($accomodationNbOfRooms));
    $accomodationNbOfBedrooms = htmlspecialchars(strip_tags($accomodationNbOfBedrooms));
    $accomodationNbOfBathrooms = htmlspecialchars(strip_tags($accomodationNbOfBathrooms));
    $nbOfBedroomsToRent = htmlspecialchars(strip_tags($nbOfBedroomsToRent));
    $monthlyRentExcludingCharges = htmlspecialchars(strip_tags($monthlyRentExcludingCharges));
    $charges = htmlspecialchars(strip_tags($charges));
    $suretyBond = htmlspecialchars(strip_tags($suretyBond));
    $financialRequirements = htmlspecialchars(strip_tags($financialRequirements));
    $guarantorLiving = htmlspecialchars(strip_tags($guarantorLiving));
    $solvencyRatio = htmlspecialchars(strip_tags($solvencyRatio));
    $eligibleForAids = htmlspecialchars(strip_tags($eligibleForAids));
    $chargesIncludeCoOwnershipCharges = htmlspecialchars(strip_tags($chargesIncludeCoOwnershipCharges));
    $chargesIncludeElectricity = htmlspecialchars(strip_tags($chargesIncludeElectricity));
    $chargesIncludeHotWater = htmlspecialchars(strip_tags($chargesIncludeHotWater));
    $chargesIncludeHeating = htmlspecialchars(strip_tags($chargesIncludeHeating));
    $chargesIncludeInternet = htmlspecialchars(strip_tags($chargesIncludeInternet));
    $chargesIncludeHomeInsurance = htmlspecialchars(strip_tags($chargesIncludeHomeInsurance));
    $chargesIncludeBoilerInspection = htmlspecialchars(strip_tags($chargesIncludeBoilerInspection));
    $chargesIncludeHouseholdGarbageTaxes = htmlspecialchars(strip_tags($chargesIncludeHouseholdGarbageTaxes));
    $chargesIncludeCleaningService = htmlspecialchars(strip_tags($chargesIncludeCleaningService));
    $isFurnished = htmlspecialchars(strip_tags($isFurnished));
    $kitchenUse = htmlspecialchars(strip_tags($kitchenUse));
    $livingRoomUse = htmlspecialchars(strip_tags($livingRoomUse));
    $bedroomSize = htmlspecialchars(strip_tags($bedroomSize));
    $bedroomType = htmlspecialchars(strip_tags($bedroomType));
    $bedType = htmlspecialchars(strip_tags($bedType));
    $bedroomHasDesk = htmlspecialchars(strip_tags($bedroomHasDesk));
    $bedroomHasWardrobe = htmlspecialchars(strip_tags($bedroomHasWardrobe));
    $bedroomHasChair = htmlspecialchars(strip_tags($bedroomHasChair));
    $bedroomHasTv = htmlspecialchars(strip_tags($bedroomHasTv));
    $bedroomHasArmchair = htmlspecialchars(strip_tags($bedroomHasArmchair));
    $bedroomHasCoffeeTable = htmlspecialchars(strip_tags($bedroomHasCoffeeTable));
    $bedroomHasBedside = htmlspecialchars(strip_tags($bedroomHasBedside));
    $bedroomHasLamp = htmlspecialchars(strip_tags($bedroomHasLamp));
    $bedroomHasCloset = htmlspecialchars(strip_tags($bedroomHasCloset));
    $bedroomHasShelf = htmlspecialchars(strip_tags($bedroomHasShelf));
    $handicapedAccessibility = htmlspecialchars(strip_tags($handicapedAccessibility));
    $accomodationHasElevator = htmlspecialchars(strip_tags($accomodationHasElevator));
    $accomodationHasCommonParkingLot = htmlspecialchars(strip_tags($accomodationHasCommonParkingLot));
    $accomodationHasPrivateParkingPlace = htmlspecialchars(strip_tags($accomodationHasPrivateParkingPlace));
    $accomodationHasGarden = htmlspecialchars(strip_tags($accomodationHasGarden));
    $accomodationHasBalcony = htmlspecialchars(strip_tags($accomodationHasBalcony));
    $accomodationHasTerrace = htmlspecialchars(strip_tags($accomodationHasTerrace));
    $accomodationHasSwimmingPool = htmlspecialchars(strip_tags($accomodationHasSwimmingPool));
    $accomodationHasTv = htmlspecialchars(strip_tags($accomodationHasTv));
    $accomodationHasInternet = htmlspecialchars(strip_tags($accomodationHasInternet));
    $accomodationHasWifi = htmlspecialchars(strip_tags($accomodationHasWifi));
    $accomodationHasFiberOpticInternet = htmlspecialchars(strip_tags($accomodationHasFiberOpticInternet));
    $accomodationHasNetflix = htmlspecialchars(strip_tags($accomodationHasNetflix));
    $accomodationHasDoubleGlazing = htmlspecialchars(strip_tags($accomodationHasDoubleGlazing));
    $accomodationHasAirConditioning = htmlspecialchars(strip_tags($accomodationHasAirConditioning));
    $accomodationHasElectricHeating = htmlspecialchars(strip_tags($accomodationHasElectricHeating));
    $accomodationHasIndividualGasHeating = htmlspecialchars(strip_tags($accomodationHasIndividualGasHeating));
    $accomodationHasCollectiveGasHeating = htmlspecialchars(strip_tags($accomodationHasCollectiveGasHeating));
    $accomodationHasHotWaterTank = htmlspecialchars(strip_tags($accomodationHasHotWaterTank));
    $accomodationHasGasWaterHeater = htmlspecialchars(strip_tags($accomodationHasGasWaterHeater));
    $accomodationHasFridge = htmlspecialchars(strip_tags($accomodationHasFridge));
    $accomodationHasFreezer = htmlspecialchars(strip_tags($accomodationHasFreezer));
    $accomodationHasOven = htmlspecialchars(strip_tags($accomodationHasOven));
    $accomodationHasBakingTray = htmlspecialchars(strip_tags($accomodationHasBakingTray));
    $accomodationHasWashingMachine = htmlspecialchars(strip_tags($accomodationHasWashingMachine));
    $accomodationHasDishwasher = htmlspecialchars(strip_tags($accomodationHasDishwasher));
    $accomodationHasMicrowaveOven = htmlspecialchars(strip_tags($accomodationHasMicrowaveOven));
    $accomodationHasCoffeeMachine = htmlspecialchars(strip_tags($accomodationHasCoffeeMachine));
    $accomodationHasPodCoffeeMachine = htmlspecialchars(strip_tags($accomodationHasPodCoffeeMachine));
    $accomodationHasKettle = htmlspecialchars(strip_tags($accomodationHasKettle));
    $accomodationHasToaster = htmlspecialchars(strip_tags($accomodationHasToaster));
    $accomodationHasExtractorHood = htmlspecialchars(strip_tags($accomodationHasExtractorHood));
    $animalsAllowed = htmlspecialchars(strip_tags($animalsAllowed));
    $smokingIsAllowed = htmlspecialchars(strip_tags($smokingIsAllowed));
    $authorizedParty = htmlspecialchars(strip_tags($authorizedParty));
    $authorizedVisit = htmlspecialchars(strip_tags($authorizedVisit));
    $nbOfOtherRoommatePresent = htmlspecialchars(strip_tags($nbOfOtherRoommatePresent));
    $renterSituation = htmlspecialchars(strip_tags($renterSituation));
    $idealRoommateSex = htmlspecialchars(strip_tags($idealRoommateSex));
    $idealRoommateSituation = htmlspecialchars(strip_tags($idealRoommateSituation));
    $idealRoommateMinAge = htmlspecialchars(strip_tags($idealRoommateMinAge));
    $idealRoommateMaxAge = htmlspecialchars(strip_tags($idealRoommateMaxAge));
    $locationMinDuration = htmlspecialchars(strip_tags($locationMinDuration));
    $rentWithoutVisit = htmlspecialchars(strip_tags($rentWithoutVisit));
    $contactNameForVisit = htmlspecialchars(strip_tags($contactNameForVisit));
    $contactPhoneNumberForVisit = htmlspecialchars(strip_tags($contactPhoneNumberForVisit));
    $contactMailForVisit = htmlspecialchars(strip_tags($contactMailForVisit));
    $addressId = htmlspecialchars(strip_tags($addressId));
    $userId = htmlspecialchars(strip_tags($_SESSION['id']));
    
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
    return true;
}