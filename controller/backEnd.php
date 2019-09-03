<?php
require_once('model/backEnd/modelBackEnd.php');

//Vérification login et mot de passe
function login()
{
    $login = getUser($_POST['login']);
    if ($login) {
        if (password_verify($_POST['password'], $login['user_password'])) {
            $_SESSION['login'] = $login['user_mail'];
            $_SESSION['isAdmin'] = $login['user_isAdmin'];
        }
    }
}
//Affichage page d'accueil utilisateur connecté
function displayHomeUser()
{
    require('view/backEnd/displayHomeUser.php');
}
//Affichage Formulaire d'ajout d'une nouvelle annonce
function displayAddAnAdvertisementForm()
{
    require('view/backEnd/displayPostAnAdvertisement.php');
}
//Ajouter une nouvelle annonce
function addANewAdvertisement()
{
    if (isset($_POST['availableDate'])){
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
    }else{
        $financialRequirements = false;
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['solvencyRatio'])) {
        $solvencyRatio = $_POST['solvencyRatio'];
    }
    if (isset($_POST['eligibleForAids'])) {
        $eligibleForAids = $_POST['eligibleForAids'];
    }else{
        $eligibleForAids = false;
    }
    if (isset($_POST['chargesIncludeCoOwnershipCharges'])) {
        $chargesIncludeCoOwnershipCharges = $_POST['chargesIncludeCoOwnershipCharges'];
    }else{
        $chargesIncludeCoOwnershipCharges = false;
    }
    if (isset($_POST['chargesIncludeElectricity'])) {
        $chargesIncludeElectricity = $_POST['chargesIncludeElectricity'];
    }else{
        $chargesIncludeElectricity = false;
    }
    if (isset($_POST['chargesIncludeHotWater'])) {
        $chargesIncludeHotWater = $_POST['chargesIncludeHotWater'];
    }else{
        $chargesIncludeHotWater = false;
    }
    if (isset($_POST['chargesIncludeHeating'])) {
        $chargesIncludeHeating = $_POST['chargesIncludeHeating'];
    }else{
        $chargesIncludeHeating = false;
    }
    if (isset($_POST['chargesIncludeInternet'])) {
        $chargesIncludeInternet = $_POST['chargesIncludeInternet'];
    }else{
        $chargesIncludeInternet = false;
    }
    if (isset($_POST['chargesIncludeHomeInsurance'])) {
        $chargesIncludeHomeInsurance = $_POST['chargesIncludeHomeInsurance'];
    }else{
        $chargesIncludeHomeInsurance = false;
    }
    if (isset($_POST['chargesIncludeBoilerInspection'])) {
        $chargesIncludeBoilerInspection = $_POST['chargesIncludeBoilerInspection'];
    }else{
        $chargesIncludeBoilerInspection = false;
    }
    if (isset($_POST['chargesIncludeHouseholdGarbageTaxes'])) {
        $chargesIncludeHouseholdGarbageTaxes = $_POST['chargesIncludeHouseholdGarbageTaxes'];
    }else{
        $chargesIncludeHouseholdGarbageTaxes = false;
    }
    if (isset($_POST['chargesIncludeCleaningService'])) {
        $chargesIncludeCleaningService = $_POST['chargesIncludeCleaningService'];
    }else{
        $chargesIncludeCleaningService = false;
    }
    if (isset($_POST['isFurnished'])) {
        $isFurnished = $_POST['isFurnished'];
    }else{
        $isFurnished = false;
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
    }else{
        $bedroomHasDesk = false;
    }
    if (isset($_POST['bedroomHasWardrobe'])) {
        $bedroomHasWardrobe = $_POST['bedroomHasWardrobe'];
    }else{
        $bedroomHasWardrobe = false;
    }
    if (isset($_POST['bedroomHasChair'])) {
        $bedroomHasChair = $_POST['bedroomHasChair'];
    }else{
        $bedroomHasChair = false;
    }
    if (isset($_POST['bedroomHasTv'])) {
        $bedroomHasTv = $_POST['bedroomHasTv'];
    }else{
        $bedroomHasTv = false;
    }
    if (isset($_POST['bedroomHasArmchair'])) {
        $bedroomHasArmchair = $_POST['bedroomHasArmchair'];
    }else{
        $bedroomHasArmchair = false;
    }
    if (isset($_POST['bedroomHasCoffeeTable'])) {
        $bedroomHasCoffeeTable = $_POST['bedroomHasCoffeeTable'];
    }else{
        $bedroomHasCoffeeTable = false;
    }
    if (isset($_POST['bedroomHasBedside'])) {
        $bedroomHasBedside = $_POST['bedroomHasBedside'];
    }else{
        $bedroomHasBedside = false;
    }
    if (isset($_POST['bedroomHasLamp'])) {
        $bedroomHasLamp = $_POST['bedroomHasLamp'];
    }else{
        $bedroomHasLamp = false;
    }
    if (isset($_POST['bedroomHasCloset'])) {
        $bedroomHasCloset = $_POST['bedroomHasCloset'];
    }else{
        $bedroomHasCloset = false;
    }
    if (isset($_POST['bedroomHasShelf'])) {
        $bedroomHasShelf = $_POST['bedroomHasShelf'];
    }else{
        $bedroomHasShelf = false;
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    if (isset($_POST['guarantorLiving'])) {
        $guarantorLiving = $_POST['guarantorLiving'];
    }
    insertNewAdvertisement($availableDate,$title,$description,$type,$category,$energyClassLetter,$energyClassNumber,$gesLetter,$gesNumber,$accomodationLivingAreaSize,$accomodationFloor,$buildingNbOfFloors);
    print_r($_POST);
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
