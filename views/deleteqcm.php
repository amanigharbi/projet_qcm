<?php
session_start();
require_once __DIR__ . '/../bdd/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: myqcm.php?status=error&message=ID du QCM manquant.");
    exit;
}

$qcmId = $_GET['id'];
$userId = $_SESSION['user_id'];
$database = new Database();
$pdo = $database->conn;

try {
    $pdo->beginTransaction(); // Début de transaction

    // Supprimer les entrées associées dans qcm_tags
    $stmt1 = $pdo->prepare("DELETE FROM qcm_tags WHERE qcm_id = ?");
    $stmt1->execute([$qcmId]);

    // Supprimer le QCM après avoir supprimé ses dépendances
    $stmt2 = $pdo->prepare("DELETE FROM qcm WHERE id = ? AND createur_id = ?");
    $stmt2->execute([$qcmId, $userId]);

    $pdo->commit(); // Validation des suppressions
    header("Location: myqcm.php?status=success&message=QCM supprimé avec succès.");
} catch (PDOException $e) {
    $pdo->rollBack(); // Annulation en cas d'erreur
    header("Location: myqcm.php?status=error&message=Erreur: " . $e->getMessage());
}
exit;
