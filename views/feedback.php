<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$status = isset($_GET['status']) ? $_GET['status'] : 'success';
$message = isset($_GET['message']) ? $_GET['message'] : 'Votre QCM a été ajouté avec succès!';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - QCM</title>
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
    <?php include 'menu.php'; ?>
    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>

        <?php if (isset($_SESSION['nom'])): ?>
            <div class="flex items-center space-x-4 p-3 rounded-lg shadow-md bg-white">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['nom']); ?>&background=6B46C1&color=fff&size=40"
                        alt="Avatar" class="w-10 h-10 rounded-full border border-white shadow">
                    <span class="text-gray-900 font-bold text-lg"><?= htmlspecialchars($_SESSION['nom']); ?></span>
                </div>
                <a href="../controllers/logout.php" class="bg-white text-violet-700 px-4 py-2 rounded-lg border border-violet-700 hover:bg-violet-100 transition font-medium">
                    Déconnexion
                </a>
            </div>
        <?php endif; ?>
    </nav>

    <!-- popup  -->
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-sm mx-auto">
            <h2 class="text-2xl font-semibold mb-4 text-<?php echo $status == 'success' ? 'green-600' : 'red-600'; ?>">
                <?php echo $status == 'success' ? 'Succès' : 'Erreur'; ?>
            </h2>
            <p class="mb-6"><?php echo htmlspecialchars($message); ?></p>
            <button id="redirectButton" class="bg-violet-700 text-white px-4 py-2 rounded hover:bg-violet-600 transition duration-300">
                OK
            </button>
        </div>
    </div>

    <script>
        // bouton est cliqué -> rediriger
        document.getElementById('redirectButton').addEventListener('click', function() {
            <?php if ($status == 'success') { ?>
                window.location.href = "Myqcm.php";
            <?php } else { ?>
                window.location.href = "addqcm.php";
            <?php } ?>
        });

        // redirection automatique après 3s
        setTimeout(function() {
            <?php if ($status == 'success') { ?>
                window.location.href = "../views/Myqcm.php";
            <?php } else { ?>
                window.location.href = "../views/addqcm.php";
            <?php } ?>
        }, 3000);
    </script>
</body>

</html>