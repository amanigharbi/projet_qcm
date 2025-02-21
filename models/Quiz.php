<?php
require_once dirname(__DIR__) . '/bdd/Database.php';

class Quiz
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->conn;
    }

    public function getAllQuizzes()
    {
        $stmt = $this->pdo->query("SELECT * FROM qcm");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserScores($user_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT r.score, r.complete_le AS date, q.titre, 
                   (SELECT COUNT(*) FROM questions WHERE qcm_id = r.qcm_id) AS total_questions
            FROM resultats_utilisateur_qcm r
            JOIN qcm q ON r.qcm_id = q.id
            WHERE r.utilisateur_id = ?
            ORDER BY r.complete_le DESC
        ");

        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuestionsByQcmId($qcm_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE qcm_id = ?");
        $stmt->execute([$qcm_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReponses($question_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM reponses_utilisateur WHERE question_id = ?");
        $stmt->execute([$question_id]);
        $reponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($reponses)) {
            die("Aucune réponse trouvée pour la question ID : " . $question_id);
        }

        return $reponses;
    }



    public function verifyAnswer($reponse_id)
    {
        $stmt = $this->pdo->prepare("SELECT est_correcte FROM reponses_utilisateur WHERE id = ?");
        $stmt->execute([$reponse_id]);
        return $stmt->fetchColumn() == 1;
    }
    public function saveResult($utilisateur_id, $qcm_id, $score)
    {
        $stmt = $this->pdo->prepare("INSERT INTO resultats_utilisateur_qcm (utilisateur_id, qcm_id, score, complete_le) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$utilisateur_id, $qcm_id, $score]);
    }
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM qcm");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM qcm WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($title, $description, $creatorId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO qcm (title, description, creator_id) VALUES (?, ?, ?)");
        return $stmt->execute([$title, $description, $creatorId]);
    }
}
