<?php 
include './includes/header.php';

// Formulaire en méthode "post" soumis ?
if (!empty($_POST)) {
    // Importer les fonctions
    require_once "functions.php";

    // Vérifier les champs obligatoires
    if (isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
        isset($_POST["nom"]) && $_POST["nom"] != "" &&
        isset($_POST["mail"]) && $_POST["mail"] != "" &&
        isset($_POST["objet"]) && $_POST["objet"] != "" &&
        isset($_POST["contenu"]) && $_POST["contenu"] != "") {
            // Nettoyer les saisies utilisateur
            $prenom = sanitize($_POST["prenom"]);
            $nom = sanitize($_POST["nom"]);
            $mail = sanitize($_POST["mail"]);
            $objet = sanitize($_POST["objet"]);
            $contenu = sanitize($_POST["contenu"]);

            // Inclure le fichier de configuration pour établir la connexion PDO
            include './config/config_local.php';

            try {
                // Préparer la requête
                $sql = "INSERT INTO form
                        (prenom, nom, mail, objet, contenu)
                        VALUES
                        (:prenom, :nom, :mail, :objet, :contenu);";

                $query = $pdo->prepare($sql);

                // Lier les paramètres à la requête
                $query->bindParam(":prenom", $prenom);
                $query->bindParam(":nom", $nom);
                $query->bindParam(":mail", $mail);
                $query->bindParam(":objet", $objet);
                $query->bindParam(":contenu", $contenu);

                // Exécuter la requête
                if ($query->execute()) {
                    // Tout est OK !
                    // Informer l'utilisateur et le remercier
                    echo "Merci pour votre message.";
                }
            } catch (PDOException $e) {
                // Gérer les erreurs de requête
                echo 'Erreur : ' . $e->getMessage();
            }
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="./css/contact.css">
  </head>

  <body>
    <main>
      <h2>Formulaire de contact</h2>
      <div class="container">
        <form id="form" method="post">
          <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" class="form-control" id="prenom" placeholder="Entrez votre prénom" name="prenom">
          </div>
          <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom">
          </div>
          <div class="form-group">
            <label for="mail">Email:</label>
            <input type="email" class="form-control" id="mail" placeholder="Entrez votre email" name="mail">
          </div>
          <div class="form-group">
            <label for="objet">Objet:</label>
            <input type="text" class="form-control" id="objet" placeholder="Entrez l'objet de votre message" name="objet">
          </div>
          <div class="form-group">
            <label for="contenu">Demande:</label>
            <textarea class="form-control" id="contenu" placeholder="Entrez votre demande" name="contenu"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
      </div>
    </main>
    <?php include './includes/footer.php'; ?>
  </body>
  </html>