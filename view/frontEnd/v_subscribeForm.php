<?php
$title = "Page d'inscription";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Inscription</h1>
        <form id="form1" method="post" action="index.php?page=saveSubscribe">
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <?php
                    if (isset($error) && !empty($error)) {
                        echo '<p class="font-weight-bold text-danger py-3">'.$error.'</p>';
                    }?>
                <h2>Coordonnées</h2>
                <div class="container">
                    <div class="row">
                        <!-- Nom -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="name">Nom</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nom"
                                maxlength="125" <?php if (isset($_POST['name'])) {
                        echo 'value="'.$_POST['name'].'"';
                    } ?> required>
                        </div>
                        <!-- Prénom -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="firstName">Prénom</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Prénom"
                                maxlength="125" <?php if (isset($_POST['firstName'])) {
                        echo 'value="'.$_POST['firstName'].'"';
                    } ?> required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Adresse -->
                        <div class="form-group col-md-12" title="Numéro, nom de rue">
                            <label for="street" class="font-weight-bold">Numéro et nom de rue</label>
                            <input id="street" type="text" name="street" class="form-control"
                                placeholder="Numéro et nom de rue" maxlength="255" <?php if (isset($_POST['street'])) {
                        echo 'value="'.$_POST['street'].'"';
                    } ?> required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Code postal -->
                        <div class="form-group col-md-2" title="Code postal">
                            <label for="zipcode" class="font-weight-bold">Code postal</label>
                            <input id="zipcode" type="text" name="zipcode" class="form-control"
                                placeholder="Code postal" maxlength="20" <?php if (isset($_POST['zipcode'])) {
                        echo 'value="'.$_POST['zipcode'].'"';
                    }?> required>
                        </div>
                        <!-- Ville -->
                        <div class="form-group col-md-6" title="Ville">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" class="form-control" placeholder="Ville"
                                maxlength="60" <?php if (isset($_POST['city'])) {
                        echo 'value="'.$_POST['city'].'"';
                    }?> required>
                        </div>
                        <!-- Pays -->
                        <div class="form-group col-md-4" title="Pays">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" class="form-control" placeholder="Pays"
                                maxlength="60" <?php if (isset($_POST['country'])) {
                        echo 'value="'.$_POST['country'].'"';
                    }?> required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Mail -->
                        <div class="form-group col-md-6">
                            <label for="mail" class="font-weight-bold">Adresse mail</label>
                            <input id="mail" type="email" name="mailSubscribe" class="form-control" placeholder="Mail"
                                maxlength="255" <?php if (isset($_POST['mailSubscribe'])) {
                        echo 'value="'.$_POST['mailSubscribe'].'"';
                    }?> required>

                        </div>
                        <!-- Telephone -->
                        <div class="form-group col-md-6">
                            <label for="phoneNumber" class="font-weight-bold">Numéro de téléphone</label>
                            <input id="phoneNumber" type="tel" name="phoneNumber" class="form-control"
                                placeholder="Téléphone" maxlength="20" <?php if (isset($_POST['phoneNumber'])) {
                        echo 'value="'.$_POST['phoneNumber'].'"';
                    }?> required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Mot de passe</h2>
                <div class="container">
                    <div class="row">
                        <!-- mot de passe 1 -->
                        <div class="form-group col-md-6">
                            <label for="passwordSubscribe1" class="font-weight-bold">Mot de passe</label>
                            <input id="passwordSubscribe1" type="password" name="passwordSubscribe1"
                                class="form-control" placeholder="Saisir un mot de passe" maxlength="255" <?php if (isset($_POST['passwordSubscribe1'])) {
                        echo 'value="'.$_POST['passwordSubscribe1'].'"';
                    }?> required>
                        </div>
                        <!-- mot de passe 2 -->
                        <div class="form-group col-md-6">
                            <label for="passwordSubscribe2" class="font-weight-bold">Confirmation mot de passe</label>
                            <input id="passwordSubscribe2" type="password" name="passwordSubscribe2"
                                class="form-control" placeholder="Confirmer le mot de passe" maxlength="255" <?php if (isset($_POST['passwordSubscribe2'])) {
                        echo 'value="'.$_POST['passwordSubscribe2'].'"';
                    }?> required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Identifiant et mot de passe de connexion aux sites de diffusion</h2>
                <div class="container">
                    <div class="row">
                        <!-- Mail pour connexion site de diffusion -->
                        <div class="form-group col-md-6">
                            <label for="loginSiteWeb" class="font-weight-bold">Adresse mail</label>
                            <input id="loginSiteWeb" type="email" name="loginSiteWeb" class="form-control"
                                placeholder="Mail" maxlength="255" <?php if (isset($_POST['loginSiteWeb'])) {
                        echo 'value="'.$_POST['loginSiteWeb'].'"';
                    }?> required>
                        </div>
                        <!-- mot de passe pour connexion site de diffusion -->
                        <div class="form-group col-md-6">
                            <label for="passwordSiteWeb" class="font-weight-bold">Mot de passe</label>
                            <input id="passwordSiteWeb" type="text" name="passwordSiteWeb" class="form-control"
                                placeholder="Mot de passe" maxlength="255" <?php if (isset($_POST['passwordSiteWeb'])) {
                        echo 'value="'.$_POST['passwordSiteWeb'].'"';
                    }?> required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bouton submit -->
            <div class="container pt-3">
                <button id="buttonSubscribe" type="submit"
                    class="btn btn-primary offset-md-5 col-md-2">S'inscrire</button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');
