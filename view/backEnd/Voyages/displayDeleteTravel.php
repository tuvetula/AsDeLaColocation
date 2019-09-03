<?php
$title="Supprimer un voyage";
ob_start();
include('view/includes/navbar1.php');
?>
<div class="formConnect">
    <form action="index.php" method="post">
        <label for="deleteTravel">Sélectionner un voyage à supprimer</label>
        <select id="deleteTravel" name="deleteTravel">
            <?php while($data = $insert->fetch()){?>
                <option value="<?=$data['id'];?>"><?=$data['title'];?></option>
       <?php }?>
        </select>
        <button type="submit">Supprimer</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require('view/frontEnd/template.php');