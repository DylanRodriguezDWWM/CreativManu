<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créativ'Manu - Objets personnalisés pour vos événements</title>
        <meta name="description" content="Découvrez notre sélection d'objets que vous pouvez personnaliser pour tous vos événements spéciaux. Que ce soit pour un mariage, une naissance ou tout autre événement, nous avons ce qu'il vous faut pour rendre votre journée encore plus spéciale.">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


    <main>
    <?php include './includes/header.php'; ?>
        <h2 id="textoccasions">Pour toutes les occasions</h2>

        <section id="occasions">
            <div class="container1">
                <div class="image" id="containerMariage">
                    <a href="produits-Mariage.php" aria-label="Redirection sur la page produit Mariage"><img id="mariage" src="./img/figurine-de-mariage-esprit-champetre.jpg" alt=""></a>
                    <div id="mariageBox">
                        <p class="mariaget">Mariage</p>
                    </div>
                </div>
                
                <div class="image" id="containerNaissance">
                    <a href="produits-Naissance.php" aria-label="Redirection sur la page produit Naissance"><img id="naissance" src="./img/naissance.jpg" alt=""></a>
                    <div id="naissanceBox">
                        <p class="naissancet">Naissance</p>
                    </div>
                </div>

                <div class="image" id="containerBapteme">
                    <a href="produits-Bapteme.php" aria-label="Redirection sur la page produit Baptême"><img id="bapteme" src="./img/baptême.jpg" alt=""></a>
                    <div id="baptemeBox">
                        <p class="baptemet">Baptême</p>
                    </div>
                </div>
                
                <div class="image" id="containerNoel">
                    <a href="produits-Noel.php" aria-label="Redirection sur la page produit noel"><img id="noel" src="./img/noel.jpg" alt=""></a>
                    <div id="noelBox">
                        <p class="noelt">Noël</p>
                    </div>
                </div>
            </div>
        </section>

        <h2 id="textsupports">Pour tous les supports</h2>

        <section id="supports">
            <div class="container2">
                <div class="image" id="containerBois">
                    <img src="./img/bois.jpg" alt="">
                    <div id="boisBox">
                        <p class="boist">Bois</p>
                    </div>
                </div>
                
                <div class="image" id="containerTissu">
                    <img src="./img/tissu.jpg" alt="">
                    <div id="tissuBox">
                        <p class="tissut">Tissu</p>
                    </div>
                </div>

                <div class="image" id="containerPlastique">
                    <img src="./img/plastique.webp" alt="">
                    <div id="plastiqueBox">
                        <p class="plastiquet">Plastique</p>
                    </div>
                </div>
                
                <div class="image" id="containerVerre">
                    <img src="./img/verre.webp" alt="">
                    <div id="verreBox">
                        <p class="verret">Verre</p>
                    </div>
                </div>
            </div>
        </section>
        
        <footer>
            <?php include './includes/footer.php'; ?>
        </footer>

    </main>
</body>
</html>
