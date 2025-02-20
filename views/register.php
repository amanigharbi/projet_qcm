<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
    <?php include 'menu.php'; ?>


    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="register.php" class="bg-white text-violet-700 px-4 py-2 rounded mr-2">S'inscrire</a>
            <a href="login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
        </div>
    </nav>


    <!-- Formulaire d'inscription -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md custom-width">
            <h2 class="text-2xl font-semibold text-center mb-6">Inscription</h2>
            <form>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700">Nom</label>
                        <input type="text" class="w-full p-2 border rounded mt-1" placeholder="Nom">
                    </div>
                    <div>
                        <label class="block text-gray-700">Prénom</label>
                        <input type="text" class="w-full p-2 border rounded mt-1" placeholder="Prénom">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Pseudo</label>
                    <input type="text" class="w-full p-2 border rounded mt-1" placeholder="Pseudo">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" class="w-full p-2 border rounded mt-1" placeholder="Email">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Confirmation de l’email</label>
                    <input type="email" class="w-full p-2 border rounded mt-1" placeholder="Confirmez votre email">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700">Mot de passe</label>
                        <input type="password" class="w-full p-2 border rounded mt-1" placeholder="Mot de passe">
                    </div>
                    <div>
                        <label class="block text-gray-700">Confirmation du mot de passe</label>
                        <input type="password" class="w-full p-2 border rounded mt-1" placeholder="Confirmez le mot de passe">
                    </div>
                </div>
                <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Valider</button>
            </form>
            <div class="text-center mt-4">
                <p>Déjà un compte?
                    <a href="login.php" class="text-blue-600 hover:underline"> Connectez-vous</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>