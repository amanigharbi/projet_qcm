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

    <!-- Formulaire de réinitialisation du mot de passe -->
    <form action="../controllers/reset_password_process.php" method="POST">
        <input type="hidden" name="code" value="<?= $_GET['code'] ?>">
        
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit">Modifier le mot de passe</button>
    </form>

</body>
</html>
