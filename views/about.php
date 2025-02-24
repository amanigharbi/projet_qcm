<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> À Propos - AzaQuizz </title>
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
            document.getElementById("overlay").classList.remove("hidden");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
            document.getElementById("overlay").classList.add("hidden");
        }
    </script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(195, 181, 253, 0.55), rgba(237, 233, 254, 0.5), rgba(255, 255, 255, 1));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 5px solid transparent;
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

    <!-- Navbar conditionnelle -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <div class="flex items-center space-x-4 p-3 rounded-lg shadow-md bg-white">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['nom'] ?? 'Utilisateur'); ?>&background=6B46C1&color=fff&size=40"
                        alt="Avatar" class="w-10 h-10 rounded-full border border-white shadow">
                    <span class="text-gray-900 font-bold text-lg"><?= htmlspecialchars($_SESSION['nom'] ?? 'Utilisateur'); ?></span>
                </div>
                <a href="../controllers/logout.php" class="bg-white text-violet-700 px-4 py-2 rounded-lg border border-violet-700 hover:bg-violet-100 transition font-medium">
                    Déconnexion
                </a>
            </div>
        <?php else : ?>
            <div>
                <a href="register.php" class="bg-white text-violet-700 px-4 py-2 rounded mr-2">S'inscrire</a>
                <a href="login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
            </div>
        <?php endif; ?>
    </nav>



    <!-- Présentation -->
    <main class="text-center py-6 w-full max-w-3xl mx-auto">
        <h1 id="site-title" class="text-5xl font-bold text-black">AzaQuizz</h1>
    </main>

    <section class="flex flex-col items-center justify-center py-4 w-full max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-700">À propos de nous<br></br></h2>
        <p class="text-base text-gray-600  leading-relaxed">
            Bienvenue sur AzaQuizz, une plateforme interactive de quiz conçue pour apprendre en s'amusant ! 🎉
            <br>Nous sommes trois passionnés de développement web et de culture générale, réunis dans le cadre de notre formation pour donner vie à ce projet.
            <br>AzaQuizz est né de notre envie de proposer un espace où chacun peut tester ses connaissances sur une multitude de thèmes : histoire, science, cinéma et bien plus encore.
            <br>Mais ce n'est pas tout ! Nous avons voulu rendre l'expérience encore plus interactive en permettant aux utilisateurs de créer et partager leurs propres QCM.
            <br>L’apprentissage devient ainsi collaboratif et plus enrichissant.
            <br>Ce projet est pour nous une occasion unique d'appliquer nos compétences tout en créant un site ludique et accessible à tous.
            <br>Nous espérons que vous prendrez autant de plaisir à jouer que nous en avons eu à développer AzaQuizz.
            <br>Merci de votre soutien et amusez-vous bien ! 🚀
        </p>
    </section>

</body>

</html>