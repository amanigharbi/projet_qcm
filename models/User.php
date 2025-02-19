<?php
require_once __DIR__ . '/../bdd/Database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php'; 

// Charge les variables d'environnement depuis le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Connexion de l'utilisateur
    public function login($emailOrUsername, $password) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :identifier OR nom_utilisateur = :identifier";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['identifier' => $emailOrUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "Utilisateur non trouvé.";
        }

        // Vérifier le mot de passe (en clair ou hashé)
        if ($password === $user['mot_de_passe'] || password_verify($password, $user['mot_de_passe'])) {
            // Mot de passe valide
        } else {
            return "Mot de passe incorrect.";
        }

        if ($user['est_confirme'] == 0) {
            return "Votre compte n'est pas confirmé.";
        }

        // Stocker les infos en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];

        return true;
    }

    // Générer un code de réinitialisation et envoyer l'e-mail
    public function generateResetCode($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "Aucun compte trouvé avec cet email.";
        }

        $resetCode = bin2hex(random_bytes(20));
        $expiration = date('Y-m-d H:i:s', strtotime('+2 hour'));

        $sql = "UPDATE utilisateurs SET code_reinitialisation = :code, expiration_code_reinitialisation = :expiration WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'code' => $resetCode,
            'expiration' => $expiration,
            'email' => $email
        ]);

        return $this->sendResetEmail($email, $resetCode);
    }

  
    function sendResetEmail($email, $resetCode) {
        $mail = new PHPMailer(true);
    
        try {
            // Configuration SMTP
            $mail->isSMTP();  
            $mail->Host = $_ENV['MAIL_HOST'];  
            $mail->SMTPAuth = true; 
            $mail->Username = $_ENV['MAIL_USERNAME']; 
            $mail->Password = $_ENV['MAIL_PASSWORD'];  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
            $mail->Port = $_ENV['MAIL_PORT'];  

            // Paramètres de l'email
            $mail->setFrom($_ENV['MAIL_FROM_EMAIL'], $_ENV['MAIL_FROM_NAME']); 
            $mail->addAddress($email);  
            $mail->Subject = "Réinitialisation de votre mot de passe";  
            $mail->isHTML(true); 
            $mail->Body = 'Cliquez sur ce lien pour réinitialiser votre mot de passe : 
            <a href="http://localhost/QCMProject/views/reset_password.php?code=' . $resetCode . '">Réinitialiser mon mot de passe</a>';
            $mail->CharSet = 'UTF-8';

    
            // Envoi de l'e-mail
            $mail->send();  
            return true;
        } catch (Exception $e) {
            return "Erreur d'envoi : " . $mail->ErrorInfo;
        }
    }
    
    

    // Réinitialisation du mot de passe
    // public function resetPassword($code, $newPassword) {
    //     $sql = "SELECT * FROM utilisateurs WHERE code_reinitialisation = :code AND expiration_code_reinitialisation > NOW()";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute(['code' => $code]);
    //     $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if (!$user) {
    //         return "Lien de réinitialisation invalide ou expiré.";
    //     }

    //     $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    //     $sql = "UPDATE utilisateurs SET mot_de_passe = :password, code_reinitialisation = NULL, expiration_code_reinitialisation = NULL, est_reinitialise = 1 WHERE id = :id";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([
    //         'password' => $hashedPassword,
    //         'id' => $user['id']
    //     ]);

    //     return true;
    // }
    public function resetPassword($code, $newPassword) {
        // 1. Vérifier si le code est valide et non expiré
        $sql = "SELECT * FROM utilisateurs WHERE code_reinitialisation = :code AND expiration_code_reinitialisation > NOW()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$user) {
            return "Lien de réinitialisation invalide ou expiré.";
        }
    
        // 2. Hacher le nouveau mot de passe avant de le sauvegarder
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        // 3. Mettre à jour le mot de passe et supprimer le code de réinitialisation
        $sql = "UPDATE utilisateurs 
                SET mot_de_passe = :password, 
                    code_reinitialisation = NULL, 
                    expiration_code_reinitialisation = NULL 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $user['id']
        ]);
    
        return true; // Succès
    }
    
}
?>
