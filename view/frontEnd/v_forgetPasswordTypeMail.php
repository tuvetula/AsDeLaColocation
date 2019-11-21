<?php
$title = "Mot de passe oublié";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron px-1 px-md-3">
        <h1 class="pb-3 text-center">Formulaire de récupération de mot de passe</h1>
        <form method="post" action="index.php" onsubmit="spinnerSubmitButton()">
            <div class="form-group offset-md-2 col-md-8 offset-lg-3 col-lg-6">
                <label class="font-weight-bold" for="mailForgetPassword">Adresse mail</label>
                <input type="email" class="form-control form-control-lg" id="mailForgetPassword"
                    name="mailForgetPassword" placeholder="Saisir votre adresse mail" maxlength="255" <?php if (isset($_POST['mailForgetPassword'])) {
                        echo 'value="'.$_POST['mailForgetPassword'].'"';
                    } ?>required>
                <?php if (isset($fillingError['mailForgetPassword'])){ ?>
                <p class="text-danger font-weight-bold mb-0 pb-1" type="error"><?=$fillingError['mailForgetPassword']?></p>
                <?php } ?>
            </div>
            <div class="container text-center pt-3">
                <button id="submitButton" type="submit" class="btn btn-primary col-6 col-sm-4 col-lg-3">Envoyer</button>
            </div>
            <?php
                    if (isset($error) && !empty($error)){
                        echo '<p class="text-center font-weight-bold text-danger pt-3">'.$error.'</p>';
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