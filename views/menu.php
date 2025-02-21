<?php
require_once dirname(__DIR__) . '/models/Quiz.php';

$quiz = new Quiz();
$categories = $quiz->getAllCategories();

// Vérifie si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

$targetHome = $isLoggedIn ? 'home.php' : 'index.php';
$targetResult = $isLoggedIn ? 'MyResult.php' : 'index.php';
$targetProfile = $isLoggedIn ? 'profile.php' : 'index.php';
?>

<!-- Fond semi-transparent pour masquer la page quand le menu est ouvert -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick="closeMenu()"></div>

<!-- Menu Latéral -->
<div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-violet-700 text-white transform -translate-x-full transition-transform duration-300">
    <div class="p-4 flex justify-between items-center">
        <a href="<?= $targetHome; ?>">
            <h2 class="text-2xl font-bold">AzaQuizz</h2>
        </a>
        <button onclick="closeMenu()" class="text-white text-2xl">&times;</button>
    </div>

    <nav class="mt-6">
        <!-- Teste ta culture -->
        <div>
            <input type="checkbox" id="qcm-menu" class="peer hidden">
            <label for="qcm-menu" class="block w-full text-left py-2 px-4 hover:bg-violet-600 cursor-pointer flex justify-between items-center">
                Teste ta culture ! <span>▾</span>
            </label>
            <div class="hidden peer-checked:block bg-violet-600">
                <input type="checkbox" id="themes-menu" class="peer hidden">
                <label for="themes-menu" class="block w-full text-left py-2 px-6 hover:bg-violet-500 cursor-pointer flex justify-between items-center">
                    Par thèmes <span>▾</span>
                </label>
                <div class="hidden peer-checked:block bg-violet-500">
                    <?php if ($isLoggedIn) : ?>
                        <?php foreach ($categories as $categorie) : ?>
                            <a href="ListQCM.php?categorie_id=<?= htmlspecialchars($categorie['id']); ?>"
                                class="block py-2 px-8 hover:bg-violet-400">
                                <?= htmlspecialchars($categorie['nom']); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="block py-2 px-8 text-gray-300">Connectez-vous pour voir les catégories</p>
                    <?php endif; ?>
                </div>
                <?php if ($isLoggedIn) : ?>
                    <a href="ListQCM.php" class="block py-2 px-6 hover:bg-violet-500">Tous les QCM</a>
                <?php else : ?>
                    <p class="block py-2 px-6 text-gray-300">Connectez-vous pour voir les QCM</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mes QCM -->
        <div>
            <input type="checkbox" id="mes-qcm-menu" class="peer hidden">
            <label for="mes-qcm-menu" class="block w-full text-left py-2 px-4 hover:bg-violet-600 cursor-pointer flex justify-between items-center">
                Mes QCM <span>▾</span>
            </label>
            <div class="hidden peer-checked:block bg-violet-600">
                <?php if ($isLoggedIn) : ?>
                    <a href="#" class="block py-2 px-6 hover:bg-violet-500">Consulter mes QCM</a>
                    <a href="#" class="block py-2 px-6 hover:bg-violet-500">Ajouter un QCM</a>
                    <a href="#" class="block py-2 px-6 hover:bg-violet-500">Modifier mes QCM</a>
                <?php else : ?>
                    <p class="block py-2 px-6 text-gray-300">Connectez-vous pour voir vos QCM</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mes Résultats -->
        <div>
            <input type="checkbox" id="mes-resultats-menu" class="peer hidden">
            <label for="mes-resultats-menu" class="block w-full text-left py-2 px-4 hover:bg-violet-600 cursor-pointer flex justify-between items-center">
                Mes résultats <span>▾</span>
            </label>
            <div class="hidden peer-checked:block bg-violet-600">
                <?php if ($isLoggedIn) : ?>
                    <a href="<?= $targetResult; ?>" class="block py-2 px-6 hover:bg-violet-500">Voir mes résultats</a>
                <?php else : ?>
                    <p class="block py-2 px-6 text-gray-300">Connectez-vous pour voir vos résultats</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mon Profil -->
        <div>
            <input type="checkbox" id="mon-profil-menu" class="peer hidden">
            <label for="mon-profil-menu" class="block w-full text-left py-2 px-4 hover:bg-violet-600 cursor-pointer flex justify-between items-center">
                Mon profil <span>▾</span>
            </label>
            <div class="hidden peer-checked:block bg-violet-600">
                <?php if ($isLoggedIn) : ?>
                    <a href="<?= $targetProfile; ?>" class="block py-2 px-6 hover:bg-violet-500">Voir mon profil</a>
                <?php else : ?>
                    <p class="block py-2 px-6 text-gray-300">Connectez-vous pour voir votre profil</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- À propos -->
        <div>
            <?php if ($isLoggedIn) : ?>
                <a href="about.php" class="block py-2 px-6 hover:bg-violet-500">A propos</a>
            <?php else : ?>
                <a href="views/about.php" class="block py-2 px-6 hover:bg-violet-500">A propos</a>
            <?php endif; ?>
        </div>
    </nav>

    <p class="text-sm p-4 mt-auto">Copyright ©2025 AzaQuizz</p>
</div>

<script>
    function closeMenu() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('overlay').classList.add('hidden');
    }

    function openMenu() {
        document.getElementById('sidebar').classList.remove('-translate-x-full');
        document.getElementById('overlay').classList.remove('hidden');
    }
</script>