<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../bdd/Database.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$pdo = $database->conn;
$userId = $_SESSION['user_id'];

if (isset($_GET['delete'])) {
    $qcmId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM qcm WHERE id = ? AND createur_id = ?");
    if ($stmt->execute([$qcmId, $userId])) {
        header("Location: myqcm.php?status=success&message=QCM supprimé avec succès.");
    } else {
        header("Location: myqcm.php?status=error&message=Erreur lors de la suppression du QCM.");
    }
    exit;
}

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
        <h2 class="text-3xl font-semibold text-violet-700 mb-4">Mes QCM</h2>
        <?php if (empty($qcms)): ?>
            <p class="text-gray-700">Vous n'avez encore créé aucun QCM.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($qcms as $quiz): ?>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-violet-700 mb-2"><?php echo htmlspecialchars($quiz['titre']); ?></h3>
                        <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($quiz['description']); ?></p>
                        <p class="text-gray-600 mb-4"><strong>Catégorie :</strong> <?php echo htmlspecialchars($quiz['titre']); ?></p>
                        <div class="flex justify-between">
                            <a href="modifyqcm.php?id=<?php echo $quiz['id']; ?>" class="bg-yellow-500 text-white px-4 py-2 rounded">Modifier</a>
                            <a href="deleteqcm.php?id=<?php echo $quiz['id']; ?>" class="bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce QCM ?');">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <button onclick="window.location.href='addqcm.php'" class="mt-4 bg-violet-700 text-white px-6 py-3 rounded-md">Créer un nouveau QCM</button>
    </div>
</body>

</html>