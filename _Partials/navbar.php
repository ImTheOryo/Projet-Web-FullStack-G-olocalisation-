<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Nom de l'entreprise</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?component=map">Carte de France</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?component=users">Listes des utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?component=sell_points">Points de ventes</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user "></i>
                        <?php echo $_SESSION['user_username']?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?logout=true">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>