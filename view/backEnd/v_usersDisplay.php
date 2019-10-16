<?php
$title = "Liste des utilisateurs";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Liste des utilisateurs</h1>
        <!-- Affichage message de confirmation ou d'erreur -->
        <?php
                    if ($error){
                        echo '<p class="text-danger font-weight-bold p-3">'.$error.'</p>';
                    } else if ($message){
                        echo '<p class="text-danger font-weight-bold p-3">'.$message.'</p>';
                    }
                ?>
        <div class="container">
            <div class="row">
                <form method="post" action="index.php?page=searchUser" class="offset-md-3 col-md-6 text-center">
                    <input id="searchBar" type="text" class="col-md-12" placeholder="Recherche">
                    <!--<button type="submit" class="btn btn-primary col-md-2">Chercher</button>-->
                </form>
            </div>
        </div>
        <?php
        $countForIdButton = 0;
    foreach ($usersArray as $key => $value) {
        ?>
        <div class="card m-0 p-3 my-3 m-md-3">
            <div class="row">
                <div class="userInfo col-sm-12 col-md-8 col-lg-9">
                    <h5 class="mt-0 font-weight-bold">
                        <?=$usersArray[$key]['user_name'].' '.$usersArray[$key]['user_firstName']?></h5>
                    <p><?=$usersArray[$key]['user_mail']?></p>
                </div>
                <!--BOUTONS-->
                <div id="buttonsAdvertisement" class="col-sm-12 col-md-6 col-lg-3 pt-3 pt-md-0">
                    <div class="row">
                        <!-- Bouton switch isActive -->
                        <div class="col-6 text-center custom-control custom-switch">
                            <input type="checkbox" onchange="changeIsMemberState(<?=$usersArray[$key]['user_id']?>)"
                                class="custom-control-input" id="customSwitches<?=$countForIdButton?>" <?php
                        if ($usersArray[$key]['user_isMember']) {
                            echo 'checked';
                        } ?>>
                            <label class="custom-control-label" title="Activer/Désactiver"
                                for="customSwitches<?=$countForIdButton?>"></label>
                        </div>
                        <!-- Bouton modifier -->
                        <div class="col-6 text-center">
                            <a href="index.php?page=displayUserAdvertisement&userId=<?=$usersArray[$key]['user_id']?>"><img
                                    src="public/pictures/icons/iconeAnnonce32.png"
                                    alt="Voir les annonces de l'utilisateur"
                                    title="Voir les annonces de l'utilisateur"></a>
                        </div>
                        <!-- Bouton Supprimer
                        <div class="col-4 text-center">
                            <a href="#"
                                onclick="confirmationDeleteUser('<?=$deleteUrl?>','<?=$usersArray[$key]['user_id']?>')"><img
                                    src="public/pictures/icons/iconeDelete32.png" alt="supprimer l'annonce"
                                    title="Supprimer"></a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php
        $countForIdButton++;
    }
        ?>
        <script src="public/js/searchBarSelect.js"></script>
        <script src="public/js/changeIsMemberState.js"></script>
        <?php
$content = ob_get_clean();
require('view/includes/template.php');