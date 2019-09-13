<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">As de la coloc</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <?php
                if (isset($_SESSION['mail']) && isset($_SESSION['isAdmin'])) {
                    // <!--Menu Utilisateur connecté et non-admin-->?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=myAdvertisements">Mes annonces</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=displayAddAnAdvertisement">Déposer une annonce</a>
                </li>
                <?php 
                    if ($_SESSION['isAdmin']) {
                        //Menu utilisateur connecté et admin
                        ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Utilisateurs</a>
                    </li>
                    <?php
                        } 
                        ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=displayMyAccount">Mon compte</a>
                </li>
                <?php
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['mail']) && isset($_SESSION['isAdmin'])) {
            ?>
            <a href="index.php?disconnect=1" class="btn btn btn-danger pull-right" role="button" aria-pressed="true">Se
                déconnecter</a>
            <?php
            }
            ?>
        </div>
    </nav>
</header>