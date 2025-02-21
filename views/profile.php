<?php
require_once '../controllers/AuthController.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$authController = new AuthController();
$user = $authController->getUserProfile($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
</head>

<body class="bg-gray-100">
    <?php include 'menu.php'; ?>

    <nav class="bg-violet-700 p-4 flex justify-between items-center">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>

        <?php if (isset($_SESSION['nom'])): ?>
            <div class="flex items-center space-x-4 p-3 rounded-lg shadow-md bg-white">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['nom']); ?>&background=6B46C1&color=fff&size=40"
                        alt="Avatar" class="w-10 h-10 rounded-full border border-white shadow">
                    <span class="text-gray-900 font-bold text-lg"><?= htmlspecialchars($_SESSION['nom']); ?></span>
                </div>
                <a href="../controllers/logout.php" class="bg-white text-violet-700 px-4 py-2 rounded-lg border border-violet-700 hover:bg-violet-100 transition font-medium">
                    Déconnexion
                </a>
            </div>
        <?php endif; ?>
    </nav>

    <div class="max-w-5xl mx-auto mt-10">
        <div class="bg-white shadow-lg rounded-lg p-6 flex gap-6">
            <!-- Section Avatar -->
            <div class="w-1/3 flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nom'] . ' ' . $user['prenom']); ?>&background=6B46C1&color=fff&size=150"
                    alt="Avatar" class="rounded-full border-4 border-gray-300 shadow-md">

                <h2 class="text-xl font-bold mt-4"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h2>
                <p class="text-gray-500">@<?= htmlspecialchars($user['nom_utilisateur']); ?></p>

                <div class="mt-4 flex space-x-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Suivre</button>
                    <button class="bg-gray-300 px-4 py-2 rounded-md hover:bg-gray-400">Message</button>
                </div>
            </div>

            <!-- Section Infos -->
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Informations du Profil</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Nom Complet</p>
                        <p class="font-semibold"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></p>
                    </div>

                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="font-semibold"><?= htmlspecialchars($user['email']); ?></p>
                    </div>

                    <div>
                        <p class="text-gray-600">Nom d'utilisateur</p>
                        <p class="font-semibold">@<?= htmlspecialchars($user['nom_utilisateur']); ?></p>
                    </div>

                    <div>
                        <p class="text-gray-600">Date d'inscription</p>
                        <p class="font-semibold"><?= isset($user['cree_le']) ? htmlspecialchars($user['cree_le']) : 'Non disponible'; ?></p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-2">
                    <a href="edit_profile.php" class="bg-violet-600 text-white px-4 py-2 rounded-md hover:bg-violet-700">
                        Modifier le profil
                    </a>
                    <a href="../controllers/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>