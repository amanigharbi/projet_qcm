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

$database = new Database();
$pdo = $database->conn;

$userId = $_SESSION['user_id'];
error_log("ID d'utilisateur trouvé dans la session: " . $userId);

$stmt = $pdo->prepare("SELECT * FROM qcm WHERE createur_id = ?");
$stmt->execute([$userId]);
$qcms = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes QCM</title>
    <script src="https://cdn.tailwindcss.com"></script>
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


    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-semibold text-violet-700 mb-4 text-center">Mes QCM</h2>
        <?php if (count($qcms) === 0): ?>
            <p class="text-gray-700 mb-4">Vous n'avez encore créé aucun QCM.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($qcms as $quiz): ?>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="flex items-center space-x-4">
                            <img src="<?= htmlspecialchars($quiz['image'] ?? 'default.jpg') ?>"
                                alt="<?= htmlspecialchars($quiz['nom'] ?? 'Quiz') ?>"
                                class="w-16 h-16 object-cover rounded-md">

                            <h3 class="text-xl font-semibold text-violet-700"><?php echo htmlspecialchars($quiz['titre']); ?></h3>
                        </div>

                        <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($quiz['description']); ?></p>
                        <p class="text-gray-600 mb-4"><strong>Catégorie :</strong> <?php echo htmlspecialchars($quiz['titre']); ?></p>
                        <div class="flex justify-between">
                            <a href="modifyqcm.php?id=<?php echo $quiz['id']; ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300">Modifier</a>
                            <a href="deleteqcm.php?id=<?php echo $quiz['id']; ?>" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce QCM ?');">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <button type="button" onclick="addQcm()"
            class="w-full lg:w-auto bg-violet-700 text-white px-6 py-3 rounded-md hover:bg-violet-600 transition-colors flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            Créer un nouveau QCM
        </button>
</body>

</html>