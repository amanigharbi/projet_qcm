<?php

require_once __DIR__ . '/../bdd/Database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmation_mot_de_passe = $_POST['confirm_password'];


    //validation 
    $errors = [];
    if (empty($nom) || empty($prenom) || empty($username) || empty($email) || empty($password) || empty($confirmation_mot_de_passe)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }
    if ($password !== $confirmation_mot_de_passe) {
        $errors[] = "Le mot de passe et la confirmation doivent correspondre.";
    }
    // enregistrer l'utilisateur
    if (empty($errors)) {
        $registerResult = $authController->register($nom, $prenom, $username, $email, $password);
        if ($registerResult === true) {
            header("Location: login.php");

            exit();
        } else {
            $errors[] = $registerResult;
        }
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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


    <!-- Formulaire d'inscription -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md custom-width">
            <h2 class="text-2xl font-semibold text-center mb-6">Inscription</h2>

            <form method="POST">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700">Nom</label>
                        <input type="text" class="w-full p-2 border rounded mt-1" placeholder="Nom" name="nom">
                    </div>
                    <div>
                        <label class="block text-gray-700">Prénom</label>
                        <input type="text" class="w-full p-2 border rounded mt-1" placeholder="Prénom" name="prenom">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Pseudo</label>
                    <input type="text" class="w-full p-2 border rounded mt-1" placeholder="Pseudo" name="username">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" class="w-full p-2 border rounded mt-1" placeholder="Email" name="email">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Confirmation de l’email</label>
                    <input type="email" class="w-full p-2 border rounded mt-1" placeholder="Confirmez votre email" name="confirm_email">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700">Mot de passe</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="w-full p-2 border rounded mt-1 pr-10" required>
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" id="toggle-password">
                                <svg id="eye-open-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                </svg>
                                <svg id="eye-closed-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.2 0-11 7.5-11 7.5s3.8 7.5 11 7.5 11-7.5 11-7.5-3.8-7.5-11-7.5zm0 3a4.5 4.5 0 0 1 4.5 4.5 4.5 4.5 0 0 1-4.5 4.5 4.5 4.5 0 0 1-4.5-4.5A4.5 4.5 0 0 1 12 7.5zM3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Confirmer le mot de passe</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm-password" class="w-full p-2 border rounded mt-1 pr-10" required>
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" id="toggle-confirm-password">
                                <svg id="eye-open-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                </svg>
                                <svg id="eye-closed-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.2 0-11 7.5-11 7.5s3.8 7.5 11 7.5 11-7.5 11-7.5-3.8-7.5-11-7.5zm0 3a4.5 4.5 0 0 1 4.5 4.5 4.5 4.5 0 0 1-4.5 4.5 4.5 4.5 0 0 1-4.5-4.5A4.5 4.5 0 0 1 12 7.5zM3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Valider</button>
            </form>
            <div class="text-center mt-4">
                <p>Déjà un compte?
                    <a href="login.php" class="text-blue-600 hover:underline"> Connectez-vous</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(inputId, openEyeId, closedEyeId) {
            const input = document.getElementById(inputId);
            const openEye = document.getElementById(openEyeId);
            const closedEye = document.getElementById(closedEyeId);

            if (input.type === "password") {
                input.type = "text";
                openEye.classList.remove("hidden");
                closedEye.classList.add("hidden");
            } else {
                input.type = "password";
                openEye.classList.add("hidden");
                closedEye.classList.remove("hidden");
            }
        }

        document.getElementById('toggle-password').addEventListener('click', () => {
            togglePasswordVisibility('password', 'eye-open-password', 'eye-closed-password');
        });

        document.getElementById('toggle-confirm-password').addEventListener('click', () => {
            togglePasswordVisibility('confirm-password', 'eye-open-confirm', 'eye-closed-confirm');
        });
    </script>
</body>

</html>