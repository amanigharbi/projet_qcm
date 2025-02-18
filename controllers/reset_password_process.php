<?php
session_start();
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assainir et valider les données
    $code = trim($_POST['code']);
    $newPassword = trim($_POST['password']);

    // Vérification si les champs sont vides
    if (empty($code) || empty($newPassword)) {
        $_SESSION['error_message'] = "Tous les champs sont requis.";
        header("Location: ../views/reset_password.php?code=$code"); // Rediriger avec l'erreur
        exit();
    }

    // Créer une instance de la classe User
    $user = new User();
    $result = $user->resetPassword($code, $newPassword);

    // Si la réinitialisation du mot de passe a réussi
    if ($result === true) {
        $_SESSION['success_message'] = "Mot de passe modifié avec succès. Vous pouvez vous connecter.";
        header("Location: ../views/login.php"); // Redirection vers la page de connexion
        exit();
    } else {
        $_SESSION['error_message'] = $result; // Sauvegarder le message d'erreur
        header("Location: ../views/reset_password.php?code=$code"); // Rediriger vers la page de réinitialisation avec l'erreur
        exit();
    }
}
?>
