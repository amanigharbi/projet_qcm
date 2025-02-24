<?php
session_start();
require_once '../controllers/QuizController.php';
require_once '../models/Quiz.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$quizController = new QuizController();
$quizModel = new Quiz();

$qcm_id = $_GET['id'] ?? null;

if (!$qcm_id) {
    die("ID du QCM non fourni !");
}

// Récupérer les informations du QCM
$qcm = $quizModel->getById($qcm_id);
$questions = $quizModel->getQuestionsByQcmId($qcm_id);
$availableCateg = $quizModel->getAllCategories();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $questionsData = [];

    foreach ($_POST['questions'] as $question_id => $question_text) {
        $question = [
            'id' => $question_id,
            'texte_question' => $question_text,
            'reponses' => []
        ];

        foreach ($_POST['reponses'][$question_id] as $reponse_id => $reponse_text) {
            $isCorrect = isset($_POST['correct'][$reponse_id]) ? 1 : 0;
            $question['reponses'][] = [
                'id' => $reponse_id,
                'texte_reponse' => $reponse_text,
                'est_correcte' => $isCorrect
            ];
        }

        $questionsData[] = $question;
    }

    // Met à jour le QCM avec ses questions et réponses
    $quizController->modifyQcm($qcm_id, $title, $description, $questionsData, $_POST['categorie']);

    // Redirection après la mise à jour
    header("Location: Myqcm.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un QCM</title>
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/styles.css">
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
    <!-- Navbar -->
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

    <div class="container mx-auto p-4 lg:p-8 max-w-4xl">
        <div class="mb-8">

            <h2 class="text-3xl lg:text-4xl font-bold text-violet-700 mb-2 text-center">Modifier le QCM : <?= htmlspecialchars($qcm['titre']) ?></h2>
            <br>
            <p class="text-gray-600">Mettre à jour les informations que vous voulez dans votre qcm </p>

        </div>
        <form action="" method="POST" class="space-y-6 bg-white p-6 lg:p-8 rounded-xl shadow-lg">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Titre du QCM :</label>
                <input type="text" name="title" value="<?= htmlspecialchars($qcm['titre']) ?>" required
                    class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Description :</label>
                <textarea name="description" required class="w-full px-4 py-2 border rounded-md h-32"><?= htmlspecialchars($qcm['description']) ?></textarea>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold">Catégorie :</label>
                    <select name="categorie" class="w-full px-4 py-2 border rounded-md">
                        <?php foreach ($availableCateg as $categorie): ?>
                            <option value="<?= $categorie['id'] ?>" <?= ($qcm['categorie_id'] == $categorie['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categorie['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div id="questionSections">
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <label class="block text-gray-700 font-bold">Question :</label>
                            <input type="text" name="questions[<?= $question['id'] ?>]" value="<?= htmlspecialchars($question['texte_question']) ?>"
                                class="w-full px-4 py-2 border rounded-md">

                            <div class="mt-4">
                                <label class="block text-gray-700 font-bold">Réponses :</label>
                                <?php $reponses = $quizModel->getReponses($question['id']); ?>
                                <?php foreach ($reponses as $reponse): ?>
                                    <div class="flex items-center gap-2 mt-2">
                                        <input type="text" name="reponses[<?= $question['id'] ?>][<?= $reponse['id'] ?>]"
                                            value="<?= htmlspecialchars($reponse['texte_reponse']) ?>"
                                            class="w-full px-4 py-2 border rounded-md">
                                        <input type="checkbox" name="correct[<?= $reponse['id'] ?>]" <?= $reponse['est_correcte'] ? 'checked' : '' ?>>
                                        <span>Correct</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="w-full bg-violet-700 text-white px-6 py-3 rounded-md hover:bg-violet-600 transition-colors">
                    Modifier le QCM
                </button>
        </form>
    </div>

</body>

</html>