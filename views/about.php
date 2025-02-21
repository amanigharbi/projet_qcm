<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> A Propos - Azaquizz</title>
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
            border: 5px solid transparent;
        }

        nav {
            position: relative;
        }

        .content {
            width: 90%;
            max-width: 1200px;
            padding: 20px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include 'menu.php'; ?>

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full fixed top-0 left-0 shadow-md z-50">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="../controllers/logout.php" class="bg-white text-violet-700 px-4 py-2 rounded mr-2">Se déconnecter</a>
            <a href="profil.php" class="bg-gray-900 text-white px-4 py-2 rounded">Mon profil</a>
        </div>
    </nav>

    <!-- Espace entre la navbar et la présentation -->
    <div class="py-8"></div>


    <!-- Présentation -->
    <main class="text-center py-6">
        <h1 id="site-title" class="text-5xl font-bold w-full text-black">AzaQuizz</h1>
    </main>

    <!-- Section image et catégories alignées -->
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