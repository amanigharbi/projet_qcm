<?php
require_once '../models/Quiz.php';
require_once '../bdd/database.php';

class QuizController
{
    private $pdo;
    public $quiz;

    public function __construct()
    {
        $this->pdo = (new Database())->conn;
        $this->quiz = new Quiz();
    }

    public function startQuiz($qcm_id, $utilisateur_id)
    {
        $questions = $this->quiz->getQuestionsByQcmId($qcm_id);
        shuffle($questions);


        $_SESSION['questions'] = $questions;
        $_SESSION['currentQuestion'] = 0;
        $_SESSION['score'] = 0;
        $_SESSION['responses'] = [];
        $_SESSION['total_questions'] = count($questions);
    }


    public function getCurrentQuestion()
    {
        if (!isset($_SESSION['questions'][$_SESSION['currentQuestion']])) {
            return null;
        }
        return $_SESSION['questions'][$_SESSION['currentQuestion']];
    }

    public function processAnswer($utilisateur_id, $question_id, $reponse_id)
    {
        $isCorrect = $this->quiz->verifyAnswer($reponse_id);
        if ($isCorrect) {
            $_SESSION['score']++;
        }

        $_SESSION['responses'][] = [
            'question' => $this->getQuestionText($question_id),
            'answer' => $this->getAnswerText($reponse_id),
            'isCorrect' => $isCorrect
        ];

        $_SESSION['currentQuestion']++;
    }

    public function isQuizFinished()
    {
        return $_SESSION['currentQuestion'] >= count($_SESSION['questions']);
    }

    public function finalizeQuiz($utilisateur_id, $qcm_id)
    {
        $score = $_SESSION['score'];
        $this->quiz->saveResult($utilisateur_id, $qcm_id, $score);
        return $score;
    }

    private function getQuestionText($question_id)
    {
        $questions = $_SESSION['questions'];
        foreach ($questions as $question) {
            if ($question['id'] == $question_id) {
                return $question['texte_question'];
            }
        }
        return null;
    }

    private function getAnswerText($reponse_id)
    {
        $stmt = $this->pdo->prepare("SELECT texte_reponse FROM reponses_utilisateur WHERE id = ?");
        $stmt->execute([$reponse_id]);
        return $stmt->fetchColumn();
    }
    public function modifyQcm($qcm_id, $title, $description, $questions, $cat_id)
    {
        // Met à jour le titre et la description du QCM
        $this->quiz->updateQcm($qcm_id, $title, $description, $cat_id);

        // Met à jour les questions et leurs réponses
        foreach ($questions as $question) {
            $this->quiz->updateQuestion($question['id'], $question['texte_question']);

            foreach ($question['reponses'] as $reponse) {
                $this->quiz->updateReponse($reponse['id'], $reponse['texte_reponse'], $reponse['est_correcte']);
            }
        }
    }
}
