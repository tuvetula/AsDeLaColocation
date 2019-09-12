<?php
$title = "Mon compte";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Mon compte</h1>
        <div class="card m-0 p-3 my-3 m-md-3">
            <div class="container text-right">
                <a href="index.php?page=displayModifyMyAccount"><img
                        src="public/pictures/icons/iconeModifier32.png" alt="Modifier l'annonce" title="Modifier"></a>
            </div>
            <div class="container">
                <h3 class="text-center">Coordonnées</h3>
                <div class="row">
                    <p class="offset-lg-2 col-lg-4"><strong>Nom:</strong> <?=$userData['user_name']?></p>
                    <p class="offset-lg-2 col-lg-4"><strong>Prénom:</strong> <?=$userData['user_firstName']?></p>
                </div>
                <div class="row">
                    <p class="offset-lg-2 col-lg-10"><strong>Rue:</strong> <?=$userData['address_street']?></p>
                </div>
                <div class="row">
                    <p class="offset-lg-2 col-lg-4"><strong>Code postal:</strong> <?=$userData['address_zipcode']?></p>
                    <p class="offset-lg-2 col-lg-4"><strong>Ville:</strong> <?=$userData['address_city']?></p>
                </div>
                <div class="row">
                    <p class="offset-lg-2 col-lg-4"><strong>Pays:</strong> <?=$userData['address_country']?></p>
                </div>
                <div class="row">
                    <p class="offset-lg-2 col-lg-4"><strong>Adresse mail:</strong> <?=$userData['user_mail']?></p>
                    <p class="offset-lg-2 col-lg-4"><strong>Numéro de téléphone:</strong>
                        <?=$userData['user_phoneNumber']?></p>
                </div>
            </div>
            <div class="container pt-3">
                <h3 class="text-center">Identifiants de connexion aux sites de diffusion</h3>
                <div class="row pt-3">
                    <p class="offset-lg-2 col-lg-4"><strong>Adresse mail:</strong> <?=$userData['user_loginSiteWeb']?>
                    </p>
                    <p class="offset-lg-2 col-lg-4"><strong>Mot de passe:</strong>
                        <?=$userData['user_passwordSiteWeb']?></p>
                </div>
            </div>

        </div>
    </div>
</div>



<?php
$content = ob_get_clean();
require('view/includes/template.php');