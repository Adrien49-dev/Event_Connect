<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/94044ae3e0.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <header>
        <?php
        // Vérifiez si la page actuelle est la page de connexion
        if (!(isset($_GET['controller']) && $_GET['controller'] == 'Login' && isset($_GET['action']) && $_GET['action'] == 'connexion')) {
            // Affiche le header uniquement si ce n'est pas la page de connexion
            $isUserLoggedIn = isset($_SESSION['id_user']); ?>

            <div class="video-container">
                <video autoplay muted loop class="header-video">
                    <source src="../Public/festival.mp4" type="video/mp4">
                </video>
                <div id="titre">
                    <h1>Saucisse Merguez Festival</h1>
                    <h2>Les 25/26/27 Aout 2025 <br> Angers</h2>
                </div>
            </div>

            <!-- -------------------- Burger Menu ------------------------ -->
            <div class="burger-menu-button">
                <i class="fa-solid fa-bars fa-3x"></i>
            </div>
            <div class="burger-menu">
                <ul class="links">
                    <?php
                    if (isset($_SESSION['statut']) && ($_SESSION['statut'] == "admin")) {
                    ?>
                        <li><a href="index.php?controller=Admin&action=dashboard">Dashboard</a></li>
                    <?php } ?>
                    <li><a href="index.php?controller=Accueil&action=home">Accueil</a></li>
                    <li><a href="index.php?controller=Categorie&action=displayAllCategorie">Programmation</a></li>
                    <li><a href="index.php?controller=Reservation&action=getUserReservations">Mes réservations</a></li>
                    <li><a href="index.php?controller=Contact&action=showContactForm">Contact</a></li>
                    <div class="divider"></div>
                    <div class="buttons-burger-menu">
                        <nav>
                            <ul>
                                <!-- Si l'utilisateur est connecté, afficher "Déconnexion" -->
                                <?php if ($isUserLoggedIn) : ?>
                                    <li><a href="index.php?controller=Login&action=deconnexion">Déconnexion</a></li>
                                <?php else : ?>
                                    <!-- Sinon, afficher "Connexion" -->
                                    <li><a href="index.php?controller=Login&action=connexion">Connexion</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </ul>
            </div>

        <?php } ?>
    </header>

    <main>