<?php
$title = "Page de connexion";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Formulaire de récupération de mot de passe</h1>
        <div class="container col-md-9 col-lg-6">
            <form method="post" action="index.php" class="text-center">
                <div class="form-group text-left">
                    <label for="mail">Adresse mail</label>
                    <input type="email" class="form-control form-control-lg" id="mail" name="mailForgetPassword"
                        placeholder="Saisir votre adresse mail" maxlength="255" required>
                </div>
                <div class="container">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
                <?php
                    if (!empty($message)){
                        echo '<p class="text-center pt-3">'.$message.'</p>';
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