<?php
$title = "Réinitialisation mot de passe";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Réinitialisation mot de passe</h1>
        <div class="container col-md-9 col-lg-6">
            <form method="post" action="index.php" class="text-center" onsubmit="spinnerSubmitButton()">
                <input type="hidden" name="userMail" value="<?=$mail?>">
                <?php if (isset($token)){?>
                <input type="hidden" name="userToken" value="<?=$token?>">
                <?php } ?>
                <?php if (isset($_SESSION['mail'])){ ?>
                <div class="form-group text-left">
                    <label class="font-weight-bold" for="oldPassword">Ancien mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="oldPassword" name="oldPassword"
                        placeholder="Saisir votre ancien mot de passe" maxlength="255" required>
                <?php if (isset($fillingError['oldPassword'])){ ?>
                        <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['oldPassword']?></p>
                        <?php } ?>
                </div>
                <?php
                }
                ?>
                <div class="form-group text-left">
                    <label class="font-weight-bold" for="passwordReinitialization1">Nouveau mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="passwordReinitialization1" name="passwordReinitialization1"
                        placeholder="Saisir un nouveau mot de passe" maxlength="255" required>
                    <?php if (isset($fillingError['passwordReinitialization1'])){ ?>
                    <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['passwordReinitialization1']?></p>
                    <?php } ?>
                </div>
                <div class="form-group text-left">
                    <label class="font-weight-bold" for="passwordReinitialization2">Confirmation du nouveau mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="passwordReinitialization2" name="passwordReinitialization2"
                        placeholder="Confirmer le nouveau mot de passe" maxlength="255" required>
                    <?php if (isset($fillingError['passwordReinitialization1'])){ ?>
                    <p class="text-danger font-weight-bold mb-0 pb-1" type="error"></p>
                    <?php } ?>
                </div>
                <div class="container">
                    <button id="submitButton" type="submit" class="btn btn-primary">Soumettre</button>
                </div>
                <?php
                    if (isset($error) && !empty($error)){
                        echo '<p class="text-center text-danger font-weight-bold pt-3">'.$error.'</p>';
                    }
                ?>
            </form>
        </div>
    </div>
</div>
<script src="public/js/spinnerSubmitButton.js"></script>
<script src="public/js/redBorder.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');