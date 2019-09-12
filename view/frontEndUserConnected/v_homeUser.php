<?php
$title = "Bienvenue";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Bienvenue dans votre espace personnel</h1>
    <div class="container">
        <div class="row mt-4">
            <div class="card col-md-4 text-center p-3">
                <div class="container offset-md-3 col-md-6">
                    <img src="public/pictures/Icons/iconeAnnonce.png" class="card-img img-responsive" alt="Mes Annonces"
                        style="width:50px">
                </div>
                <div class="card-body p-1">
                    <a href="index.php?page=myAdvertisements" class="stretched-link">
                        <h5>Mes annonces</h5>
                    </a>
                </div>
            </div>
            <div class="card col-md-4 text-center p-3">
                <div class="container offset-md-3 col-md-6">
                    <img src="public/pictures/Icons/iconeDeposerAnnonce.png" class="card-img img-responsive"
                        alt="Mes Annonces" style="width:50px">
                </div>
                <div class="card-body p-1">
                    <a href="index.php?page=displayAddAnAdvertisement" class="stretched-link">
                        <h5>Déposer une annonce</h5>
                    </a>
                </div>
            </div>
            <div class="card col-md-4 text-center p-3">
                <div class="container offset-md-3 col-md-6">
                    <img src="public/pictures/Icons/iconeMonCompte.png" class="card-img img-responsive "
                        alt="Mes Annonces" style="width:50px">
                </div>
                <div class="card-body p-1">
                    <a href="index.php?page=displayMyAccount" class="stretched-link">
                        <h5>Mon compte</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');