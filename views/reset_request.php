<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php
    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    ?>

    <!-- Formulaire de demande de réinitialisation -->
    <form action="../controllers/reset_request_process.php" method="POST">
        <label for="email">Entrez votre email :</label>
        <input type="email" name="email" required>
        <button type="submit">Réinitialiser</button>
    </form>

    <!-- Lien vers la page de connexion -->
    <a href="../views/login.php">Retour à la connexion</a>

</body>
</html>
