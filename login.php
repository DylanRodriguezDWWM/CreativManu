<?php
  // Inclure le fichier header
  include './includes/header.php';

  // Vérifier si le formulaire a été validé
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Importer les fonctions
    require_once "functions.php"; 

    // Nettoyer les saisies utilisateur
    $mail = sanitize($_POST["mail"]);
    $hash = sanitize($_POST["hash"]);

    try {
      // Connexion à la base de données
      include './config/config_local.php';

      // Préparer la requête pour récupérer l'utilisateur correspondant à l'adresse e-mail
      $sql = "SELECT * FROM utilisateur WHERE mail = :mail";
      $query = $pdo->prepare($sql);

      // Lier les paramètres à la requête
      $query->bindParam(":mail", $mail);

      // Exécuter la requête
      $query->execute();

      // Vérifier si l'utilisateur existe
      if ($query->rowCount() > 0) {
        // L'utilisateur existe, récupérer les informations de l'utilisateur
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe
        if (password_verify($_POST["hash"], $user['hash'])) {
          // Le mot de passe est correct, démarrer une session
          session_start();
          

          // Stocker les informations de l'utilisateur dans la session
          $_SESSION["user"] = $user;

          // Vérifier si l'utilisateur est un administrateur
          if ($user["id_role"] == 766667) {
            // Rediriger l'utilisateur vers le tableau de bord de l'administrateur
            header("Location: dashboardAdmin.php");
          } elseif ($user["id_role"] == 5){
            // Rediriger l'utilisateur vers la page d'accueil
            header("Location: dashboard.php");
          } else {
            session_destroy();
          }

          exit;
        } else {
          // Le mot de passe est incorrect
          // Gérer cette situation comme vous le souhaitez, par exemple en affichant un message d'erreur
          echo "l'adresse mail ou le mot de passe est incorrect.";
        }
      } else {
        // L'utilisateur n'existe pas
        // Gérer cette situation comme vous le souhaitez, par exemple en affichant un message d'erreur
        echo "l'adresse mail ou le mot de passe est incorrect.";
      }

    } catch (PDOException $e) {
      // Gérer les erreurs de connexion à la base de données
      echo "Erreur : " . $e->getMessage();
    }
  }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="./css/login.css">
  </head>

  <body>
    <h2 id="login">Connectez vous à votre compte</h2>

    <div class="login-container">
      <h3>Se connecter</h3>
      <p>Pas encore de compte? <a href="signup.php">Inscrivez-vous ici</a></p>
      <form id="login-form" method="post" action="login.php">
        <div class="form-field">
          <label for="mail">Adresse mail :</label>
          <input type="mail" id="mail" name="mail" required>
        </div>
        <div class="form-field">
          <label for="hash">Mot de passe :</label>
          <input type="password" id="hash" name="hash" required>
        </div>
        <input type="submit" class="login-button" value="Connexion">
        <input type="button" class="forgot-password-button" value="Mot de passe oublié?">
      </form>
      <div id="error-message"></div>
      <div class="login-footer">
        <p>En vous connectant, vous acceptez nos <a href="#">Conditions d'utilisation</a> et notre <a href="#">Politique de confidentialité</a>.</p>
      </div>
    </div>
    <?php include './includes/footer.php'; ?>
  </body>
</html>