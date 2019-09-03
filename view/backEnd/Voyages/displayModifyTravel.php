<?php
$title="Modifier un commentaire";
ob_start();
include('view/includes/navbar1.php');
?>
<?php if(!isset($requestOk)){?>

<div class="formConnect">
    <form action="index.php" method="post">
        <label for="modifyTravel">Sélectionner un voyage à modifier</label>
        <select id="modifyTravel" name="modifyTravel">

            <?php 
            while($data = $insert->fetch()){?>
                <option value="<?=$data['id'];?>"><?=$data['title'];?></option>
       <?php }?>
        </select>
        <button type="submit">Rechercher</button>
    </form>
</div>
<?php

    }else if (isset($requestOk) && !empty($requestOk)){
    ?>
    <div class="formConnect">
        <form action="index.php?idTravel=<?=$requestOk['id'];?>" method="post">
        <input type="text" name="titleModify" value="<?=$requestOk['title']?>">
        <textarea name="contentModify" cols="50" rows="20"><?=$requestOk['content']?></textarea>
            <button type="submit">Modifier</button>
        </form>
    </div>
<?php
}


$content = ob_get_clean();
require('view/frontEnd/template.php');