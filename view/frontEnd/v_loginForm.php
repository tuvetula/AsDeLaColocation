<?php
$title = "Page de connexion";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Formulaire de connexion</h1>
        <div class="container col-md-9 col-lg-6">
            <form method="post" action="index.php" class="text-center">
                <div class="form-group text-left">
                    <label for="mail">Identifiant</label>
                    <input type="email" class="form-control form-control-lg" id="mailLogin" name="mailLogin"
                        placeholder="Saisir votre adresse mail" maxlength="255" <?php if (isset($_POST['mailLogin'])) {
                        echo 'value="'.$_POST['mailLogin'].'"';
                    }?> required>
                </div>
                <div class="form-group text-left">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="passwordLogin"
                        name="passwordLogin" placeholder="Saisir votre mot de passe" maxlength="255" required>
                </div>
                <div class="container">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
                <?php
                    if (isset($error) && !empty($error)){
                        echo '<p class="text-center text-danger font-weight-bold p-3">'.$error.'</p>';
                    } else if (isset($message) && !empty($message)){
                        echo '<p class="text-center text-danger font-weight-bold p-3">'.$message.'</p>';
                    }
                ?>
            </form>

            <div class="container text-right">
                <a href="index.php?page=displaySubscribeForm">Inscription</a>
            </div>
            <div class="container text-right">
                <a class="text-right" href="index.php?page=forgetPassword">Mot de passe oublié?</a>
            </div>
        </div>
    </div>
</div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');