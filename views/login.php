<?php
session_start();

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
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">

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
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(195, 181, 253, 0.55), rgba(237, 233, 254, 0.5), rgba(255, 255, 255, 1));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .content {
            width: 90%;
            max-width: 1200px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
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
                    <label for="password" class="block text-gray-700">Mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded mt-1 pr-10" required>
                        <!-- Icône d'affichage du mot de passe -->
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" id="toggle-password">
                            <!-- Icône d'œil ouvert -->
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <!-- Icône d'œil fermé -->
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.2 0-11 7.5-11 7.5s3.8 7.5 11 7.5 11-7.5 11-7.5-3.8-7.5-11-7.5zm0 3a4.5 4.5 0 0 1 4.5 4.5 4.5 4.5 0 0 1-4.5 4.5 4.5 4.5 0 0 1-4.5-4.5A4.5 4.5 0 0 1 12 7.5zM3 3l18 18" />
                            </svg>
                        </button>
                    </div>
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

    <script>
        // Sélection des éléments
        const togglePassword = document.getElementById('toggle-password');
        const passwordField = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        // Événement pour afficher/masquer le mot de passe
        togglePassword.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.classList.remove('hidden'); // Afficher l'œil ouvert
                eyeClosed.classList.add('hidden'); // Cacher l'œil fermé
            } else {
                passwordField.type = 'password';
                eyeOpen.classList.add('hidden'); // Cacher l'œil ouvert
                eyeClosed.classList.remove('hidden'); // Afficher l'œil fermé
            }
        });
    </script>
</body>

</html>