<?php
session_start();
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nettoyage des données utilisateur pour éviter les injections SQL et XSS
    $identifier = trim(htmlspecialchars($_POST['identifier']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Vérification de la validité des champs
    if (empty($identifier) || empty($password)) {
        $_SESSION['error_message'] = "Veuillez remplir tous les champs.";
        header("Location: ../views/login.php"); // Redirige vers la page de login avec l'erreur
        exit();
    }

    // Créer une instance de la classe User pour gérer la connexion
    $user = new User();
    $result = $user->login($identifier, $password);

    // Si la connexion réussit
    if ($result === true) {
        header("Location: ../index.php"); // Redirection vers la page d'accueil
        exit();
    } else {
        $_SESSION['error_message'] = $result; // Sauvegarder le message d'erreur
        header("Location: ../views/login.php"); // Redirection vers la page de login avec l'erreur
        exit();
    }
}
?>
