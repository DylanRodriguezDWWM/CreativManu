<title>Inscription</title>
<link rel="stylesheet" href="./css/signup.css">

<?php include './includes/header.php';
// Formulaire en méthode "post" soumis ?
if (!empty($_POST)) {
  // Importer les fonctions
  require_once "functions.php"; 

  // Vérifier les champs obligatoires
  if (isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
      isset($_POST["nom_famille"]) && $_POST["nom_famille"] != "" &&
      isset($_POST["mail"]) && $_POST["mail"] != "" &&
      isset($_POST["date_naissance"]) && $_POST["date_naissance"] != "" &&
      isset($_POST["hash"]) && $_POST["hash"] != "" &&
      isset($_POST["telephone"]) && $_POST["telephone"] != "" &&
      isset($_POST["numero"]) && $_POST["numero"] != "" &&
      isset($_POST["nom_rue"]) && $_POST["nom_rue"] != "" &&
      isset($_POST["code_postal"]) && $_POST["code_postal"] != "" &&
      isset($_POST["ville"]) && $_POST["ville"] != "") {

      // Nettoyer les saisies utilisateur
      $prenom = sanitize($_POST["prenom"]);
      $nom_famille = sanitize($_POST["nom_famille"]);
      $mail = sanitize($_POST["mail"]);
      $date_naissance = sanitize($_POST["date_naissance"]);
      $hash = password_hash(sanitize($_POST["hash"]), PASSWORD_DEFAULT);
      $telephone = sanitize($_POST["telephone"]);
      $numero = sanitize($_POST["numero"]);
      $nom_rue = sanitize($_POST["nom_rue"]);
      $code_postal = sanitize($_POST["code_postal"]);
      $ville = sanitize($_POST["ville"]);
      $complement = isset($_POST["complement"]) ? sanitize($_POST["complement"]) : "";

      include './config/config_local.php';

      try {

          // Préparer la première requête (adresse_client)
          $sql = "INSERT INTO adresse_client
              (numero, nom_rue, code_postal, ville, complement)
              VALUES
              (:numero, :nom_rue, :code_postal, :ville, :complement);";

          $query = $pdo->prepare($sql);

          // Lier à les paramètres à la première requête
          $query->bindParam(":numero", $numero);
          $query->bindParam(":nom_rue", $nom_rue);
          $query->bindParam(":code_postal", $code_postal);
          $query->bindParam(":ville", $ville);
          $query->bindParam(":complement", $complement);

          // Exécuter la première requête
          $query->execute();

          // Obtenir l'ID de l'adresse insérée
          $id_adresse = $pdo->lastInsertId();

          // Préparer la deuxième requête (utilisateur)
          $sql = "INSERT INTO utilisateur
              (prenom, nom_famille, mail, date_naissance, hash, telephone, id_adresse, id_role)
              VALUES
              (:prenom, :nom_famille, :mail, :date_naissance, :hash, :telephone, :id_adresse, 5);";

          $query = $pdo->prepare($sql);

          // Lier à les paramètres à la deuxième requête
          $query->bindParam(":prenom", $prenom);
          $query->bindParam(":nom_famille", $nom_famille);
          $query->bindParam(":mail", $mail);
          $query->bindParam(":date_naissance", $date_naissance);
          $query->bindParam(":hash", $hash);
          $query->bindParam(":telephone", $telephone);
          $query->bindParam(":id_adresse", $id_adresse);

          // Exécuter la deuxième requête
          if ($query->execute()) {
              // Tout est OK !
              // Informer l'utilisateur et le remercier
              $alert["type"] = "success";
              $alert["title"] = "Bravo !";
              $alert["content"] = "Votre demande a été envoyée !";
          } else {
              // Requête non exécuté
              // Informer l'utilisateur en restant le plus vague possible
              $alert["type"] = "danger";
              $alert["title"] = "Erreur !";
              $alert["content"] = "Un problème a été rencontré, merci de reessayer !";
          }

      } catch (PDOException $e) {
          // Si une exception s'est produite
          // Afficher le message associé
          // En mode dev ou test ! Surtout pas en prod !
          error_log($e->getMessage());
          $alert["type"] = "danger";
          $alert["title"] = "Erreur !";
          $alert["content"] = "Un problème a été rencontré, merci de reessayer !";
      }
  } else {
      // Des champs obligatoires n'ont pas été complétés
      // Initialiser un tableau "alerte"
      $alert["type"] = "danger";
      $alert["title"] = "Erreur !";
      $alert["content"] = "Des champs obligatoires n'ont pas été complétés !";
  }
}

?>

<h2>Inscription</h2>

<form id="signup-form" method="post">
    <label for="mail">Adresse e-mail :</label>
    <input type="email" id="mail" name="mail" required maxlength="60" placeholder="Entrez votre e-mail">

    <label for="nom_famille">Nom de famille :</label>
    <input type="text" id="nom_famille" name="nom_famille" required maxlength="40" placeholder="Entrez votre nom de famille">

    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" required maxlength="30" placeholder="Entrez votre prénom">

    <label for="date_naissance">Date de naissance :</label>
    <input type="date" id="date_naissance" name="date_naissance" required placeholder="Entrez votre date de naissance">

    <label for="hash">Mot de passe :</label>
    <input type="password" id="hash" name="hash" required placeholder="Entrez votre mot de passe">

    <label for="telephone">Téléphone :</label>
    <input type="tel" id="telephone" name="telephone" required maxlength="10" placeholder="Entrez votre numéro de téléphone">

    <label for="numero">Numéro :</label>
    <input type="text" id="numero" name="numero" required maxlength="10" placeholder="Entrez votre numéro">

    <label for="nom_rue">Nom de rue :</label>
    <input type="text" id="nom_rue" name="nom_rue" required maxlength="60" placeholder="Entrez le nom de votre rue">

    <label for="complement">Complément :</label>
    <input type="text" id="complement" name="complement"  maxlength="10" placeholder="Entrez un complément">

    <label for="code_postal">Code postal :</label>
    <input type="text" id="code_postal" name="code_postal" required maxlength="5" placeholder="Entrez votre code postal">

    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville" required maxlength="50" placeholder="Entrez votre ville">

    <input type="submit" value="S'inscrire">
</form>

<?php include './includes/footer.php' ?>