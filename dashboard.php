<?php

    include './includes/header.php';


    if (!isset($_SESSION["user"])) {
        // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
        header("Location: login.php");
        exit;
    }

    // Récupérer l'ID de l'utilisateur de la session
    $id = $_SESSION["user"]["id_user"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $prenom = $_POST["prenom"];
        $nom_famille = $_POST["nom_famille"];
        $mail = $_POST["mail"];

        // Connexion à la base de données
        include "./config/config_local.php";

        // Préparer la requête SQL
        $sql = "UPDATE utilisateur SET prenom = :prenom, nom_famille = :nom_famille, mail = :mail WHERE id_user = :id";
        $query = $pdo->prepare($sql);

        // Lier les paramètres
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':nom_famille', $nom_famille, PDO::PARAM_STR);
        $query->bindValue(':mail', $mail, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT); // Utiliser l'ID de l'utilisateur

        // Exécuter la requête
        $query->execute();

        // Mettre à jour $_SESSION["user"] avec les nouvelles informations
        $_SESSION["user"]["prenom"] = $prenom;
        $_SESSION["user"]["nom_famille"] = $nom_famille;
        $_SESSION["user"]["mail"] = $mail;
    }

    // Récupérer le prénom de l'utilisateur de la session
    $prenom = $_SESSION["user"]["prenom"];
    $nom_famille = $_SESSION["user"]["nom_famille"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="./css/userdash.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

    <h2>Bienvenue sur votre tableau de bord <?php echo($prenom)," " ,($nom_famille)?></h2>

    <h3>Vos commandes</h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Commande #</th>
                    <th>Date</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les données des commandes seront ajoutées ici -->
            </tbody>
        </table>
    </div>

    <h3>Modifier vos informations personnelles</h3>
    <form method="POST" action="dashboard.php">
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom">
        </div>
        <div class="form-group">
            <label for="nom_famille">Nom de famille</label>
            <input type="text" class="form-control" id="nom_famille" name="nom_famille" placeholder="Nom de famille">
        </div>
        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" placeholder="Email">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>

        <a href="logout.php" class="btn btn-danger">Déconnexion</a>
    </form>
</main>

    <?php include './includes/footer.php'; ?>

</body>
</html>