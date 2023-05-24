<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige vers la page d'accueil
header("Location: index.php");
exit;
?>
