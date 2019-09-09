<?php
$title = "Bienvenue";
ob_start();
?>
    <div class="screen container px-1 px-md-3">
        <div class="jumbotron">
            <h1 class="pb-3 text-center">Erreur</h1>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once('view/includes/template.php');