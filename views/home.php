<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Récupération du nom de l'utilisateur
$nomUtilisateur = $_SESSION['nom'] ?? "Utilisateur";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Azaquizz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center">
        <h1 class="text-white text-xl font-bold">AZAQUIZZ</h1>
        <div>
            <a href="../controllers/logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Déconnexion</a>
        </div>
    </nav>

    <!-- Contenu -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-96 text-center">
            <h2 class="text-2xl font-semibold mb-4">Bienvenue, <?= htmlspecialchars($nomUtilisateur); ?> !</h2>
            <p class="text-gray-600 mb-4">Prêt à tester tes connaissances ?</p>
            <a href="quiz.php" class="bg-violet-700 text-white px-4 py-2 rounded hover:bg-violet-800">Commencer</a>
        </div>
    </div>

</body>

</html>