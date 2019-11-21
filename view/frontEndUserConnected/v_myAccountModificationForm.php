<?php
$title = "Modifier mon compte";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">
            <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] && $_SESSION['id']!=$userDataToModify['user_id']){echo 'Modifier le compte de '.$userDataToModify['user_name'].' '.$userDataToModify['user_firstName'];}else{echo 'Modifier mon compte';}?>
        </h1>
        <form method="post"
            action="<?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){echo 'index.php?page=modifyMyAccount&userId='.$userId.'';}else{echo 'index.php?page=modifyMyAccount';}?>"
            onsubmit="spinnerSubmitButton()">
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <?php if (isset($error)){echo '<p class="font-weight-bold text-danger py-3">Veuillez corriger les erreurs</p>';}?>
                <h2>Coordonnées</h2>
                <div class="container">
                    <div class="row">
                    <!-- Civilité -->
                    <div class="form-group col-lg-2">
                            <label for="civility" class="font-weight-bold">Civilité</label>
                            <select id="civility" name="civility" class="custom-select">
                                <option value="Madame"
                                    <?php if ($userDataToModify['user_civility'] == 'Madame') {echo "selected";}?>>Madame</option>
                                <option value="Monsieur"
                                    <?php if ($userDataToModify['user_civility'] == 'Monsieur') {echo "selected";}?>>Monsieur</option>
                            </select>
                            <?php if (isset($fillingError['civility'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['civility']?></p>
                        <?php } ?>
                        </div>
                        <!-- Nom -->
                        <div class="form-group col-lg-5">
                            <label class="font-weight-bold" for="name">Nom</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nom"
                                value="<?php if($fillingError && isset($_POST['name'])){
                                    echo $_POST['name'];
                                }else{
                                    echo $userDataToModify['user_name'];
                                }?>" maxlength="125" required>
                                <?php if (isset($fillingError['name'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['name']?></p>
                        <?php } ?>
                        </div>
                        <!-- Prénom -->
                        <div class="form-group col-lg-5">
                            <label class="font-weight-bold" for="firstName">Prénom</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Prénom"
                                value="<?php if($fillingError && isset($_POST['firstName'])){
                                    echo $_POST['firstName'];
                                }else{
                                    echo $userDataToModify['user_firstName'];
                                }?>" maxlength="125" required>
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
                                value="<?php if($fillingError && isset($_POST['dateOfBirth'])){
                                    echo $_POST['dateOfBirth'];
                                }else{
                                    echo $userDataToModify['user_dateOfBirth'];
                                }?>"
                                required>
                                <?php if (isset($fillingError['dateOfBirth'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['dateOfBirth']?></p>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- Adresse -->
                    <div class="row">
                        <div class="form-group col-md-12" title="Numéro, nom de rue">
                            <label for="street" class="font-weight-bold">Numéro et nom de rue</label>
                            <input id="street" type="text" name="street" class="form-control"
                                placeholder="Saisir l'adresse du logement"
                                value="<?php if($fillingError && isset($_POST['street'])){
                                    echo $_POST['street'];
                                }else{
                                    echo $userDataToModify['address_street'];
                                }?>" maxlength="255" required>
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
                                placeholder="Code postal" value="<?php if($fillingError && isset($_POST['zipcode'])){
                                    echo $_POST['zipcode'];
                                }else{
                                    echo $userDataToModify['address_zipcode'];
                                }?>"
                                maxlength="20" required>
                                <?php if (isset($fillingError['zipcode'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['zipcode']?></p>
                        <?php } ?>
                        </div>
                        <!-- Ville -->
                        <div class="form-group col-md-8 col-lg-5" title="Ville">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" class="form-control" placeholder="Ville"
                                value="<?php if($fillingError && isset($_POST['city'])){
                                    echo $_POST['city'];
                                }else{
                                    echo $userDataToModify['address_city'];
                                }?>" maxlength="60" required>
                                <?php if (isset($fillingError['city'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['city']?></p>
                        <?php } ?>
                        </div>
                        <!-- Pays -->
                        <div class="form-group col-md-12 col-lg-4" title="Pays">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" class="form-control" placeholder="Pays"
                                value="<?php if($fillingError && isset($_POST['country'])){
                                    echo $_POST['country'];
                                }else{
                                    echo $userDataToModify['address_country'];
                                }?>" maxlength="60" required>
                                <?php if (isset($fillingError['country'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['country']?></p>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Mail -->
                        <div class="form-group col-md-6">
                            <label for="mail" class="font-weight-bold">Adresse mail</label>
                            <input id="mail" type="email" name="mail" class="form-control" placeholder="Mail" value="<?php if($fillingError && isset($_POST['mail'])){
                                    echo $_POST['mail'];
                                }else{
                                    echo $userDataToModify['user_mail'];
                                }?>" maxlength="255" required>
                            <?php if (isset($fillingError['mail'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['mail']?></p>
                        <?php } ?>
                        </div>
                        <!-- Telephone -->
                        <div class="form-group col-md-6">
                            <label for="phoneNumber" class="font-weight-bold">Numéro de téléphone</label>
                            <input id="phoneNumber" type="tel" name="phoneNumber" class="form-control"
                                placeholder="Téléphone" value="<?php if($fillingError && isset($_POST['phoneNumber'])){
                                    echo $_POST['phoneNumber'];
                                }else{
                                    echo $userDataToModify['user_phoneNumber'];
                                }?>"
                                maxlength="20" required>
                                <?php if (isset($fillingError['phoneNumber'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['phoneNumber']?></p>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bouton submit -->
            <div class="container pt-3">
                <button id="submitButton" type="submit"
                    class="btn btn-primary offset-md-5 col-md-2">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<script src="public/js/spinnerSubmitButton.js"></script>
<script src="public/js/redBorder.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');