<?php
require_once '../controllers/listQCMController.php';
require_once '../bdd/database.php';
session_start();

$nomUtilisateur = $_SESSION['nom'] ?? "Utilisateur";
$user_id = $_SESSION['user_id'] ?? null;

$categorie_id = $_GET['categorie_id'] ?? null;
$results = obtenirQCM($categorie_id);

// Connexion à la base de données pour récupérer les questions
$pdo = (new Database())->conn;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des QCM</title>
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

    <!-- Inclusion du menu -->
    <?php include 'menu.php'; ?>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
        <h1 class="text-2xl font-bold mb-4">Sélectionnez un Quiz</h1>

        <?php if (!empty($results)): ?>
            <?php foreach ($results as $result): ?>

                <?php
                // Vérifier si le QCM contient des questions
                $nombreQuestions = 0;
                if (!empty($result['id'])) {
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM questions WHERE qcm_id = ?");
                    $stmt->execute([$result['id']]);
                    $nombreQuestions = $stmt->fetchColumn();
                }
                ?>

                <div class="flex items-center border-b py-4">
                    <img src="<?= htmlspecialchars($result['image'] ?? 'https://img.icons8.com/?size=100&id=3979&format=png&color=000000') ?>"
                        alt="<?= htmlspecialchars($result['nom'] ?? 'Quiz') ?>"
                        class="w-16 h-16 object-cover rounded-md">

                    <div class="ml-4 flex-1">
                        <h2 class="text-lg font-semibold">
                            <?= htmlspecialchars($result['titre'] ?? 'Titre inconnu') ?>
                            (<?= $nombreQuestions ?> questions)
                        </h2>
                        <p class="text-gray-600"><?= htmlspecialchars($result['description'] ?? 'Aucune description disponible.') ?></p>
                    </div>

                    <?php if (!empty($result['id'])): ?>
                        <?php if ($nombreQuestions > 0): ?>
                            <a href="quiz.php?qcm_id=<?= htmlspecialchars($result['id']); ?>"
                                class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition">
                                Je commence
                            </a>
                        <?php else: ?>
                            <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                                Indisponible
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600">Aucun QCM disponible.</p>
        <?php endif; ?>
    </div>

</body>

</html>