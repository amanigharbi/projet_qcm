<?php
session_start();
require_once '../bdd/database.php';
require_once '../models/Quiz.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$nomUtilisateur = $_SESSION['nom'] ?? "Utilisateur";
$user_id = $_SESSION['user_id'];

$quiz = new Quiz();
$availableCateg = $quiz->getAllCategories();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Azaquizz</title>
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

    <section class="max-w-4xl mx-auto py-8">
        <h2 class="text-xl font-semibold text-center mb-6">Sélectionnez un thème</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-gray-700">
            <?php if (!empty($availableCateg)): ?>
                <?php foreach ($availableCateg as $Categ): ?>
                    <div class="text-center">
                        <strong class="block text-lg"><?= htmlspecialchars($Categ['nom']); ?></strong>
                        <a href="ListQCM.php?categorie_id=<?= urlencode($Categ['id']); ?>">
                            <img src="<?= htmlspecialchars($Categ['image'] ?? 'https://via.placeholder.com/300'); ?>"
                                alt="<?= htmlspecialchars($Categ['nom']); ?>"
                                class="w-full h-32 object-cover mt-2 rounded-lg shadow-md hover:shadow-lg transition">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">Aucune catégorie disponible.</p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>