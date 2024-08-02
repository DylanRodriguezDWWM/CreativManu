<?php 
include './includes/header.php'; 

try {
    // Inclure le fichier de configuration pour établir la connexion PDO
    include './config/config_local.php';

    // Récupérer tous les articles de la catégorie "Baptême"
    $sql = "SELECT article.*, categorie.nom_categorie
    FROM article
    INNER JOIN categorie ON article.id_categorie = categorie.id_categorie
    WHERE categorie.nom_categorie = 'Baptême'
    ORDER BY article.id_article DESC";
    $query = $pdo->prepare($sql);
    $query->execute();
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de produits de baptême</title>
    <meta name="description" content="Explorez notre sélection de nouveaux articles de baptême. Chaque produit est présenté avec une image, le nom, la quantité en stock et le prix. Trouvez le cadeau de baptême parfait aujourd'hui.">
    <link rel="stylesheet" href="./css/articles.css">
</head>
<body>
    <main>
    
    <h2 id="textarticle">Nouveaux articles baptême</h2>
        
        <section id="containerArticlesMariages">
            <div id="produitsMariage">
            <?php 
            foreach($articles as $article) { 
            ?>
                <div class="articlesMariages" id="article<?php echo $article['id_article']; ?>">
                <?php 
                    $image_path = $article['image_article'];
                    $image_url = './image_article/' . $image_path; // Chemin correct vers le dossier image_article
                    
                    if (file_exists(__DIR__ . '/image_article/' . $image_path)) {
                        echo '<img src="' . $image_url . '" alt="Article ' . $article['id_article'] . '">';
                    } else {
                        echo 'Image non disponible';
                    }
                    ?>
                    <h3><?php echo $article['nom_article']; ?></h3>
                    <p>Quantité : <?php echo $article['stock_article']; ?></p>
                    <span>Prix : <?php echo $article['prix_article']; ?>€</span>
                    <select class="selectQuantity">
                        <?php 
                        for ($i = 0; $i <= $article['stock_article']; $i++) { 
                        ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php 
                        } 
                        ?>
                    </select>
                </div>
            <?php 
            } 
            ?>
            </div>
        </section>
    </main>
    <?php include './includes/footer.php'; ?>
</body>
</html>