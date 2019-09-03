<?php
$title='Liste des voyages-Connecté';
ob_start();
include('view/includes/navbar1.php');
?>
<section class="Voyages">
    <?php
    foreach($travels as $travel) {?>
    <article>
        <h2><?=$travel['title']?></h2>
        <?php if ($travel['image']!=null) {?>
        <img src="public/images/<?=$travel['image']?>">
        <?php
        }
        ?>
        <p><?=$travel['content']?></p>
    </article>
<?php
    }
?>
</section>
<?php
$content = ob_get_clean();
require('view/frontEnd/template.php');