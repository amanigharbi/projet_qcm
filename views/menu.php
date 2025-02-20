<!-- Fond semi-transparent pour masquer la page quand le menu est ouvert -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick="closeMenu()"></div>

<!-- Menu Latéral -->
<div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-violet-700 text-white transform -translate-x-full transition-transform duration-300">
    <div class="p-4 flex justify-between items-center">
        <h2 class="text-2xl font-bold">AzaQuizz</h2>
        <button onclick="closeMenu()" class="text-white text-2xl">&times;</button>
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
                    <a href="#" class="block py-2 px-8 hover:bg-violet-400">Histoire</a>
                    <a href="#" class="block py-2 px-8 hover:bg-violet-400">Géographie</a>
                    <a href="#" class="block py-2 px-8 hover:bg-violet-400">Sciences</a>
                    <a href="#" class="block py-2 px-8 hover:bg-violet-400">Cinéma</a>
                    <a href="#" class="block py-2 px-8 hover:bg-violet-400">Art</a>
                    <a href="#" class="block py-2 px-8 hover:bg-violet-400">Sport</a>
                </div>
                <a href="#" class="block py-2 px-6 hover:bg-violet-500">Tous les QCM</a>
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

        <a href="#" class="block py-2 px-4 hover:bg-violet-600">Mes résultats</a>
        <a href="#" class="block py-2 px-4 hover:bg-violet-600">Mon profil</a>
    </nav>

    <p class="text-sm p-4 mt-auto">Copyright ©2025 AzaQuizz</p>
</div>