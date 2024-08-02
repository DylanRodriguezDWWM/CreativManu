<?php
    include './includes/header.php';

    // Vérifier si l'utilisateur est connecté ou non 
    if (!isset($_SESSION["user"])) {
        // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
        header("Location: login.php");
        exit;
    }

    // Connexion à la base de données
    include './config/config_local.php';

    // Récupérer tous les utilisateurs avec l'id_role 5 (utilisateur) pour les afficher dans un tableau et les supprimer si nécessaire.
    $query = $pdo->query("SELECT * FROM utilisateur WHERE id_role = 5");
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer tous les articles avec leurs catégories
    $sql = "SELECT article.*, categorie.nom_categorie
    FROM article
    INNER JOIN categorie ON article.id_categorie = categorie.id_categorie";
    $query = $pdo->prepare($sql);
    $query->execute();
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer toutes les catégories
    $query = $pdo->query("SELECT * FROM categorie");
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);


    // Vérifier si l'ID de l'utilisateur à supprimer est envoyé en POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])){
        // Préparer la requête SQL pour supprimer un utilisateur
        $sql = "DELETE FROM utilisateur WHERE id_user = :id";
        $query = $pdo->prepare($sql);

        // Lier les paramètres de la requête préparée avec les valeurs reçues du formulaire POST
        $query->bindParam(':id', $_POST["delete_id"], PDO::PARAM_INT);

        // Exécuter la requête préparée pour supprimer l'utilisateur de la base de données en utilisant son ID
        $query->execute();

        // Rediriger vers la même page pour voir les changements
        header("Location: dashboardAdmin.php");
        exit;
    }

    // Récupérer le prénom de l'utilisateur de la session pour l'afficher dans le tableau de bord après la connexion
    $prenom = $_SESSION["user"]["prenom"];
    $nom_famille = $_SESSION["user"]["nom_famille"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tableau de bord Admin</title>
        <link rel="stylesheet" href="./css/dashboards.css">
    </head>
    <body>
        <div id="conteneurPrincipal">
            <nav id="barreLaterale">
                <ul>
                    <li><a href="#sectionCommandes">Commandes à préparer</a></li>
                    <li><a href="#sectionUtilisateurs">Tous les utilisateurs</a></li>
                    <li><a href="#sectionCreationArticle">Créer un article</a></li>
                    <li><a href="#sectionArticles">Tous les articles</a></li>
                    <li><a href="#logo">Remonter la page</a></li>
                </ul>
            </nav>

            <main id="zoneContenu">
                <h2 id="messageAccueil">Bienvenue sur votre tableau de bord <?php echo ($prenom)," " ,($nom_famille)?></h2>

                <section id="sectionCommandes">
                    <h3>Commandes à préparer</h3>
                    <table id="tableauCommandes">
                        <!-- Votre tableau de commandes ici -->
                    </table>
                </section>

                <section id="sectionUtilisateurs">
                    <h3>Tous les utilisateurs</h3>
                    <table id="tableauUtilisateurs">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Prénom</th>
                                <th>Nom de famille</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?> <!-- Utiliser une boucle pour afficher chaque utilisateur -->
                                <tr>
                                    <td><?php echo ($user['id_user']); ?></td>
                                    <td><?php echo ($user['prenom']); ?></td>
                                    <td><?php echo ($user['nom_famille']); ?></td>
                                    <td><?php echo ($user['mail']); ?></td>
                                    <td>
                                        <form method="POST" id="formulaireSuppressionUtilisateur">
                                            <!-- Ajouter un champ caché pour envoyer l'ID de l'utilisateur à supprimer -->
                                            <input type="hidden" name="delete_id" id="inputIdSuppression" value="<?php echo $user['id_user']; ?>">
                                            <input type="submit" value="Supprimer" id="boutonSuppressionUtilisateur">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <section id="sectionCreationArticle">
                    <h2>Créer un nouvel article</h2>
                    <form action="./actions/upload_article.php" method="post" enctype="multipart/form-data" id="formulaireCreationArticle">
                        Nom de l'article: <input type="text" name="nom_article" id="inputNomArticle"><br>
                        Image de l'article: <input type="file" name="image_article" id="inputImageArticle"><br>
                        Description de l'article: <input type="text" name="description_article" id="inputDescriptionArticle"><br>
                        Prix de l'article: <input type="text" name="prix_article" id="inputPrixArticle"><br>
                        Stock de l'article: <input type="text" name="stock_article" id="inputStockArticle"><br>
                        <!-- ID de la catégorie: <input type="text" name="id_categorie" id="inputIdCategorie"><br> -->
                        <select name="id_categorie" id="inputIdCategorie">
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?php echo $categorie['id_categorie']; ?>">
                                    <?php echo $categorie['nom_categorie']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="Créer un article" id="boutonCreationArticle">
                    </form>
                </section>

                <section id="sectionArticles">
                    <h2>Liste de tous les articles</h2>
                    <table id="tableauArticles">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID de l'article</th>
                                    <th>Nom de l'article</th>
                                    <th>Description de l'article</th>
                                    <th>Prix de l'article</th>
                                    <th>Stock de l'article</th>
                                    <th>Nom de la catégorie</th>
                                    <th>Image de l'article</th>
                                </tr>
                            </thead>

                            <tbody id="tableauArticles">
                                <?php foreach ($articles as $article): ?>
                                    <tr>
                                        <td><?php echo ($article['id_article']); ?></td>
                                        <td><?php echo ($article['nom_article']); ?></td>
                                        <td><?php echo ($article['description_article']); ?></td>
                                        <td><?php echo ($article['prix_article']); ?></td>
                                        <td><?php echo ($article['stock_article']); ?></td>
                                        <td><?php echo ($article['nom_categorie']); ?></td>
                                        <td>
                                        <?php 
                                            $image_path = $article['image_article'];
                                            $image_url = './image_article/' . $image_path; // Chemin correct vers le dossier image_article

                                            if (file_exists(__DIR__ . '/image_article/' . $image_path)) {
                                                echo '<img src="' . $image_url . '" width="100" height="100">';
                                            } else {
                                                echo 'Image non disponible';
                                            }
                                        ?>
                                        </td>
                                        <td>
                                            <form method="post" action="./actions/delete_article.php">
                                                <input type="hidden" name="id_article" value="<?php echo $article['id_article']; ?>">
                                                <input type="submit" value="Supprimer" class="btn-supprimer">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                </main>
                
            </div>
        </body>
        <?php include './includes/footer.php'; ?>
    </html>