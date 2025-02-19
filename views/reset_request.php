<?php
session_start();

// Récupérer les messages d'erreur et de succès
$errorMessage = $_SESSION['error_message'] ?? null;
$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['error_message'], $_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center">
        <h1 class="text-white text-xl font-bold">AZAQUIZZ</h1>
        <a href="login.php" class="text-white">Retour</a>
    </nav>

    <!-- Formulaire de demande de réinitialisation -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-semibold text-center mb-6">Mot de passe oublié</h2>

            <!-- Messages d'erreur / succès -->
            <?php if ($errorMessage): ?>
                <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
            <?php if ($successMessage): ?>
                <p class="text-green-500 text-center mb-4"><?= htmlspecialchars($successMessage); ?></p>
            <?php endif; ?>

            <form action="../controllers/reset_request_process.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Entrez votre email :</label>
                    <input type="email" name="email" class="w-full p-2 border rounded mt-1" required>
                </div>
                <button type="submit" class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">Envoyer</button>
            </form>
        </div>
    </div>

</body>

</html>