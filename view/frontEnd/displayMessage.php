<?php
$title = "Message";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <div class="container col-md-9 col-lg-6">
            <p class="text-center font-weight-bold py-3">
            <?php if(isset($message) && !empty($message)){
                echo $message;
            }?>
            </p>
            <p  class="text-center"><a href="index.php">Retour à l'accueil</a></p>
        </div>
    </div>
</div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');