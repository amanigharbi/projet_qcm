<?php
session_start();

// Si l'utilisateur est connecté, on le redirige vers la page home.php
if (isset($_SESSION['user_id'])) {
    header("Location: views/home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azaquizz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
</head>

<body class="bg-gray-100">
    <?php include 'views/menu.php'; ?>

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="views/register.php" class="bg-white text-purple-700 px-4 py-2 rounded mr-2">S'inscrire</a>
            <a href="views/login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
        </div>
    </nav>

    <!-- Présentation -->
    <main class="text-center py-12">
        <h1 class="text-4xl font-bold">AZAQUIZZ</h1>
        <p class="text-lg text-gray-600">Défiez votre culture générale</p>

        <div class="mt-4 space-x-4">
            <button class="bg-gray-200 text-black px-4 py-2 rounded">Au hasard</button>
            <button class="bg-black text-white px-4 py-2 rounded">Par thème</button>
        </div>
    </main>

    <!-- Section image -->
    <section class="flex justify-center space-x-4 py-8">
        <div class="w-64 h-40 bg-gray-300 flex items-center justify-center text-white text-xl">Introduction</div>
        <div class="w-64 h-40 bg-gray-300 flex items-center justify-center text-white text-xl">Image</div>
    </section>

    <!-- Catégories -->
    <section class="max-w-4xl mx-auto py-8">
        <h2 class="text-xl font-semibold">Thèmes</h2>
        <div class="grid grid-cols-2 gap-6 mt-4 text-gray-700">
            <div> <strong>Histoire</strong>
                <img src="https://cdn.pixabay.com/photo/2018/05/17/16/03/compass-3408928_1280.jpg" alt="Histoire" class="w-full h-32 object-cover mt-2">
            </div>
            <div> <strong>Géographie</strong>
                <img src="https://cdn.pixabay.com/photo/2021/11/23/21/48/continents-6819704_1280.jpg" alt="Géographie" class="w-full h-32 object-cover mt-2">
            </div>
            <div> <strong>Cinéma</strong>
                <img src="https://cdn.pixabay.com/photo/2017/09/30/10/11/camera-2801675_1280.jpg" alt="Cinéma" class="w-full h-32 object-cover mt-2">
            </div>
            <div> <strong>Science</strong>
                <img src="https://cdn.pixabay.com/photo/2022/03/25/14/25/analysis-7091203_1280.jpg" alt="Science" class="w-full h-32 object-cover mt-2">
            </div>
            <div> <strong>Art</strong>
                <img src="https://cdn.pixabay.com/photo/2017/12/28/16/18/bicycle-3045580_1280.jpg" alt="Art" class="w-full h-32 object-cover mt-2">
            </div>
            <div> <strong>Sport</strong>
                <img src="https://cdn.pixabay.com/photo/2016/02/15/11/43/running-track-1201014_1280.jpg" alt="Sport" class="w-full h-32 object-cover mt-2">
            </div>
        </div>
    </section>
</body>

</html>