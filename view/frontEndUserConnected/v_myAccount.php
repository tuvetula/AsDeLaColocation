<?php
$title = "Mon compte";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center"><?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] && $_SESSION['id']!=$userData['user_id']){
            echo 'Compte de '.$userData['user_name'].' '.$userData['user_firstName'];
        }else{echo 'Mon compte';}?></h1>
        <div class="card m-0 p-3 my-3 m-md-3">
            <div class="container text-right">
                <a href="<?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){echo 'index.php?page=displayModifyMyAccount&userId='.$userId.'';}else{echo 'index.php?page=displayModifyMyAccount';}?>"><img
                        src="public/pictures/icons/iconeModifier32.png" alt="Modifier l'annonce" title="Modifier"></a>
            </div>
            <div class="container">
                <h3 class="text-center">Coordonnées</h3>
                <div class=row>
                    <p class="offset-lg-2 col-lg-4"><strong>Civilité:</strong> <?=$userData['user_civility']?></p>
                </div>
                <div class="row">
                    <p class="offset-lg-2 col-lg-4"><strong>Nom:</strong> <?=$userData['user_name']?></p>
                    <p class="offset-lg-2 col-lg-4"><strong>Prénom:</strong> <?=$userData['user_firstName']?></p>
                </div>
                <div class=row>
                    <p class="offset-lg-2 col-lg-4"><strong>Date de naissance:</strong> <?=$userData['user_dateOfBirth']?></p>
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
                        <?php if ($userData['user_passwordSiteWeb']){
                            echo $userData['user_passwordSiteWeb'];
                            } else {
                                echo $passwordSiteWeb;
                            }?></p>
                </div>
            </div>
            <?php if(isset($_SESSION['id']) && $_SESSION['id']==$userData['user_id']){?>
            <div class="container pt-3">
                <h3 class="text-center">Mot de passe</h3>
                <div class="row pt-1 d-flex justify-content-center">
                    <a href="index.php?page=modifyPassword">Modifier votre mot de passe</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean();
require('view/includes/template.php');