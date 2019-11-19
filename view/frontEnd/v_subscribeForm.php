<?php
$title = "Page d'inscription";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Inscription</h1>
        <form id="form1" method="post" action="index.php?page=saveSubscribe" onsubmit="spinnerSubmitButton()">
            <div class="container px-md-3 pb-sm-1 pb-md-2 pb-lg-3 pt-sm-1 pt-md-2 pt-lg-3 border-bottom border-dark">
                <?php
                    if (isset($error) && !empty($error)) {
                        echo '<p class="font-weight-bold text-danger py-3">'.$error.'</p>';
                    }?>
                    <?php if (isset($fillingError)){ ?>
                        <p class="text-danger font-weight-bold pb-1">Veuillez corriger les erreurs</p>
                        <?php } ?>
                <h2>Coordonnées</h2>
                <div class="container">
                    <div class="row">
                    <!-- Civilité -->
                    <div class="form-group col-lg-2">
                            <label for="civility" class="font-weight-bold">Civilité</label>
                            <select id="civility" name="civility" class="custom-select">
                                <option value="Madame"
                                    <?php if (isset($_POST['civility']) && $_POST['civility'] == 'Madame') {
                        echo "selected";
                    } elseif (!isset($_POST['civility'])) {
                        echo "selected";
                    }?>>
                                    Madame</option>
                                <option value="Monsieur"
                                    <?php if (isset($_POST['civility']) && $_POST['civility'] == 'Monsieur') {
                        echo "selected";
                    }?>>
                                    Monsieur</option>
                            </select>
                        </div>
                        <!-- Nom -->
                        <div class="form-group col-lg-5">
                            <label class="font-weight-bold" for="name">Nom</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nom"
                                maxlength="125" <?php if (isset($_POST['name'])) {
                        echo 'value="'.$_POST['name'].'"';
                    } ?> required>
                    <?php if (isset($fillingError['name'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['name']?></p>
                        <?php } ?>
                        </div>
                        <!-- Prénom -->
                        <div class="form-group col-lg-5">
                            <label class="font-weight-bold" for="firstName">Prénom</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Prénom"
                                maxlength="125" <?php if (isset($_POST['firstName'])) {
                        echo 'value="'.$_POST['firstName'].'"';
                    } ?> required>
                    <?php if (isset($fillingError['firstName'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['firstName']?></p>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- Date de naissance -->
                    <div class="row">
                    <div class="form-group col-lg-4" title="Date de naissance">
                            <label for="dateOfBirth" class="font-weight-bold">Date de naissance</label>
                            <input class="form-control" type="date" id="dateOfBirth"
                                name="dateOfBirth"
                                value="<?php if(isset($_POST['dateOfBirth'])){echo $_POST['dateOfBirth'];}?>"
                                required>
                                <?php if (isset($fillingError['dateOfBirth'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['dateOfBirth']?></p>
                        <?php } ?>
                        </div>
                        </div>
                        <!-- Adresse -->
                        <div class="row">
                        <div class="form-group col-md-12" title="Numéro, nom de rue">
                            <label for="street" class="font-weight-bold">Adresse</label>
                            <input id="street" type="text" name="street" class="form-control"
                                placeholder="Numéro et nom de rue" maxlength="255" <?php if (isset($_POST['street'])) {
                        echo 'value="'.$_POST['street'].'"';
                    } ?> required>
                    <?php if (isset($fillingError['street'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['street']?></p>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Code postal -->
                        <div class="form-group col-md-4 col-lg-3" title="Code postal">
                            <label for="zipcode" class="font-weight-bold">Code postal</label>
                            <input id="zipcode" type="text" name="zipcode" class="form-control"
                                placeholder="Code postal" maxlength="20" <?php if (isset($_POST['zipcode'])) {
                        echo 'value="'.$_POST['zipcode'].'"';
                    }?> required>
                     <?php if (isset($fillingError['zipcode'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['zipcode']?></p>
                        <?php } ?>
                        </div>
                        <!-- Ville -->
                        <div class="form-group col-md-8 col-lg-5" title="Ville">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" class="form-control" placeholder="Ville"
                                maxlength="60" <?php if (isset($_POST['city'])) {
                        echo 'value="'.$_POST['city'].'"';
                    }?> required>
                    <?php if (isset($fillingError['city'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['city']?></p>
                        <?php } ?>
                        </div>
                        <!-- Pays -->
                        <div class="form-group col-md-12 col-lg-4" title="Pays">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" class="form-control" placeholder="Pays"
                                maxlength="60" <?php if (isset($_POST['country'])) {
                        echo 'value="'.$_POST['country'].'"';
                    }?> required>
                    <?php if (isset($fillingError['country'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['country']?></p>
                        <?php } ?>
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
                    <?php if (isset($fillingError['mailSubscribe'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['mailSubscribe']?></p>
                        <?php } ?>
                        </div>
                        <!-- Telephone -->
                        <div class="form-group col-md-6">
                            <label for="phoneNumber" class="font-weight-bold">Numéro de téléphone</label>
                            <input id="phoneNumber" type="tel" name="phoneNumber" class="form-control"
                                placeholder="Téléphone" maxlength="20" <?php if (isset($_POST['phoneNumber'])) {
                        echo 'value="'.$_POST['phoneNumber'].'"';
                    }?> required>
                    <?php if (isset($fillingError['phoneNumber'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['phoneNumber']?></p>
                        <?php } ?>
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
                    <?php if (isset($fillingError['passwordSubscribe1'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['passwordSubscribe1']?></p>
                        <?php } ?>
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
            <!-- Bouton submit -->
            <div class="container pt-3">
                <button id="submitButton" type="submit"
                    class="btn btn-primary offset-md-5 col-md-2">S'inscrire</button>
            </div>
        </form>
    </div>
</div>
<script src="public/js/spinnerSubmitButton.js"></script>
<script src="public/js/redBorder.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');
