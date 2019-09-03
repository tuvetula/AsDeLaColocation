<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">As de la colocation</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><span class="sr-only">(current)</span></a>
                </li>

                <?php
      if (isset($_SESSION['login']) && isset($_SESSION['isAdmin'])){
          // <!--Menu Utilisateur connecté et non-admin-->
        if (!$_SESSION['isAdmin']){?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=homeUser">Mon profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=addAnAdvertisement">Déposer une annonce</a>
                </li>
            </ul>
            <a href="index.php?disconnect=1" class="btn btn btn-danger pull-right" role="button" aria-pressed="true">Se
                déconnecter</a>

            <?php
        }else{
          //Menu utilisateur connecté et admin
          ?>
            <li class="nav-item">
                <a class="nav-link" href="#">Mon profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=addAnAdvertisement">Déposer une annonce</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Supprimer un utilisateur</a>
            </li>

            </ul>
            <a href="index.php?disconnect=1" class="btn btn btn-danger pull-right" role="button" aria-pressed="true">Se
                déconnecter</a>
            <?php
        }
      }else{
        //Menu utilisateur non-connecté
        ?>
            </ul>
            <?php
            }
            ?>
        </div>
    </nav>
</header>