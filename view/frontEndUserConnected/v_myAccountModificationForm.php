<?php
$title = "Modifier mon compte";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center"><?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] && $_SESSION['id']!=$userDataToModify['user_id']){echo 'Modifier le compte de '.$userDataToModify['user_name'].' '.$userDataToModify['user_firstName'];}else{echo 'Modifier mon compte';}?></h1>
        <form method="post" action="<?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){echo 'index.php?page=modifyMyAccount&userId='.$userId.'';}else{echo 'index.php?page=modifyMyAccount';}?>">
            <div class="container pb-3 pt-3 border-bottom border-dark">
            <?php if (isset($error)){echo '<p class="font-weight-bold text-danger py-3">Veuillez corriger les erreurs</p>';}?>
                <h2>Coordonnées</h2>
                <div class="container">
                    <div class="row">
                        <!-- Nom -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="name">Nom</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nom"
                                value="<?=$userDataToModify['user_name']?>" maxlength="125" required>
                        </div>
                        <!-- Prénom -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="firstName">Prénom</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Prénom"
                                value="<?=$userDataToModify['user_firstName']?>" maxlength="125" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Adresse -->
                        <div class="form-group col-md-12" title="Numéro, nom de rue">
                            <label for="street" class="font-weight-bold">Numéro et nom de rue</label>
                            <input id="street" type="text" name="street" class="form-control"
                                placeholder="Saisir l'adresse du logement"
                                value="<?=$userDataToModify['address_street']?>" maxlength="255" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Code postal -->
                        <div class="form-group col-md-2" title="Code postal">
                            <label for="zipcode" class="font-weight-bold">Code postal</label>
                            <input id="zipcode" type="text" name="zipcode" class="form-control"
                                placeholder="Code postal" value="<?=$userDataToModify['address_zipcode']?>"
                                maxlength="20" required>
                        </div>
                        <!-- Ville -->
                        <div class="form-group col-md-6" title="Ville">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" class="form-control" placeholder="Ville"
                                value="<?=$userDataToModify['address_city']?>" maxlength="60" required>
                        </div>
                        <!-- Pays -->
                        <div class="form-group col-md-4" title="Pays">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" class="form-control" placeholder="Pays"
                                value="<?=$userDataToModify['address_country']?>" maxlength="60" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Mail -->
                        <div class="form-group col-md-6">
                            <label for="mail" class="font-weight-bold">Adresse mail</label>
                            <input id="mail" type="email" name="mail" class="form-control" placeholder="Mail"
                                value="<?=$userDataToModify['user_mail']?>" maxlength="255" required>
                                <p class="text-danger font-weight-bold pb-1"><?php
                        if (isset($error) && $error== 'mail'){
                            echo 'Un compte est déja existant avec cette adresse mail';
                        }
                        ?></p>
                        </div>
                        <!-- Telephone -->
                        <div class="form-group col-md-6">
                            <label for="phoneNumber" class="font-weight-bold">Numéro de téléphone</label>
                            <input id="phoneNumber" type="tel" name="phoneNumber" class="form-control"
                                placeholder="Téléphone" value="<?=$userDataToModify['user_phoneNumber']?>"
                                maxlength="20" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Identifiants de connexion aux sites de diffusion</h2>
                <div class="container">
                    <div class="row">
                        <!-- Mail pour connexion site de diffusion -->
                        <div class="form-group col-md-6">
                            <label for="loginSiteWeb" class="font-weight-bold">Adresse mail</label>
                            <input id="loginSiteWeb" type="email" name="loginSiteWeb" class="form-control"
                                placeholder="Mail" value="<?=$userDataToModify['user_loginSiteWeb']?>" maxlength="255"
                                required>
                        </div>
                        <!-- mot de passe pour connexion site de diffusion -->
                        <div class="form-group col-md-6">
                            <label for="passwordSiteWeb" class="font-weight-bold">Mot de passe</label>
                            <input id="passwordSiteWeb" type="text" name="passwordSiteWeb" class="form-control"
                                placeholder="Mot de passe" value="<?=$userDataToModify['user_passwordSiteWeb']?>"
                                maxlength="255" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bouton submit -->
            <div class="container pt-3">
                <button type="submit" class="btn btn-primary offset-md-5 col-md-2">Enregistrer</button>
            </div>
        </form>
    </div>
</div>



<?php
$content = ob_get_clean();
require('view/includes/template.php');