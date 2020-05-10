<nav class="navbar navbar-dark navbar-expand-sm fixed-top flex-md-row border-bottom">
        <a class="navbar-brand" href="../public/index.php">Blog Jean Forteroche</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="animated-icon"><span></span><span></span><span></span><span></span></div>
        </button>
  
        <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php">Les Romans</a>
                </li>
                <?php
                if ($this->session->get('pseudo')) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php?route=logout">Déconnexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php?route=profile">Profil</a>
                </li>
                    <?php if($this->session->get('role') === 'admin') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php?route=administration">Administration</a>
                </li>
                    <?php } ?>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../public/index.php?route=register">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../public/index.php?route=login">Connexion</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
</nav>
