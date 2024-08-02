<?php
// Démarrer la session
session_start();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion
header('Location: login.php');
exit;
?>