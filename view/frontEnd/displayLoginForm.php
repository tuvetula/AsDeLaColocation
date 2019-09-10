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
                    <input type="email" class="form-control form-control-lg" id="mail" name="mail"
                        placeholder="Saisir votre adresse mail" required>
                </div>
                <div class="form-group text-left">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="password"
                        name="password" placeholder="Saisir votre mot de passe" required>
                </div>
                <?php
                    if (!empty($error)){
                        echo '<p class="text-center">'.$error.'</p>';
                    }
                ?>
                <div class="container">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>

            <div class="container text-right">
                <a href="index.php?page=displaySubscribeForm">Inscription</a>
            </div>
            <div class="container text-right">
                <a class="text-right" href="#">Mot de passe oublié?</a>
            </div>
        </div>
    </div>
</div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');