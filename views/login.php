<?php
session_start();

// Si l'utilisateur est déjà connecté, on le redirige vers home.php
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}



// Récupération des messages d'erreur ou de succès
$errorMessage = $_SESSION['error_message'] ?? null;
$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['error_message'], $_SESSION['success_message']);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showResetForm() {
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('reset-form').classList.remove('hidden');
        }

        function showLoginForm() {
            document.getElementById('reset-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
        }
    </script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center">
        <button class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="register.php" class="bg-white text-violet-700 px-4 py-2 rounded mr-2">S'inscrire</a>
            <a href="login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
        </div>
    </nav>

    <!-- Formulaire de connexion -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-semibold text-center mb-6">Connexion</h2>

            <!-- Affichage des messages d'erreur -->
            <?php if ($errorMessage): ?>
                <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>

            <?php if ($successMessage): ?>
                <div class="text-green-500 text-center mb-4"><?= htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form action="../controllers/login_process.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Email ou Pseudo</label>
                    <input type="text" name="identifier" class="w-full p-2 border rounded mt-1" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Mot de passe</label>
                    <input type="password" name="password" class="w-full p-2 border rounded mt-1" required>
                </div>
                <button type="submit" class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">Se connecter</button>
            </form>

            <div class="text-right mt-4">
                <a href="reset_request.php" class="text-purple-700 hover:underline">Mot de passe oublié ?</a>
            </div>
            <div class="text-center mt-4">
                <p>Pas de compte? <a href="register.php" class="text-blue-600 hover:underline">Inscrivez-vous</a></p>

            </div>
        </div>
    </div>

</body>

</html>