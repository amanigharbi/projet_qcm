<?php
session_start();
require_once '../bdd/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Vérification du score
$score = $_GET['score'] ?? 0;
$questions = $_SESSION['responses'] ?? [];
$totalQuestions = count($questions);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du Quiz</title>
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">

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

<body>
    <?php include 'menu.php'; ?>

    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
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

    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-[600px] text-center">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Quiz Terminé !</h2>
            <p class="text-xl font-semibold text-green-600 mb-6">
                Votre score : <?= htmlspecialchars($score); ?> / <?= htmlspecialchars($totalQuestions); ?>
            </p>

            <h3 class="text-lg font-medium mb-4 text-gray-800">Récapitulatif des réponses :</h3>
            <div class="text-left">
                <?php foreach ($questions as $index => $question) : ?>
                    <div class="mb-4 p-4 border-l-4 rounded
                        <?= $question['isCorrect'] ? 'border-green-500 bg-green-100' : 'border-red-500 bg-red-100'; ?>">
                        <p class="font-semibold"><?= ($index + 1) . ". " . htmlspecialchars($question['question']); ?></p>
                        <p class="text-gray-800">
                            <strong>Réponse donnée :</strong>
                            <?= empty($question['answer']) ? "<span class='text-orange-600'>Aucune réponse</span>" : htmlspecialchars($question['answer']); ?>
                        </p>
                        <p class="text-gray-800">
                            <strong>Statut :</strong>
                            <?= $question['isCorrect'] ? "<span class='text-green-600'>Correct</span>" : "<span class='text-red-600'>Incorrect</span>"; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="quiz.php?qcm_id=<?= $_SESSION['current_qcm']; ?>&restart=1"
                class="mt-6 inline-block bg-violet-700 text-white px-6 py-3 rounded text-lg hover:bg-violet-800">
                Recommencer
            </a>
        </div>
    </div>
</body>

</html>