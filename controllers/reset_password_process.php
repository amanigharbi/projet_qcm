<?php
session_start();
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et assainissement des données
    $code = trim($_POST['code']);
    $newPassword = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Vérifications côté serveur

    // 1. Vérifier si les champs sont vides
    if (empty($code) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error_message'] = "Tous les champs sont requis.";
        header("Location: ../views/reset_password.php?code=$code");
        exit();
    }

    // 2. Vérifier la longueur du mot de passe (min. 8 caractères)
    if (strlen($newPassword) < 8) {
        $_SESSION['error_message'] = "Le mot de passe doit contenir au moins 8 caractères.";
        header("Location: ../views/reset_password.php?code=$code");
        exit();
    }

    // 3. Vérifier si les mots de passe correspondent
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
        header("Location: ../views/reset_password.php?code=$code");
        exit();
    }

    // 4. Traitement de la réinitialisation via la classe User
    $user = new User();
    $result = $user->resetPassword($code, $newPassword);

    // 5. Gérer la réponse (succès ou erreur)
    if ($result === true) {
        $_SESSION['success_message'] = "Mot de passe modifié avec succès. Vous pouvez vous connecter.";
        header("Location: ../views/login.php");
        exit();
    } else {
        $_SESSION['error_message'] = $result;  // Affiche l'erreur retournée
        header("Location: ../views/reset_password.php?code=$code");
        exit();
    }
}
