<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: views/home.php");
    exit();
}
require_once 'models/Quiz.php';

// Récupération des catégories depuis la base de données
$categorieModel = new Quiz();
$categories = $categorieModel->getAllCategories();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Azaquizz</title>
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
    <?php include 'views/menu.php'; ?>
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">

        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="views/register.php" class="bg-white text-purple-700 px-4 py-2 rounded mr-2">S'inscrire</a>
            <a href="views/login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
        </div>
    </nav>

    <main class="text-center py-12">
        <h1 id="site-title" class="text-5xl font-bold w-full text-black">AzaQuizz</h1>
    </main>

    <section class="flex flex-col items-center justify-center py-8 w-full max-w-screen-lg mx-auto">
        <div class="flex items-center justify-between w-full">
            <div class="w-1/3 flex justify-center">
                <img src="Image/logo_violet.svg" alt="Logo" class="max-h-40 max-w-full mix-blend-multiply opacity-90">
            </div>
            <div class="w-2/3 text-left text-lg font-semibold px-4">
                Bienvenue sur AzaQuizz, votre destination incontournable pour des quiz interactifs captivants ! Plongez dans un monde d'apprentissage ludique avec des défis variés sur des thèmes passionnants tels que l'histoire, la science, le cinéma et bien plus encore. Testez vos connaissances, ajoutez vos propres QCM et partagez-les avec la communauté. Amusez-vous tout en apprenant et défiez vos amis pour voir qui est le plus futé ! Rejoignez-nous dès aujourd'hui et transformez vos moments de loisir en opportunités d'apprentissage enrichissantes ! 🧠✨ </div>
        </div>
        </div>

        <div class="py-8"></div>

        <section class="w-full">
            <h2 class="text-2xl font-semibold text-center mb-4">Thèmes</h2>
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <?php foreach ($categories as $categorie) : ?>
                    <div class="text-center">
                        <strong><?= htmlspecialchars($categorie['nom']) ?></strong>
                        <img src="<?= htmlspecialchars($categorie['image']) ?>" alt="<?= htmlspecialchars($categorie['nom']) ?>"
                            class="w-full h-32 object-cover mt-2 rounded-lg">
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const title = document.getElementById("site-title");
            title.style.opacity = 0;
            setTimeout(() => {
                title.style.transition = "opacity 1.5s ease-in-out";
                title.style.opacity = 1;
            }, 500);
        });
    </script>
</body>

</html>