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

    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
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
    <!-- Espace entre la navbar et la présentation -->
    <div class="py-12"></div>

    <!-- Présentation -->
    <main class="text-center py-12">
        <h1 id="site-title" class="text-5xl font-bold w-full text-black">AzaQuizz</h1>
    </main>

    <!-- Section image et catégories alignées -->
    <section class="flex flex-col items-center justify-center py-8 w-full max-w-screen-lg mx-auto">
        <div class="flex items-center justify-between w-full">
            <!-- Image -->
            <div class="w-1/3 flex justify-center">
                <img src="../Image/logo_violet.svg" alt="Logo" class="max-h-40 max-w-full mix-blend-multiply opacity-90">
            </div>
            <!-- Description -->
            <div class="w-2/3 text-left text-lg font-semibold px-4">
                Bienvenue sur AzaQuizz, votre destination incontournable pour des quiz interactifs captivants ! Plongez dans un monde d'apprentissage ludique avec des défis variés sur des thèmes passionnants tels que l'histoire, la science, le cinéma et bien plus encore. Testez vos connaissances, ajoutez vos propres QCM et partagez-les avec la communauté. Amusez-vous tout en apprenant et défiez vos amis pour voir qui est le plus futé ! Rejoignez-nous dès aujourd'hui et transformez vos moments de loisir en opportunités d'apprentissage enrichissantes ! 🧠✨ </div>
        </div>

        <!-- Espace entre les sections -->
        <div class="py-8"></div>

        <section class="w-full">
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
    </section>
</body>

</html>