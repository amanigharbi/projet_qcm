<?php

require_once '../controllers/AuthController.php';
require_once '../bdd/Database.php';

$auth = new AuthController($db);



// vérifier si l'utilisateur est connecté
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

// Redirection (non-connexion)
function ensureLoggedIn(): void
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// l'id de l'utilisateur actuel
function currentUserId(): ?int
{
    return $_SESSION['user_id'] ?? null;
}
