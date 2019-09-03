<?php
$title='Ajouter un voyage';
ob_start();
include('view/includes/navbar1.php');

?>
<div class="formConnect">
        <h2>Formulaire d'ajout de voyage</h2>
        <form id="formConnectAddTravel" method="post" action="index.php" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Titre">
            <textarea type="text" cols="40" rows="15" name="content" placeholder="Commentaires"></textarea>
            <!--Limite la taille du fichier à télécharger-->
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
            <input type="file" name="image">
            <button type="submit">Ajouter</button>
        </form>
    </div>
    <?php 
        if(isset($_GET['error']) && $_GET['error']==1){
            echo 'chargement echoue';
        }
        ?>
<?php
//Affichage message confirmation
if(!is_null($message)){
    echo '<p>'.$message.'</p>';
}
$content = ob_get_clean();
require('view/frontEnd/template.php');