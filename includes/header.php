<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    
    <link rel="preload" href="./img/banner.webp" as="image">
    <link rel="preload" href="./img/tissu.webp" as="image">
    <link rel="preload" href="./img/naissance.webp" as="image">
</head>

<body>
    <header>
        <div class="logo-header">
            <a href="index.php">
                <img id="logo" src="img/cm.svg" alt="Logo de Créativ'Manu">
            </a>
        </div>

        <p id="titre-container">
            <a id="Titre" href="index.php">Créativ'Manu</a>
        </p>

        <input class="search" type="search" placeholder="Veuillez saisir votre recherche" aria-label="Champ de recherche">

        <div class="icons">
            <img id="panier" src="icn/panier.png" alt="Icône de panier">
            <a href="login.php"><img id="user" src="icn/utilisateur.png" alt="Espace membre"></a>
        </div>
    </header>
    
    <nav id="navbar">
        <ul class="list">
            <li class="produits"><a href="./produits.php">Produits</a></li>
            <li class="propos"><a href="propos.php">À propos</a></li>
            <li class="contacts"><a href="contact.php">Contacts</a></li>
            <?php
                if (isset($_SESSION["user"]["id_role"]) && $_SESSION["user"]["id_role"] == 766667) {
                    // L'utilisateur est connecté en tant qu'administrateur
                    echo '<li class="logout"><a href="logout.php">Déconnexion</a></li>';
                    echo '<li class="dashboard"><a href="dashboardAdmin.php">Tableau de bord Admin</a></li>';
                } else if (isset($_SESSION["user"]["id_role"]) && $_SESSION["user"]["id_role"] == 5) {
                    // L'utilisateur est connecté en tant qu'utilisateur
                    echo '<li class="logout"><a href="logout.php">Déconnexion</a></li>';
                    echo '<li class="dashboard"><a href="dashboard.php">Tableau de bord</a></li>';
                } else {
                    // L'utilisateur n'est pas connecté ou n'est pas un administrateur
                    echo '<li class="login"><a href="login.php">Connexion</a></li>';
                    echo '<li class="signup"><a href="signup.php">Inscription</a></li>';
                    session_destroy();
                }
            ?>
        </ul>
    </nav>
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="./img/banner.webp" alt="Bannière de Créativ'Manu">
        </div>
        
        <div class="mySlides fade">
            <img src="./img/tissu.webp" alt="Image de tissu">
        </div>
        
        <div class="mySlides fade">
            <img src="./img/naissance.webp" alt="Image de produit pour naissance">
        </div>
        
        <div style="text-align:center">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>
    </div>
    <script src="./js/script.js"></script>
</body>
</html>