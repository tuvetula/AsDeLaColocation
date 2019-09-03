<?php
$title = "Bienvenue";
ob_start();
?>




<?php
$content = ob_get_clean();
require('view/includes/template.php');