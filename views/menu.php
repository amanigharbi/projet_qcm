<?php
require_once '../models/Quiz.php';
$quiz = new Quiz();
$categories = $quiz->getAllCategories();
?>
<!-- Fond semi-transparent pour masquer la page quand le menu est ouvert -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick="closeMenu()"></div>

<!-- Menu Latéral -->
<div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-violet-700 text-white transform -translate-x-full transition-transform duration-300">
    <div class="p-4 flex justify-between items-center">
        <?php
        $targetHome = isset($_SESSION['user_id']) ? 'home.php' : 'index.php';
        ?>

        <a href="<?= $targetHome; ?>">
            <h2 class="text-2xl font-bold">AzaQuizz</h2>
        </a> <button onclick="closeMenu()" class="text-white text-2xl">&times;</button>
    </div>

    <nav class="mt-6">
        <div>
            <input type="checkbox" id="qcm-menu" class="peer hidden">
            <label for="qcm-menu" class="block w-full text-left py-2 px-4 hover:bg-violet-600 cursor-pointer flex justify-between items-center">
                Testes ta culture ! <span>▾</span>
            </label>
            <div class="hidden peer-checked:block bg-violet-600">
                <input type="checkbox" id="themes-menu" class="peer hidden">
                <label for="themes-menu" class="block w-full text-left py-2 px-6 hover:bg-violet-500 cursor-pointer flex justify-between items-center">
                    Par thèmes <span>▾</span>
                </label>
                <div class="hidden peer-checked:block bg-violet-500">
                    <?php foreach ($categories as $categorie) : ?>
                        <a href="ListQCM.php?categorie_id=<?= htmlspecialchars($categorie['id']); ?>"
                            class="block py-2 px-8 hover:bg-violet-400">
                            <?= htmlspecialchars($categorie['nom']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <a href="ListQCM.php" class="block py-2 px-6 hover:bg-violet-500">Tous les QCM</a>
            </div>
        </div>

        <div>
            <input type="checkbox" id="mes-qcm-menu" class="peer hidden">
            <label for="mes-qcm-menu" class="block w-full text-left py-2 px-4 hover:bg-violet-600 cursor-pointer flex justify-between items-center">
                Mes QCM <span>▾</span>
            </label>
            <div class="hidden peer-checked:block bg-violet-600">
                <a href="#" class="block py-2 px-6 hover:bg-violet-500">Consulter mes QCM</a>
                <a href="#" class="block py-2 px-6 hover:bg-violet-500">Ajouter un QCM</a>
                <a href="#" class="block py-2 px-6 hover:bg-violet-500">Modifier mes QCM</a>
            </div>
        </div>

        <?php
        $targetResult = isset($_SESSION['user_id']) ? 'MyResult.php' : 'index.php';
        $targetProfile = isset($_SESSION['user_id']) ? 'profile.php' : 'index.php';
        ?>

        <a href="<?= $targetResult; ?>" class="block py-2 px-4 hover:bg-violet-600">Mes résultats</a>
        <a href="<?= $targetProfile; ?>" class="block py-2 px-4 hover:bg-violet-600">Mon profil</a>
    </nav>

    <p class="text-sm p-4 mt-auto">Copyright ©2025 AzaQuizz</p>
</div>