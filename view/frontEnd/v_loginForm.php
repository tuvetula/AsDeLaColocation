<?php
$title = "Page de connexion";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron px-1 px-md-3">
        <h1 class="pb-3 text-center">Formulaire de connexion</h1>
            <form method="post" action="index.php" onsubmit="spinnerSubmitButton()">
                <div class="form-group offset-md-2 col-md-8 offset-lg-3 col-lg-6">
                    <label for="mailLogin" class="font-weight-bold">Identifiant</label>
                    <input type="email" class="form-control form-control-lg" id="mailLogin" name="mailLogin"
                        placeholder="Saisir votre adresse mail" maxlength="255" <?php if (isset($_POST['mailLogin'])) {
                        echo 'value="'.$_POST['mailLogin'].'"';
                    }?> required>
                </div>
                <div class="form-group offset-md-2 col-md-8 offset-lg-3 col-lg-6">
                    <label for="passwordLogin" class="font-weight-bold">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="passwordLogin" name="passwordLogin"
                        placeholder="Saisir votre mot de passe" maxlength="255" required>
                </div>
                <div class="container text-center pt-3">
                    <button id="submitButton" type="submit" class="btn btn-primary col-6 col-sm-4 col-lg-3">Se connecter</button>
                </div>
                <?php
                    if (isset($error) && !empty($error)){
                        echo '<p class="text-center text-danger font-weight-bold p-3">'.$error.'</p>';
                    } else if (isset($message) && !empty($message)){
                        echo '<p class="text-center text-danger font-weight-bold p-3">'.$message.'</p>';
                    }
                ?>
            </form>

            <div class="container col-md-8 col-lg-6 text-right pt-3">
                <a href="index.php?page=displaySubscribeForm">Inscription</a>
            </div>
            <div class="container col-md-8 col-lg-6 text-right pt-1">
                <a class="text-right" href="index.php?page=forgetPassword">Mot de passe oublié?</a>
            </div>
    </div>
</div>
<script src="public/js/spinnerSubmitButton.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');