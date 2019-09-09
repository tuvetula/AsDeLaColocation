<?php
$title = "Modifier mon compte";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Modifier mon compte</h1>
    </div>
</div>



<?php
$content = ob_get_clean();
require('view/includes/template.php');