<?php
require_once __DIR__ . '/../bdd/Database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $confirmationResult = $authController->confirmRegistration($token);

    if ($confirmationResult === true) {
        $message = "Votre compte a été confirmé avec succès. Vous pouvez maintenant vous connecter.";
    } else {
        $message = "Erreur lors de la confirmation du compte: " . $confirmationResult;
    }
} else {
    $message = "Token de confirmation invalide.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation du compte</title>
</head>

<body>
    <h2>Confirmation du compte</h2>
    <p><?php echo $message; ?></p>
    <p><a href="login.php">Se connecter</a></p>
</body>

</html>