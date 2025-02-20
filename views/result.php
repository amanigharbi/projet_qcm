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

    <nav class="bg-violet-700 p-6 flex justify-between items-center">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="../controllers/logout.php" class="bg-red-600 text-white px-6 py-3 rounded text-lg">Déconnexion</a>
        </div>
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