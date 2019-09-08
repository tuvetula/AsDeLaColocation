<?php
$title = "Bienvenue";
ob_start();
?>
<div id='screen'>
    <div id="displayHomeUser" class="container">
        <div class="jumbotron">
            <h1 class="text-center">Erreur</h1>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once('view/includes/template.php');