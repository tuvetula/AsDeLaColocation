<?php
$title = "Bienvenue";
ob_start();
?>
<div class="container">
    <div id="myadvertisements" class="jumbotron">

    </div>

</div>



<script src="public/js/displayUserAdvertisement.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');
