<?php
session_start();

// Affichage du message de succès (et suppression après affichage)
if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
    unset($_SESSION['success_message']);
}

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: views/login.php");
    exit();
}

echo "Bienvenue, " . $_SESSION['nom'] . "!";
