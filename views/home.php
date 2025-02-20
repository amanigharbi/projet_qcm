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
$userScores = $quiz->getUserScores($user_id);
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
        <div>
            <a href="../controllers/logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Déconnexion</a>
        </div>
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

        <div class="bg-white p-8 rounded-lg shadow-md w-3/4 mx-auto text-center mt-10">
            <h3 class="text-xl font-semibold mb-4">Historique de vos scores</h3>
            <table class="table-auto w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-violet-700 text-white">
                        <th class="px-4 py-2">Quiz</th>
                        <th class="px-4 py-2">Score</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($userScores)) : ?>
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-gray-500">Aucun score enregistré.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($userScores as $score) : ?>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2"><?= htmlspecialchars($score['titre'] ?? 'Inconnu'); ?></td>
                                <td class="px-4 py-2">
                                    <?= isset($score['score'], $score['total_questions'])
                                        ? htmlspecialchars($score['score'] . '/' . $score['total_questions'])
                                        : 'N/A'; ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?= isset($score['date']) && !empty($score['date'])
                                        ? date("d/m/Y H:i", strtotime($score['date']))
                                        : 'Date inconnue'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>