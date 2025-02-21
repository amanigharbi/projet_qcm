<?php
session_start();
require_once '../controllers/QuizController.php';
require_once '../models/Quiz.php';
require_once '../bdd/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
if (isset($_GET['restart']) && $_GET['restart'] == 1) {
    unset($_SESSION['quiz_started'], $_SESSION['questions'], $_SESSION['currentQuestion'], $_SESSION['score'], $_SESSION['responses']);
}

$quizController = new QuizController();
$utilisateur_id = $_SESSION['user_id'];
$qcm_id = $_GET['qcm_id'] ?? 1;

// Initialisation du quiz et mélange des questions
if (!isset($_SESSION['quiz_started']) || $_SESSION['current_qcm'] != $qcm_id) {
    $_SESSION['quiz_started'] = true;
    $_SESSION['current_qcm'] = $qcm_id;
    $quizController->startQuiz($qcm_id, $utilisateur_id);
}

$currentQuestion = $quizController->getCurrentQuestion();

// Vérification si une question existe
if (!$currentQuestion) {
    echo "<p class='text-red-500 text-center'>Aucune question trouvée pour ce quiz.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['answer'])) {
    $quizController->processAnswer($utilisateur_id, $currentQuestion['id'], $_POST['answer']);

    if ($quizController->isQuizFinished()) {
        $score = $quizController->finalizeQuiz($utilisateur_id, $qcm_id);
        header("Location: result.php?score=$score");
        exit();
    } else {
        header("Location: quiz.php?qcm_id=$qcm_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
    <script>
        let timeLeft = 10;

        function updateTimer() {
            document.getElementById('timer').innerText = timeLeft + "s";
            if (timeLeft <= 0) {
                document.getElementById('noAnswer').value = "-1";
                document.getElementById('quizForm').submit();
            }
            timeLeft--;
        }

        setInterval(updateTimer, 1000);
    </script>
</head>

<body class="bg-gray-100">
    <?php include 'menu.php'; ?>

    <nav class="bg-violet-700 p-6 flex justify-between items-center">
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

    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-[500px] text-center">
            <p class="text-lg mb-6 text-gray-700">
                Question <?= $_SESSION['currentQuestion'] + 1 ?> sur <?= count($_SESSION['questions']) ?>
            </p>
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">
                <?= htmlspecialchars($currentQuestion['texte_question'] ?? 'Question non disponible'); ?>
            </h2>

            <!-- Minuteur -->
            <p class="text-red-600 text-xl font-bold mb-4">Temps restant : <span id="timer">10s</span></p>

            <form method="POST" id="quizForm">
                <input type="hidden" name="answer" id="noAnswer" value="">

                <?php

                $reponses = $quizController->quiz->getReponses($currentQuestion['id']);

                if (!$reponses) {
                    echo "<p class='text-red-500'>Aucune réponse disponible.</p>";
                } else {
                    foreach ($reponses as $reponse) :
                        $texteReponse = $reponse['texte_reponse'] ?? 'Réponse non disponible';
                ?>
                        <button type="submit" name="answer" value="<?= $reponse['id']; ?>"
                            class="bg-violet-700 text-white px-6 py-4 rounded mb-6 hover:bg-violet-800 w-full text-xl">
                            <?= htmlspecialchars($texteReponse); ?>
                        </button>
                <?php
                    endforeach;
                }
                ?>
            </form>
        </div>
    </div>
</body>

</html>