<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
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

        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Réinitialisation du mot de passe</h2>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="message error"><?= $_SESSION['error_message']; ?></div>
        <?php unset($_SESSION['error_message']); ?> <!-- Suppression du message d'erreur après affichage -->
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="message success"><?= $_SESSION['success_message']; ?></div>
        <?php unset($_SESSION['success_message']); ?> <!-- Suppression du message de succès après affichage -->
    <?php endif; ?>

    <!-- Formulaire de réinitialisation du mot de passe -->
    <form action="../controllers/reset_password_process.php" method="POST">
        <input type="hidden" name="code" value="<?= $_GET['code'] ?>">

        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="password" placeholder="Votre nouveau mot de passe" required>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>

        <button type="submit">Modifier le mot de passe</button>
    </form>

</div>

</body>
</html>
