<?php
session_start();
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assainir et valider l'email
    $email = trim($_POST['email']);

    // Vérifier si l'email est vide
    if (empty($email)) {
        $_SESSION['error_message'] = "Veuillez entrer votre email.";
        header("Location: ../views/reset_request.php");
        exit();
    }

    // Vérifier si l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Veuillez entrer un email valide.";
        header("Location: ../views/reset_request.php");
        exit();
    }

    // Créer une instance de la classe User
    $user = new User();
    $result = $user->generateResetCode($email);

    // Vérification du résultat de la génération du code
    if ($result === true) {
        $_SESSION['success_message'] = "Un e-mail de réinitialisation a été envoyé à l'adresse : $email.";
        header("Location: ../views/reset_request.php");
        exit();
    } else {
        $_SESSION['error_message'] = $result;
        header("Location: ../views/reset_request.php");
        exit();
    }
}
