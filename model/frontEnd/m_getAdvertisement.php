<?php
require_once('model/bdd/bddConfig.php');

//Récupère MAX(advertisement_id) de la dernière annonce saisie en bdd
function getLastAdvertisementId(){
    $db = connectBdd();
    $request = $db->query('SELECT MAX(advertisement_id) FROM advertisements');
    $lastAdvertisementId = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $lastAdvertisementId;
}

//Récupère titre, description, isActive de toutes les annonces d'un utilisateur
function getUserAdvertisement($userId){
    $db = connectBdd();
    $request = $db->query('SELECT advertisement_id,advertisement_title,advertisement_description,advertisement_isActive FROM advertisements WHERE user_id="'.$userId.'"');
    $userAdvertisements = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $userAdvertisements;
}

//Verifie si un id_advertisement et un id_user renvoi bien une annonce
function verifyAdvertisement($userId,$advertisementId){
        $db = connectBdd();
        $request = $db->query('SELECT * FROM advertisements WHERE user_id="'.$userId.'" AND advertisement_id="'.$advertisementId.'"');
        $userAdvertisements = $request->fetchAll(PDO::FETCH_ASSOC);
        $request->closeCursor();
        return $userAdvertisements;
}

//Récupère advertisement_id d'une annonce si tous les paramètres correspondent
function getAdvertisementId($availableDate, $title, $description, $type, $category, $energyClassLetter, $energyClassNumber, $gesLetter, $gesNumber, $accomodationLivingAreaSize, $accomodationFloor, $buildingNbOfFloors, $accomodationNbOfRooms, $accomodationNbOfBedrooms, $accomodationNbOfBathrooms, $nbOfBedroomsToRent, $monthlyRentExcludingCharges, $charges, $suretyBond, $financialRequirements, $guarantorLiving, $solvencyRatio, $eligibleForAids, $chargesIncludeCoOwnershipCharges, $chargesIncludeElectricity, $chargesIncludeHotWater, $chargesIncludeHeating, $chargesIncludeInternet, $chargesIncludeHomeInsurance, $chargesIncludeBoilerInspection, $chargesIncludeHouseholdGarbageTaxes, $chargesIncludeCleaningService, $isFurnished, $kitchenUse, $livingRoomUse, $bedroomSize, $bedroomType, $bedType, $bedroomHasDesk, $bedroomHasWardrobe, $bedroomHasChair, $bedroomHasTv, $bedroomHasArmchair, $bedroomHasCoffeeTable, $bedroomHasBedside, $bedroomHasLamp, $bedroomHasCloset, $bedroomHasShelf, $handicapedAccessibility, $accomodationHasElevator, $accomodationHasCommonParkingLot, $accomodationHasPrivateParkingPlace, $accomodationHasGarden, $accomodationHasBalcony, $accomodationHasTerrace, $accomodationHasSwimmingPool, $accomodationHasTv, $accomodationHasInternet, $accomodationHasWifi, $accomodationHasFiberOpticInternet, $accomodationHasNetflix, $accomodationHasDoubleGlazing, $accomodationHasAirConditioning, $accomodationHasElectricHeating, $accomodationHasIndividualGasHeating, $accomodationHasCollectiveGasHeating, $accomodationHasHotWaterTank, $accomodationHasGasWaterHeater, $accomodationHasFridge, $accomodationHasFreezer, $accomodationHasOven, $accomodationHasBakingTray, $accomodationHasWashingMachine, $accomodationHasDishwasher, $accomodationHasMicrowaveOven, $accomodationHasCoffeeMachine, $accomodationHasPodCoffeeMachine, $accomodationHasKettle, $accomodationHasToaster, $accomodationHasExtractorHood, $animalsAllowed, $smokingIsAllowed, $authorizedParty, $authorizedVisit, $nbOfOtherRoommatePresent, $renterSituation, $idealRoommateSex, $idealRoommateSituation, $idealRoommateMinAge, $idealRoommateMaxAge, $locationMinDuration, $rentWithoutVisit, $contactNameForVisit, $contactPhoneNumberForVisit, $contactMailForVisit, $addressId)
{
    $db = connectBdd();
    $request = $db->query('SELECT advertisement_id FROM advertisements 
    WHERE advertisement_availableDate="'.$availableDate.'" AND
        advertisement_title="'.$title.'" AND
        advertisement_description="'.$description.'" AND
        advertisement_type="'.$type.'" AND
        advertisement_category="'.$category.'" AND
        advertisement_energyClassLetter="'.$energyClassLetter.'" AND
        advertisement_energyClassNumber="'.$energyClassNumber.'" AND
        advertisement_gesLetter="'.$gesLetter.'" AND
        advertisement_gesNumber="'.$gesNumber.'" AND
        advertisement_accomodationLivingAreaSize="'.$accomodationLivingAreaSize.'" AND
        advertisement_accomodationFloor="'.$accomodationFloor.'" AND
        advertisement_buildingNbOfFloors="'.$buildingNbOfFloors.'" AND
        advertisement_accomodationNbOfRooms="'.$accomodationNbOfRooms.'" AND
        advertisement_accomodationNbOfBedrooms="'.$accomodationNbOfBedrooms.'" AND
        advertisement_accomodationNbOfBathrooms="'.$accomodationNbOfBathrooms.'" AND
        advertisement_nbOfBedroomsToRent="'.$nbOfBedroomsToRent.'" AND
        advertisement_monthlyRentExcludingCharges="'.$monthlyRentExcludingCharges.'" AND
        advertisement_charges="'.$charges.'" AND
        advertisement_suretyBond="'.$suretyBond.'" AND
        advertisement_financialRequirements="'.$financialRequirements.'" AND
        advertisement_guarantorLiving="'.$guarantorLiving.'" AND
        advertisement_solvencyRatio="'.$solvencyRatio.'" AND
        advertisement_eligibleForAids="'.$eligibleForAids.'" AND
        advertisement_chargesIncludeCoOwnershipCharges="'.$chargesIncludeCoOwnershipCharges.'" AND
        advertisement_chargesIncludeElectricity="'.$chargesIncludeElectricity.'" AND
        advertisement_chargesIncludeHotWater="'.$chargesIncludeHotWater.'" AND
        advertisement_chargesIncludeHeating="'.$chargesIncludeHeating.'" AND
        advertisement_chargesIncludeInternet="'.$chargesIncludeInternet.'" AND
        advertisement_chargesIncludeHomeInsurance="'.$chargesIncludeHomeInsurance.'" AND
        advertisement_chargesIncludeBoilerInspection="'.$chargesIncludeBoilerInspection.'" AND
        advertisement_chargesIncludeHouseholdGarbageTaxes="'.$chargesIncludeHouseholdGarbageTaxes.'" AND
        advertisement_chargesIncludeCleaningService="'.$chargesIncludeCleaningService.'" AND
        advertisement_isFurnished="'.$isFurnished.'" AND
        advertisement_kitchenUse="'.$kitchenUse.'" AND
        advertisement_livingRoomUse="'.$livingRoomUse.'" AND
        advertisement_bedroomSize="'.$bedroomSize.'" AND
        advertisement_bedroomType="'.$bedroomType.'" AND
        advertisement_bedType="'.$bedType.'" AND
        advertisement_bedroomHasDesk="'.$bedroomHasDesk.'" AND
        advertisement_bedroomHasWardrobe="'.$bedroomHasWardrobe.'" AND
        advertisement_bedroomHasChair="'.$bedroomHasChair.'" AND
        advertisement_bedroomHasTv="'.$bedroomHasTv.'" AND
        advertisement_bedroomHasArmchair="'.$bedroomHasArmchair.'" AND
        advertisement_bedroomHasCoffeeTable="'.$bedroomHasCoffeeTable.'" AND
        advertisement_bedroomHasBedside="'.$bedroomHasBedside.'" AND
        advertisement_bedroomHasLamp="'.$bedroomHasLamp.'" AND
        advertisement_bedroomHasCloset="'.$bedroomHasCloset.'" AND
        advertisement_bedroomHasShelf="'.$bedroomHasShelf.'" AND
        advertisement_handicapedAccessibility="'.$handicapedAccessibility.'" AND
        advertisement_accomodationHasElevator="'.$accomodationHasElevator.'" AND
        advertisement_accomodationHasCommonParkingLot="'.$accomodationHasCommonParkingLot.'" AND
        advertisement_accomodationHasPrivateParkingPlace="'.$accomodationHasPrivateParkingPlace.'" AND
        advertisement_accomodationHasGarden="'.$accomodationHasGarden.'" AND
        advertisement_accomodationHasBalcony="'.$accomodationHasBalcony.'" AND
        advertisement_accomodationHasTerrace="'.$accomodationHasTerrace.'" AND
        advertisement_accomodationHasSwimmingPool="'.$accomodationHasSwimmingPool.'" AND
        advertisement_accomodationHasTv="'.$accomodationHasTv.'" AND
        advertisement_accomodationHasInternet="'.$accomodationHasInternet.'" AND
        advertisement_accomodationHasWifi="'.$accomodationHasWifi.'" AND
        advertisement_accomodationHasFiberOpticInternet="'.$accomodationHasFiberOpticInternet.'" AND
        advertisement_accomodationHasNetflix="'.$accomodationHasNetflix.'" AND
        advertisement_accomodationHasDoubleGlazing="'.$accomodationHasDoubleGlazing.'" AND
        advertisement_accomodationHasAirConditioning="'.$accomodationHasAirConditioning.'" AND
        advertisement_accomodationHasElectricHeating="'.$accomodationHasElectricHeating.'" AND
        advertisement_accomodationHasIndividualGasHeating="'.$accomodationHasIndividualGasHeating.'" AND
        advertisement_accomodationHasCollectiveGasHeating="'.$accomodationHasCollectiveGasHeating.'" AND
        advertisement_accomodationHasHotWaterTank="'.$accomodationHasHotWaterTank.'" AND
        advertisement_accomodationHasGasWaterHeater="'.$accomodationHasGasWaterHeater.'" AND
        advertisement_accomodationHasFridge="'.$accomodationHasFridge.'" AND
        advertisement_accomodationHasFreezer="'.$accomodationHasFreezer.'" AND
        advertisement_accomodationHasOven="'.$accomodationHasOven.'" AND
        advertisement_accomodationHasBakingTray="'.$accomodationHasBakingTray.'" AND
        advertisement_accomodationHasWashingMachine="'.$accomodationHasWashingMachine.'" AND
        advertisement_accomodationHasDishwasher="'.$accomodationHasDishwasher.'" AND
        advertisement_accomodationHasMicrowaveOven="'.$accomodationHasMicrowaveOven.'" AND
        advertisement_accomodationHasCoffeeMachine="'.$accomodationHasCoffeeMachine.'" AND
        advertisement_accomodationHasPodCoffeeMachine="'.$accomodationHasPodCoffeeMachine.'" AND
        advertisement_accomodationHasKettle="'.$accomodationHasKettle.'" AND
        advertisement_accomodationHasToaster="'.$accomodationHasToaster.'" AND
        advertisement_accomodationHasExtractorHood="'.$accomodationHasExtractorHood.'" AND
        advertisement_animalsAllowed="'.$animalsAllowed.'" AND
        advertisement_smokingIsAllowed="'.$smokingIsAllowed.'" AND
        advertisement_authorizedParty="'.$authorizedParty.'" AND
        advertisement_authorizedVisit="'.$authorizedVisit.'" AND
        advertisement_nbOfOtherRoommatePresent="'.$nbOfOtherRoommatePresent.'" AND
        advertisement_renterSituation="'.$renterSituation.'" AND
        advertisement_idealRoommateSex="'.$idealRoommateSex.'" AND
        advertisement_idealRoommateSituation="'.$idealRoommateSituation.'" AND
        advertisement_idealRoommateMinAge="'.$idealRoommateMinAge.'" AND
        advertisement_idealRoommateMaxAge="'.$idealRoommateMaxAge.'" AND
        advertisement_locationMinDuration="'.$locationMinDuration.'" AND
        advertisement_rentWithoutVisit="'.$rentWithoutVisit.'" AND
        advertisement_contactNameForVisit="'.$contactNameForVisit.'" AND
        advertisement_contactPhoneNumberForVisit="'.$contactPhoneNumberForVisit.'" AND
        advertisement_contactMailForVisit="'.$contactMailForVisit.'"');
    $advertisementIdRequest = $request->fetch(PDO::FETCH_ASSOC);
    $request->closeCursor();
    return $advertisementIdRequest;
}
