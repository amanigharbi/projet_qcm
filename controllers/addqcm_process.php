<?php
require_once __DIR__ . '/../bdd/Database.php';
session_start();

try {
    $database = new Database();
    $pdo = $database->conn;
    if (!$pdo) {
        header("Location: ../views/feedback.php?status=error&message=Erreur+de+connexion+à+la+base+de+données");
        exit();
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO qcm (titre, description, createur_id, categorie_id, cree_le, mis_a_jour_le) 
        VALUES (:titre, :description, :createur_id, 
                (SELECT id FROM categories WHERE nom = :categorie), 
                NOW(), NOW())
    ");
    $stmt->execute([
        ':titre'       => $_POST['titre'],
        ':description' => $_POST['description'],
        ':createur_id' => $_SESSION['user_id'],
        ':categorie'   => $_POST['categorie']
    ]);

    $qcmId = $pdo->lastInsertId();

    $tags = explode(',', $_POST['tags']);
    foreach ($tags as $tagName) {
        $tagName = trim($tagName);
        if (!empty($tagName)) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO tags (nom) VALUES (:nom)");
            $stmt->execute([':nom' => $tagName]);

            $stmt = $pdo->prepare("SELECT id FROM tags WHERE nom = :nom");
            $stmt->execute([':nom' => $tagName]);
            $tagId = $stmt->fetchColumn();

            $stmt = $pdo->prepare("INSERT INTO qcm_tags (qcm_id, tag_id) VALUES (:qcm_id, :tag_id)");
            $stmt->execute([
                ':qcm_id' => $qcmId,
                ':tag_id'  => $tagId
            ]);
        }
    }

    foreach ($_POST['questions'] as $questionData) {
        $stmt = $pdo->prepare("
            INSERT INTO questions (qcm_id, texte_question, type_question, cree_le, mis_a_jour_le) 
            VALUES (:qcm_id, :texte_question, 'qcm', NOW(), NOW())
        ");
        $stmt->execute([
            ':qcm_id' => $qcmId,
            ':texte_question'  => $questionData['question']
        ]);
        $questionId = $pdo->lastInsertId();

        foreach ($questionData['answers'] as $index => $answerText) {
            $isCorrect = ($index == $questionData['correct']) ? 1 : 0;
            $stmt = $pdo->prepare("
                INSERT INTO reponses_utilisateur (question_id, texte_reponse, est_correcte, cree_le, mis_a_jour_le) 
                VALUES (:question_id, :texte_reponse, :est_correcte, NOW(), NOW())
            ");
            $stmt->execute([
                ':question_id' => $questionId,
                ':texte_reponse' => $answerText,
                ':est_correcte' => $isCorrect
            ]);
        }
    }

    $pdo->commit();

    header("Location: ../views/feedback.php?status=success&message=Votre+QCM+a+été+ajouté+avec+succès");
    exit();
} catch (PDOException $e) {
    $pdo->rollBack();
    header("Location: ../views/feedback.php?status=error&message=Une+erreur+s'est+produite:" . urlencode($e->getMessage()));
    exit();
}
