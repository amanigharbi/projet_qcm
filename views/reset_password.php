<?php
session_start();

// Vérifier si le code est présent dans l'URL
if (!isset($_GET['code'])) {
    $_SESSION['error_message'] = "Lien de réinitialisation invalide.";
    header("Location: login.php");
    exit();
}

// Récupération des messages
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
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">

    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Formulaire de réinitialisation du mot de passe -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-semibold text-center mb-6">Réinitialisation du mot de passe</h2>

            <!-- Messages d'erreur / succès -->
            <?php if ($errorMessage): ?>
                <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
            <?php if ($successMessage): ?>
                <p class="text-green-500 text-center mb-4"><?= htmlspecialchars($successMessage); ?></p>
            <?php endif; ?>

            <form action="../controllers/reset_password_process.php" method="POST">
                <input type="hidden" name="code" value="<?= htmlspecialchars($_GET['code']); ?>">

                <!-- Nouveau mot de passe -->
                <div class="mb-4">
                    <label class="block text-gray-700">Nouveau mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded mt-1 pr-10" required>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 toggle-password" data-target="password">
                            <svg class="eye-open hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <svg class="eye-closed w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.2 0-11 7.5-11 7.5s3.8 7.5 11 7.5 11-7.5 11-7.5-3.8-7.5-11-7.5zm0 3a4.5 4.5 0 0 1 4.5 4.5 4.5 4.5 0 0 1-4.5 4.5 4.5 4.5 0 0 1-4.5-4.5A4.5 4.5 0 0 1 12 7.5zM3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Confirmer le mot de passe -->
                <div class="mb-4">
                    <label class="block text-gray-700">Confirmer le mot de passe</label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" class="w-full p-2 border rounded mt-1 pr-10" required>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 toggle-password" data-target="confirm_password">
                            <svg class="eye-open hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <svg class="eye-closed w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.2 0-11 7.5-11 7.5s3.8 7.5 11 7.5 11-7.5 11-7.5-3.8-7.5-11-7.5zm0 3a4.5 4.5 0 0 1 4.5 4.5 4.5 4.5 0 0 1-4.5 4.5 4.5 4.5 0 0 1-4.5-4.5A4.5 4.5 0 0 1 12 7.5zM3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Valider</button>
            </form>

            <div class="text-center mt-4">
                <p>Vous n'avez rien reçu?
                    <a href="register.php" class="text-blue-600 hover:underline"> Inscrivez-vous</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordField = document.getElementById(targetId);
                const eyeOpen = this.querySelector('.eye-open');
                const eyeClosed = this.querySelector('.eye-closed');

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
        });
    </script>

</body>

</html>