<?php
// Connexion à la base de données
include '../config/config_local.php';

// Créer le dossier image_article s'il n'existe pas déjà
if (!file_exists('../image_article')) {
    mkdir('../image_article', 0777, true);
}

if (!empty($_POST)) {
    $nom_article = $_POST['nom_article'];
    $description_article = $_POST['description_article'];
    $prix_article = $_POST['prix_article'];
    $stock_article = $_POST['stock_article'];
    $id_categorie = $_POST['id_categorie'];
    $id_ajustement = isset($_POST['id_ajustement']) ? $_POST['id_ajustement'] : NULL;

    $image_article = null;
    if(isset($_FILES['image_article'])){
        $image_name = $_FILES['image_article']['name'];
        $target_dir = "../image_article/";
        $target_file = $target_dir . basename($image_name);

        // Déplacer le fichier uploadé vers le dossier image_article
        if (move_uploaded_file($_FILES['image_article']['tmp_name'], $target_file)) {
            $image_article = $target_file;
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }

    $sql = "INSERT INTO article (image_article, nom_article, description_article, prix_article, stock_article, id_categorie, id_ajustement) VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        $query = $pdo->prepare($sql);
        $query->execute([$image_article, $nom_article, $description_article, $prix_article, $stock_article, $id_categorie, $id_ajustement]);

        header("Location: ../dashboardAdmin.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>