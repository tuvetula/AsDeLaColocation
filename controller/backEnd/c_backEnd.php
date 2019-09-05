<?php















//VOYAGES TP
function displayTravelsConnected()
{
    $travels = getTravels();
    $pageEnCours="index";
    require('view/backEnd/displayTravelsConnected.php');
}
function displayAddTravel($message=null)
{
    $pageEnCours = "ajouter";
    require('view/backEnd/displayAddTravel.php');
}
function displayDeleteTravel()
{
    $pageEnCours = "supprimer";
    $insert = getTravelsName();
    require('view/backEnd/displayDeleteTravel.php');
}
function deleteTravel()
{
    $postTravelToDelete= $_POST['deleteTravel'];
    deleteTravelInBdd($postTravelToDelete);
    displayDeleteTravel();
}
function displayModifyTravel()
{
    $pageEnCours = "modifier";
    $insert = getTravelsName();
    require('view/backEnd/displayModifyTravel.php');
}
function displayModifyTravelOk()
{
    $pageEnCours = "modifier";
    $postTravelToModify= $_POST['modifyTravel'];
    $requestOk = (getTravel($postTravelToModify));
    require('view/backEnd/displayModifyTravel.php');
}
function modifyTravel()
{
    $id = $_GET['idTravel'];
    $title = $_POST['titleModify'];
    $content = $_POST['contentModify'];
    modifyTravelInBdd($title, $content, $id);
    displayModifyTravel();
}

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
