<?php
require_once('model/bdd/bddConfig.php');

function saveModifyAdvertisementInBddAdmin($isActive, $availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $otherRoommateSex, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId, $advertisementId)
{
    $isActive = htmlspecialchars(strip_tags($isActive));
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
    $otherRoommateSex = htmlspecialchars(strip_tags($otherRoommateSex));
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
    $advertisementId = htmlspecialchars(strip_tags($advertisementId));

    $db = connectBdd();
    $insert = $db->prepare('UPDATE advertisements SET 
    advertisement_isActive=:isActive,
    advertisement_availableDate=:availableDate,
    advertisement_title=:title,
    advertisement_description=:description,
    advertisement_type=:type,
    advertisement_category=:category,
    advertisement_energyClassLetter=:energyClassLetter,
    advertisement_energyClassNumber=:energyClassNumber,
    advertisement_gesLetter=:gesLetter,
    advertisement_gesNumber=:gesNumber,
    advertisement_accomodationLivingAreaSize=:accomodationLivingAreaSize,
    advertisement_accomodationFloor=:accomodationFloor,
    advertisement_buildingNbOfFloors=:buildingNbOfFloors,
    advertisement_accomodationNbOfRooms=:accomodationNbOfRooms,
    advertisement_accomodationNbOfBedrooms=:accomodationNbOfBedrooms,
    advertisement_accomodationNbOfBathrooms=:accomodationNbOfBathrooms,
    advertisement_nbOfBedroomsToRent=:nbOfBedroomsToRent,
    advertisement_monthlyRentExcludingCharges=:monthlyRentExcludingCharges,
    advertisement_charges=:charges,
    advertisement_suretyBond=:suretyBond,
    advertisement_financialRequirements=:financialRequirements,
    advertisement_guarantorLiving=:guarantorLiving,
    advertisement_solvencyRatio=:solvencyRatio,
    advertisement_eligibleForAids=:eligibleForAids,
    advertisement_chargesIncludeCoOwnershipCharges=:chargesIncludeCoOwnershipCharges,
    advertisement_chargesIncludeElectricity=:chargesIncludeElectricity,
    advertisement_chargesIncludeHotWater=:chargesIncludeHotWater,
    advertisement_chargesIncludeHeating=:chargesIncludeHeating,
    advertisement_chargesIncludeInternet=:chargesIncludeInternet,
    advertisement_chargesIncludeHomeInsurance=:chargesIncludeHomeInsurance,
    advertisement_chargesIncludeBoilerInspection=:chargesIncludeBoilerInspection,
    advertisement_chargesIncludeHouseholdGarbageTaxes=:chargesIncludeHouseholdGarbageTaxes,
    advertisement_chargesIncludeCleaningService=:chargesIncludeCleaningService,
    advertisement_isFurnished=:isFurnished,
    advertisement_kitchenUse=:kitchenUse,
    advertisement_livingRoomUse=:livingRoomUse,
    advertisement_bedroomSize=:bedroomSize,
    advertisement_bedroomType=:bedroomType,
    advertisement_bedType=:bedType,
    advertisement_bedroomHasDesk=:bedroomHasDesk,
    advertisement_bedroomHasWardrobe=:bedroomHasWardrobe,
    advertisement_bedroomHasChair=:bedroomHasChair,
    advertisement_bedroomHasTv=:bedroomHasTv,
    advertisement_bedroomHasArmchair=:bedroomHasArmchair,
    advertisement_bedroomHasCoffeeTable=:bedroomHasCoffeeTable,
    advertisement_bedroomHasBedside=:bedroomHasBedside,
    advertisement_bedroomHasLamp=:bedroomHasLamp,
    advertisement_bedroomHasCloset=:bedroomHasCloset,
    advertisement_bedroomHasShelf=:bedroomHasShelf,
    advertisement_handicapedAccessibility=:handicapedAccessibility,
    advertisement_accomodationHasElevator=:accomodationHasElevator,
    advertisement_accomodationHasCommonParkingLot=:accomodationHasCommonParkingLot,
    advertisement_accomodationHasPrivateParkingPlace=:accomodationHasPrivateParkingPlace,
    advertisement_accomodationHasGarden=:accomodationHasGarden,
    advertisement_accomodationHasBalcony=:accomodationHasBalcony,
    advertisement_accomodationHasTerrace=:accomodationHasTerrace,
    advertisement_accomodationHasSwimmingPool=:accomodationHasSwimmingPool,
    advertisement_accomodationHasTv=:accomodationHasTv,
    advertisement_accomodationHasInternet=:accomodationHasInternet,
    advertisement_accomodationHasWifi=:accomodationHasWifi,
    advertisement_accomodationHasFiberOpticInternet=:accomodationHasFiberOpticInternet,
    advertisement_accomodationHasNetflix=:accomodationHasNetflix,
    advertisement_accomodationHasDoubleGlazing=:accomodationHasDoubleGlazing,
    advertisement_accomodationHasAirConditioning=:accomodationHasAirConditioning,
    advertisement_accomodationHasElectricHeating=:accomodationHasElectricHeating,
    advertisement_accomodationHasIndividualGasHeating=:accomodationHasIndividualGasHeating,
    advertisement_accomodationHasCollectiveGasHeating=:accomodationHasCollectiveGasHeating,
    advertisement_accomodationHasHotWaterTank=:accomodationHasHotWaterTank,
    advertisement_accomodationHasGasWaterHeater=:accomodationHasGasWaterHeater,
    advertisement_accomodationHasFridge=:accomodationHasFridge,
    advertisement_accomodationHasFreezer=:accomodationHasFreezer,
    advertisement_accomodationHasOven=:accomodationHasOven,
    advertisement_accomodationHasBakingTray=:accomodationHasBakingTray,
    advertisement_accomodationHasWashingMachine=:accomodationHasWashingMachine,
    advertisement_accomodationHasDishwasher=:accomodationHasDishwasher,
    advertisement_accomodationHasMicrowaveOven=:accomodationHasMicrowaveOven,
    advertisement_accomodationHasCoffeeMachine=:accomodationHasCoffeeMachine,
    advertisement_accomodationHasPodCoffeeMachine=:accomodationHasPodCoffeeMachine,
    advertisement_accomodationHasKettle=:accomodationHasKettle,
    advertisement_accomodationHasToaster=:accomodationHasToaster,
    advertisement_accomodationHasExtractorHood=:accomodationHasExtractorHood,
    advertisement_animalsAllowed=:animalsAllowed,
    advertisement_smokingIsAllowed=:smokingIsAllowed,
    advertisement_authorizedParty=:authorizedParty,
    advertisement_authorizedVisit=:authorizedVisit,
    advertisement_nbOfOtherRoommatePresent=:nbOfOtherRoommatePresent,
    advertisement_otherRoommateSex=:otherRoommateSex,
    advertisement_renterSituation=:renterSituation,
    advertisement_idealRoommateSex=:idealRoommateSex,
    advertisement_idealRoommateSituation=:idealRoommateSituation,
    advertisement_idealRoommateMinAge=:idealRoommateMinAge,
    advertisement_idealRoommateMaxAge=:idealRoommateMaxAge,
    advertisement_locationMinDuration=:locationMinDuration,
    advertisement_rentWithoutVisit=:rentWithoutVisit,
    advertisement_contactNameForVisit=:contactNameForVisit,
    advertisement_contactPhoneNumberForVisit=:contactPhoneNumberForVisit,
    advertisement_contactMailForVisit=:contactMailForVisit,
    address_id=:addressId
    WHERE advertisement_id="'.$advertisementId.'"');

    $insert->execute(array(
    ':isActive'=> $isActive,
    ':availableDate'=> $availableDate,
    ':title'=>$title,
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
    ':otherRoommateSex'=> $otherRoommateSex,
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
    ':addressId'=> $addressId
    ));
    return true;
}