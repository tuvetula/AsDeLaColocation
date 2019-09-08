<?php
$title = "Mes annonces";
ob_start();
?>
<div id="displayHomeUser" class="container">
    <div class="jumbotron">
        <h1 class="text-center">Mes annonces</h1>
        <?php
        $countForIdButton = 0;
    foreach ($userAdvertisements as $key => $value) {
        ?>
        <div class="card row mt-4 p-3">
            <div class="row">
                <div class="media col-md-9">
                    <img class="mr-3" src="
                    <?php
                    if (array_key_exists('picture_fileName',$userAdvertisements[$key])){
                        echo 'public/pictures/users/'.$userAdvertisements[$key]['picture_fileName'].'';
                    }else{
                        echo 'public/pictures/icons/iconePhoto64.png';
                    }
                    ?>
                    " alt="Generic placeholder image" style="width:64px">
                    <div class="media-body col-md-9">
                        <h5 class="mt-0"><?=$userAdvertisements[$key]['advertisement_title']?></h5>
                        <?=$userAdvertisements[$key]['advertisement_description']?>
                    </div>
                </div>
                <div id="buttonsAdvertisement" class="col-md-3 text-center m-0 p-O">
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                            onchange="requestAjaxPost(<?=$userAdvertisements[$key]['advertisement_id']?>)"
                            class="custom-control-input" id="customSwitches<?=$countForIdButton?>" <?php
                        if($userAdvertisements[$key]['advertisement_isActive']){
                            echo 'checked';
                        }
                        ?>>
                        <label class="custom-control-label" title="Activer/Désactiver"
                            for="customSwitches<?=$countForIdButton?>"></label>
                    </div>
                    
                    <a href="index.php?page=modifyAdvertisement&id=<?=$userAdvertisements[$key]['advertisement_id']?>"><img src="public/pictures/icons/iconeModifier32.png" alt="Modifier l'annonce"
                            title="Modifier"></a>
                    <a href="#"
                        onclick="confirmation('<?=$deleteUrl?>','<?=$userAdvertisements[$key]['advertisement_id']?>')"><img
                            src="public/pictures/icons/iconeDelete32.png" alt="supprimer l'annonce"
                            title="Supprimer"></a>
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