<?php
$title = "Mes annonces";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Mes annonces</h1>
        <?php
        $countForIdButton = 0;
    foreach ($userAdvertisements as $key => $value) {
        ?>
        <div class="card m-0 p-3 my-3 m-md-3">
            <div class="row">
                <div class="media col-sm-12 col-md-8 col-lg-9">
                    <img class="mr-3" src="
                    <?php
                    if (array_key_exists('picture_fileName', $userAdvertisements[$key])) {
                        echo 'public/pictures/users/'.$userAdvertisements[$key]['picture_fileName'].'';
                    } else {
                        echo 'public/pictures/icons/iconePhoto64.png';
                    } ?>
                    " alt="Generic placeholder image" style="width:64px">
                    <div class="media-body">
                        <h5 class="mt-0 font-weight-bold"><?=$userAdvertisements[$key]['advertisement_title']?></h5>
                        <?=$userAdvertisements[$key]['advertisement_description']?>
                    </div>
                </div>
                <!--BOUTONS-->
                <div id="buttonsAdvertisement" class="col-sm-12 col-md-4 col-lg-3 pt-3 pt-md-0">
                    <div class="row">
                        <div class="col-4 text-center custom-control custom-switch">
                            <input type="checkbox"
                                onchange="requestAjaxPost(<?=$userAdvertisements[$key]['advertisement_id']?>)"
                                class="custom-control-input" id="customSwitches<?=$countForIdButton?>" <?php
                        if ($userAdvertisements[$key]['advertisement_isActive']) {
                            echo 'checked';
                        } ?>>
                            <label class="custom-control-label" title="Activer/Désactiver"
                                for="customSwitches<?=$countForIdButton?>"></label>
                        </div>
                        <!-- Bouton modifier -->
                        <div class="col-4 text-center">
                            <a
                                href="index.php?page=modifyAdvertisement&advertisementId=<?=$userAdvertisements[$key]['advertisement_id']?>"><img
                                    src="public/pictures/icons/iconeModifier32.png" alt="Modifier l'annonce"
                                    title="Modifier"></a>
                        </div>
                        <!-- Bouton Supprimer -->
                        <div class="col-4 text-center">
                            <a href="#"
                                onclick="confirmation('<?=$deleteUrl?>','<?=$userAdvertisements[$key]['advertisement_id']?>')"><img
                                    src="public/pictures/icons/iconeDelete32.png" alt="supprimer l'annonce"
                                    title="Supprimer"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $countForIdButton++;
    }
        ?>
        <script src="public/js/confirmBeforeDelete.js"></script>
        <script src="public/js/changeIsActiveState.js"></script>
        <?php
$content = ob_get_clean();
require('view/includes/template.php');