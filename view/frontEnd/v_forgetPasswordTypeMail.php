<?php
$title = "Mot de passe oublié";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Formulaire de récupération de mot de passe</h1>
        <div class="container col-md-9 col-lg-6">
            <form method="post" action="index.php" class="text-center">
                <div class="form-group text-left">
                    <label for="mailForgetPassword">Adresse mail</label>
                    <input type="email" class="form-control form-control-lg" id="mailForgetPassword" name="mailForgetPassword"
                        placeholder="Saisir votre adresse mail" maxlength="255" <?php if (isset($_POST['mailForgetPassword'])) {
                        echo 'value="'.$_POST['mailForgetPassword'].'"';
                    } ?>required>
                </div>
                <div class="container">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
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
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');