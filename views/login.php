<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php
    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Supprimer le message après l'affichage
    }
    ?>

    <!-- Formulaire de connexion -->
    <form action="../controllers/login_process.php" method="POST">
        <label for="identifier">Email ou Nom d'utilisateur :</label>
        <input type="text" name="identifier" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        
        <button type="submit">Se connecter</button>
    </form>

    <a href="reset_request.php">Mot de passe oublié ?</a>

</body>
</html>
