<?php
session_start();

// Définition des questions et réponses
$questions = [
    [
        "question" => "Quelle est la capitale de la France ?",
        "answers" => ["Paris", "Londres", "Berlin", "Madrid"],
        "correct" => 0
    ],
    [
        "question" => "Qui a écrit 'Hamlet' ?",
        "answers" => ["Shakespeare", "Hemingway", "Tolkien", "Rowling"],
        "correct" => 0
    ],
    [
        "question" => "Quel est 5 + 3 ?",
        "answers" => ["5", "8", "12", "15"],
        "correct" => 1
    ],
    [
        "question" => "Quelle planète est connue sous le nom de planète rouge ?",
        "answers" => ["Terre", "Mars", "Jupiter", "Vénus"],
        "correct" => 1
    ]
];

// Initialisation des variables de session
if (!isset($_SESSION['currentQuestion'])) {
    $_SESSION['currentQuestion'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['responses'] = [];
}

$responseMessage = ''; // Message affichant la correction

// Traitement de la réponse
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentIndex = $_SESSION['currentQuestion'];

    if (isset($_POST['answer'])) {
        $selectedAnswer = intval($_POST['answer']);
        $isCorrect = $selectedAnswer === $questions[$currentIndex]['correct'];
    } else {
        // Si l'utilisateur ne sélectionne pas de réponse avant la fin du timer
        $selectedAnswer = -1; // Aucun choix fait
        $isCorrect = false;
    }

    $_SESSION['responses'][] = [
        'question' => $questions[$currentIndex]['question'],
        'answer' => $selectedAnswer !== -1 ? $questions[$currentIndex]['answers'][$selectedAnswer] : "Aucune réponse",
        'isCorrect' => $isCorrect
    ];

    if ($isCorrect) {
        $_SESSION['score']++;
        $responseMessage = "<p class='text-green-600'>Bonne réponse !</p>";
    } else {
        $responseMessage = "<p class='text-red-600'>Mauvaise réponse !</p>";
    }

    $_SESSION['currentQuestion']++;

    // Si c'était la dernière question, aller aux résultats
    if ($_SESSION['currentQuestion'] >= count($questions)) {
        header("Location: result.php");
        exit();
    } else {
        // Recharger la page pour afficher la question suivante
        header("Location: quiz.php");
        exit();
    }
}

$currentQuestion = $_SESSION['currentQuestion'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz PHP</title>
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

    <!-- Timer -->
    <div class="flex justify-center p-3">
        <p id="timer" class="text-xl font-semibold text-red-600">1:00</p>
    </div>

    <!-- Question -->
    <div class="flex justify-center items-center max-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-[500px] text-center">

            <!-- Description de l'étape -->
            <p class="text-lg mb-6 text-gray-700">
                Vous êtes à l'étape <?= $currentQuestion + 1 ?> sur <?= count($questions) ?>.
                Répondez à la question ci-dessous :
            </p>

            <!-- Question actuelle -->
            <h2 class="text-2xl font-semibold mb-6 text-gray-800"><?= $questions[$currentQuestion]['question']; ?></h2>

            <!-- Affichage du message de réponse correcte/incorrecte -->
            <?php if ($responseMessage): ?>
                <div class="mb-6">
                    <?= $responseMessage ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire de réponses -->
            <form method="POST" id="quizForm">
                <?php foreach ($questions[$currentQuestion]['answers'] as $index => $answer) : ?>
                    <button type="submit" name="answer" value="<?= $index; ?>"
                        class="bg-violet-700 text-white px-6 py-4 rounded mb-6 hover:bg-violet-800 w-full text-xl">
                        <?= $answer; ?>
                    </button>
                <?php endforeach; ?>
            </form>
        </div>
    </div>

    <script>
        let timeLeft = 10; // 1 minute en secondes
        let timerElement = document.getElementById('timer');

        function startTimer() {
            const interval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    // Soumettre automatiquement le formulaire si l'utilisateur n'a pas répondu
                    document.getElementById('quizForm').submit();
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerElement.textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
                    timeLeft--;
                }
            }, 1000);
        }

        window.onload = startTimer; // Lancer le timer lorsque la page est chargée
    </script>

</body>

</html>