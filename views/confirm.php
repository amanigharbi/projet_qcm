<?php
require_once '../controllers/AuthController.php';
require_once '../bdd/Database.php';

$db = new Database();
$auth = new AuthController($db);

$message = ""; // Initialisation du message

if (!isset($_GET['token'])) {
    $message = "Token manquant.";
} else {
    $token = $_GET['token'];
    $result = $auth->confirmRegistration($token);

    if ($result === true) {
        $message = "✅ Votre compte a été activé avec succès ! Vous pouvez maintenant vous connecter.";
    } else {
        $message = "❌ " . $result;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation du compte - AzaQuizz</title>
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(195, 181, 253, 0.55), rgba(237, 233, 254, 0.5), rgba(255, 255, 255, 1));
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>


    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="register.php" class="bg-white text-violet-700 px-4 py-2 rounded mr-2">S'inscrire</a>
            <a href="login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full mt-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Confirmation du compte</h2>
        <p class="text-gray-700 mb-6"><?= htmlspecialchars($message); ?></p>

        <?php if ($result === true) : ?>
            <a href="login.php" class="bg-violet-700 text-white px-4 py-2 rounded hover:bg-violet-800 transition">
                Se connecter
            </a>
        <?php else : ?>
            <a href="../index.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                Retour à l'accueil
            </a>
        <?php endif; ?>
    </div>
</body>

</html>