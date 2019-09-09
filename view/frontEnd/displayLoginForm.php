<?php
$title = "Page de connexion";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Formulaire de connexion</h1>
        <div id="loginForm" class="container col-lg-6 col-md-9 col-sm-12">
            <form method="post" action="index.php" class="text-center">
                <div class="form-group text-left">
                    <label for="exampleInputEmail1">Identifiant</label>
                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail2" name="login"
                        placeholder="Saisir votre adresse mail" required>
                </div>
                <div class="form-group text-left">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password"
                        placeholder="Saisir votre mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <div id="forgotPasswordContainer" class="container text-right">
            <a href="#">Mot de passe oublié?</a>
            </div>
        </div>
    </div>
</div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');