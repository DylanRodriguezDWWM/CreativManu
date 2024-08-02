<?php

session_start(); // Démarrer la session pour récupérer les données de l'utilisateur connecté dans la session et vérifier s'il est connecté ou non

// Vérifier si l'utilisateur est connecté ou non 
if (!isset($_SESSION["user"])) {
    // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header("Location: ../login.php");
    exit;
}

// Connexion à la base de données
include '../config/config_local.php';

// Vérifier si l'ID de l'article à supprimer est envoyé en POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_article"])){
    // Récupérer le chemin de l'image de l'article à supprimer
    $sql = "SELECT image_article FROM article WHERE id_article = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $_POST["id_article"], PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $image_path = $result['image_article'];

        // Supprimer l'image du dossier image_article
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Préparer la requête SQL pour supprimer un article
        $sql = "DELETE FROM article WHERE id_article = :id";
        $query = $pdo->prepare($sql);

        // Lier les paramètres de la requête préparée avec les valeurs reçues du formulaire POST
        $query->bindParam(':id', $_POST["id_article"], PDO::PARAM_INT);

        // Exécuter la requête préparée pour supprimer l'article de la base de données en utilisant son ID
        $query->execute();
    }

    // Rediriger vers la même page pour voir les changements
    header("Location: ../dashboardAdmin.php");
    exit;
}
?>