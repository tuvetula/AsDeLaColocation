<?php
$title = "Réinitialisation mot de passe";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Réinitialisation mot de passe</h1>
        <div class="container col-md-9 col-lg-6">
            <form method="post" action="index.php?mail=<?=$mail?>" class="text-center">
                <div class="form-group text-left">
                    <label for="passwordReinitialization1">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="passwordReinitialization1" name="passwordReinitialization1"
                        placeholder="Saisir un nouveau mot de passe" maxlength="255" required>
                </div>
                <div class="form-group text-left">
                    <label for="passwordReinitialization2">Confirmation mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="passwordReinitialization2" name="passwordReinitialization2"
                        placeholder="Répéter le mot de passe" maxlength="255" required>
                </div>
                <div class="container">
                    <button type="submit" class="btn btn-primary">Soumettre</button>
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