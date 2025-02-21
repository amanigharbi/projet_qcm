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
$availableQuizzes = $quiz->getAllQuizzes();
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

        <?php if (isset($_SESSION['nom_utilisateur'])): ?>
            <div class="flex items-center space-x-4 p-3 rounded-lg shadow-md bg-white">
                <!-- Icône utilisateur et nom -->
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['nom_utilisateur']); ?>&background=6B46C1&color=fff&size=40"
                        alt="Avatar" class="w-10 h-10 rounded-full border border-white shadow">
                    <span class="text-gray-900 font-bold text-lg"><?= htmlspecialchars($_SESSION['nom_utilisateur']); ?></span>
                </div>

                <!-- Bouton de déconnexion -->
                <a href="../controllers/logout.php" class="flex items-center bg-white text-violet-700 px-4 py-2 rounded-lg border border-violet-700 hover:bg-violet-100 transition font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-violet-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V7" />
                    </svg>
                    Déconnexion
                </a>
            </div>
        <?php endif; ?>

    </nav>

    <div class="container mx-auto mt-10">
        <div class="bg-white p-8 rounded-lg shadow-md w-3/4 mx-auto text-center">
            <h2 class="text-2xl font-semibold mb-4">Bienvenue, <?= htmlspecialchars($nomUtilisateur); ?> !</h2>
            <p class="text-gray-600 mb-4">Sélectionnez un quiz pour commencer :</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($availableQuizzes as $quiz) : ?>
                    <a href="quiz.php?qcm_id=<?= $quiz['id']; ?>"
                        class="block bg-violet-700 text-white px-4 py-3 rounded hover:bg-violet-800 text-lg">
                        <?= htmlspecialchars($quiz['titre']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>


    </div>
</body>

</html>