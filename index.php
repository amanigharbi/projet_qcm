<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: views/login.php");
    exit();
}

echo "Bienvenue, " . $_SESSION['nom'] . "!";
?>
