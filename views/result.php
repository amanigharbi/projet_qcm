<?php
session_start();
$score = $_SESSION['score'];
$totalQuestions = 4;

session_destroy();  // Destroy session when the quiz is finished
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-violet-700 p-6 flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">AZAQUIZZ</h1>
        <div>
            <a href="../controllers/logout.php" class="bg-red-600 text-white px-6 py-3 rounded text-lg">Déconnexion</a>
        </div>
    </nav>

    <!-- Résultats -->
    <div class="flex justify-center items-center max-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-100 text-center">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Quiz Terminé !</h2>
            <p class="text-xl font-semibold text-green-600 mb-6">Votre score : <?= $score ?> / <?= $totalQuestions ?></p>

            <h3 class="text-lg font-medium mb-4 text-gray-800">Récapitulatif des réponses :</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-violet-700 text-white">
                            <th class="px-4 py-2">Question</th>
                            <th class="px-4 py-2">Réponse donnée</th>
                            <th class="px-4 py-2">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['responses'] as $response) : ?>
                            <tr>
                                <td class="px-4 py-2 border-b text-gray-700"><?= htmlspecialchars($response['question']); ?></td>
                                <td class="px-4 py-2 border-b text-gray-700"><?= htmlspecialchars($response['answer']); ?></td>
                                <td class="px-4 py-2 border-b <?= $response['isCorrect'] ? 'text-green-600' : 'text-red-600'; ?>">
                                    <?= $response['isCorrect'] ? 'Correct' : 'Incorrect'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <a href="quiz.php" class="bg-violet-700 text-white px-6 py-3 rounded hover:bg-violet-800 mt-6 inline-block text-lg">
                Rejouer
            </a>
        </div>
    </div>

</body>

</html>