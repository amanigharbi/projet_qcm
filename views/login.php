<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 100%;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php
    if (isset($_SESSION['error_message'])) {
        echo "<p class='message error'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Supprimer après affichage
    }
    
    if (isset($_SESSION['success_message'])) {
        echo "<p class='message success'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']); // Supprimer après affichage
    }
    ?>

    <!-- Formulaire de connexion -->
    <form action="../controllers/login_process.php" method="POST">
        <h2>Connexion</h2>
        <label for="identifier">Email ou Nom d'utilisateur :</label>
        <input type="text" name="identifier" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        
        <button type="submit">Se connecter</button>

        <p><a href="reset_request.php">Mot de passe oublié ?</a></p>
    </form>

</body>
</html>
