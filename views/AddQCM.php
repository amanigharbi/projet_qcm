<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../bdd/Database.php';
require_once '../models/Quiz.php';
$quiz = new Quiz();
$availableCateg = $quiz->getAllCategories();

$database = new Database();
$pdo = $database->conn;

if (!isset($pdo)) {
    die("Database connection error.");
}
// récupérer les tags existantes dans la bdd
$tagsQuery = $pdo->query("SELECT nom FROM tags");
$existingTags = $tagsQuery->fetchAll(PDO::FETCH_COLUMN);

$categories = ['Histoire', 'Géographie', 'Sciences', 'Cinéma', 'Art', 'Sport'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un QCM</title>
    <link rel="stylesheet" href="assets/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="assets/tagInput.js"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
    <style>
        .tag {
            display: inline-block;
            background-color: #6D28D9;
            color: white;
            padding: 5px 15px;
            margin: 5px;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .tag:hover {
            background-color: #7C3AED;
        }

        .preview-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            margin-top: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .question-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border-left: 4px solid #6D28D9;
        }

        .correct-answer {
            color: #38a169;
            font-weight: 500;
        }

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
    <script defer src="assets/tagInput.js"></script>
    <!-- contenu principal -->
    <div class="container mx-auto p-4 lg:p-8 max-w-4xl">
        <div class="mb-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-violet-700 mb-2">Créer un nouveau QCM</h2>
            <p class="text-gray-600">Remplissez les informations ci-dessous pour créer votre questionnaire</p>
        </div>

        <form action="../controllers/addqcm_process.php" method="POST" class="space-y-6 bg-white p-6 lg:p-8 rounded-xl shadow-lg">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="titre" class="block text-lg font-medium text-gray-700">Titre du QCM :</label>
                    <input type="text" name="titre" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-violet-500">
                </div>

                <div>
                    <label for="description" class="block text-lg font-medium text-gray-700">Description :</label>
                    <textarea name="description" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-violet-500 h-32"></textarea>
                </div>

                <div>
                    <label for="categorie" class="block text-lg font-medium text-gray-700">Catégories :</label>
                    <select name="categorie" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-violet-500">
                        <?php foreach ($availableCateg as $categorie): ?>
                            <option value="<?= htmlspecialchars($categorie['nom']) ?>">
                                <?= htmlspecialchars($categorie['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="tags" class="block text-lg font-medium text-gray-700">Tags :</label>
                    <input type="text" id="tagInput" placeholder="Ajoutez un tag"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-violet-500">
                    <div id="tagsContainer" class="flex flex-wrap gap-2 mt-2"></div>
                    <input type="hidden" name="tags" id="tagsHiddenInput">
                </div>
            </div>

            <div id="questionSections" class="space-y-6"></div>

            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                <button type="button" onclick="addQuestion()"
                    class="w-full lg:w-auto bg-violet-700 text-white px-6 py-3 rounded-md hover:bg-violet-600 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Ajouter une question
                </button>

                <button type="submit"
                    class="w-full lg:w-auto bg-violet-700 text-white px-6 py-3 rounded-md hover:bg-violet-600 transition-colors">
                    Publier le QCM
                </button>
            </div>
        </form>

        <!-- aperçu -->
        <div class="preview-container mt-8">
            <h3 class="text-2xl font-semibold text-violet-700 mb-6">Aperçu du QCM</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600"><strong>Titre :</strong> <span id="previewTitle" class="text-gray-800">[Titre]</span></p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Description :</strong> <span id="previewDescription" class="text-gray-800">[Description]</span></p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Catégorie :</strong> <span id="previewCategory" class="text-violet-700">[Catégorie]</span></p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Tags :</strong> <span id="previewTags" class="flex flex-wrap gap-2"></span></p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Questions :</strong></p>
                    <div id="previewQuestionsList" class="mt-4 space-y-4"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // gestion des tags
        document.addEventListener('DOMContentLoaded', () => {
            const tagInput = document.getElementById('tagInput');
            const tagsContainer = document.getElementById('tagsContainer');
            const tagsHiddenInput = document.getElementById('tagsHiddenInput');
            let tags = [];

            tagInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const tag = tagInput.value.trim();
                    if (tag && !tags.includes(tag)) {
                        tags.push(tag);
                        updateTags();
                        updatePreview();
                    }
                    tagInput.value = '';
                }
            });

            function updateTags() {
                tagsContainer.innerHTML = tags.map(tag => `
                <span class="tag">${tag}</span>
            `).join('');

                tagsHiddenInput.value = tags.join(',');
                document.getElementById('previewTags').innerHTML = tags.map(tag => `
                <span class="tag">${tag}</span>
            `).join('');
            }

            // Ajouter des récepteurs en temps réel 
            document.querySelector('[name="titre"]').addEventListener('input', updatePreview);
            document.querySelector('[name="description"]').addEventListener('input', updatePreview);
            document.querySelector('[name="categorie"]').addEventListener('change', updatePreview);
        });

        // gestion des questions
        let questionCount = 0;

        function addQuestion() {
            questionCount++;
            const questionSection = document.createElement('div');
            questionSection.className = 'question-card';
            questionSection.innerHTML = `
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-violet-700">Question #${questionCount}</h3>
                
                <div>
                    <label class="block text-gray-700 mb-2">Question :</label>
                    <input type="text" name="questions[][question]" 
                           class="w-full px-4 py-2 border rounded-md" 
                           oninput="updatePreview()">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    ${[1, 2, 3, 4].map(i => `
                        <div>
                            <label class="block text-gray-700 mb-2">Réponse ${i} :</label>
                            <input type="text" 
                                   name="questions[][answers][]" 
                                   class="w-full px-4 py-2 border rounded-md" 
                                   oninput="updatePreview()">
                        </div>
                    `).join('')}
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Réponse correcte :</label>
                    <select name="questions[][correct]" 
                            class="w-full px-4 py-2 border rounded-md"
                            onchange="updatePreview()">
                        ${[0, 1, 2, 3].map(i => `
                            <option value="${i}">Réponse ${i + 1}</option>
                        `).join('')}
                    </select>
                </div>
            </div>
        `;

            document.getElementById('questionSections').appendChild(questionSection);
            updatePreview();
        }

        // mise à jour de l'aperçu 
        function updatePreview() {
            // champs principaux
            document.getElementById('previewTitle').textContent = document.querySelector('[name="titre"]').value;
            document.getElementById('previewDescription').textContent = document.querySelector('[name="description"]').value;
            document.getElementById('previewCategory').textContent = document.querySelector('[name="categorie"]').value;

            // questions
            const questions = Array.from(document.querySelectorAll('.question-card'));
            const previewList = document.getElementById('previewQuestionsList');
            previewList.innerHTML = '';

            questions.forEach((question, index) => {
                const questionText = question.querySelector('[name="questions[][question]"]').value;
                const answers = question.querySelectorAll('[name="questions[][answers][]"]');
                const correctIndex = parseInt(question.querySelector('[name="questions[][correct]"]').value);

                const questionElement = document.createElement('div');
                questionElement.className = 'bg-gray-50 p-4 rounded-lg';
                questionElement.innerHTML = `
                <p class="font-medium text-violet-700 mb-2">Question ${index + 1}: ${questionText || '[Question]'}</p>
                <div class="space-y-2 ml-4">
                    ${Array.from(answers).map((answer, i) => `
                        <p class="${i === correctIndex ? 'correct-answer' : 'text-gray-600'}"> <!-- Use strict equality -->
                            ${answer.value || '[Réponse]'}
                            ${i === correctIndex ? '<span class="ml-2">✓</span>' : ''} <!-- Add checkmark -->
                        </p>
                    `).join('')}
                </div>
            `;
                previewList.appendChild(questionElement);
            });
        }
    </script>
</body>

</html>