<?php
$title = "Mes annonces";
ob_start();
?>
<div id="displayHomeUser" class="container">
    <div class="jumbotron">
        <h1 class="text-center">Mes annonces</h1>
        <div class="row mt-4">
            <div class="card col-md-4 text-center p-3">
                <div class="container offset-md-3 col-md-6">
                    <img src="public/images/Icons/iconeMonCompte.png" class="card-img" alt="Mes Annonces"
                        style="width:60px">
                </div>
                <div class="card-body">
                    <a href="index.php" class="stretched-link">
                        <h4>Mon compte</h4>
                    </a>
                </div>
            </div>

        </div>
        <?php
    // foreach($userAdvertisements as $key => $value){
    //     echo '<div class="container font-weight-bold">
    //             '.$userAdvertisements[$key]['advertisement_title'].'</div>';
    // }

    
    
    var_dump($userAdvertisementRearrange);

    
    ?>



        <?php
$content = ob_get_clean();
require('view/includes/template.php');