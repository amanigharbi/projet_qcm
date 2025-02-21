
<?php
require_once '../models/User.php';
require_once __DIR__ . '/../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private $db;

    private $userModel;

    public function __construct()
    {
        $this->db = new Database();

        $this->userModel = new User();
    }
    public function register(string $username, string $email, string $password): mixed
    {
        // vérifier si l'email existe déjà
        $stmt = $this->db->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            return "Cet email est déjà enregistré.";
        }




        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $confirmationToken = bin2hex(random_bytes(32));

        // insérer l'utilisateur dans la bdd 
        $stmt = $this->db->conn->prepare("INSERT INTO users (username, email, password, confirmation_token, is_active) VALUES (?, ?, ?, ?, 0)");
        $stmt->execute([$username, $email, $hashedPassword, $confirmationToken]);




        // email de confirmation
        if ($this->sendConfirmationEmail($email, $confirmationToken, $username)) {
            return true;
        } else {
            return "Erreur lors de l'envoi de l'email de confirmation.";
        }
    }


    private function sendConfirmationEmail(string $email, string $token, string $username): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['MAIL_PORT'];


            $mail->setFrom('no-reply@example.com', 'AZAQUIZZ');
            $mail->addAddress($email, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre inscription';
            $confirmationLink = 'http://localhost/QCMProject/confirm.php?token=' . $token;
            $mail->Body    = "Bonjour $username,<br><br>Veuillez cliquer sur le lien suivant pour confirmer votre inscription: <a href='$confirmationLink'>$confirmationLink</a>";
            $mail->AltBody = "Bonjour $username, Veuillez copier ce lien dans votre navigateur pour confirmer votre inscription: $confirmationLink";

            $mail->send();

            // notification
            $this->sendAccountCreationNotification($email, $username);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function confirmRegistration(string $token)
    {
        $stmt = $this->db->conn->prepare("SELECT id, email, username FROM users WHERE confirmation_token=?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $stmt = $this->db->conn->prepare("UPDATE users SET is active=1, confirmation_token=NULL WHERE id=?");
            $stmt->execute($user['id']);
            return true;
        } else {
            return "Token invalide ou expiré.";
        }
    }


    private function sendAccountCreationNotification(string $email, string $username): void
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = '5de6224ba106f1';
            $mail->Password   = 'acba8c7cf472f0';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            $mail->setFrom('no-reply@example.com', 'AZAQUIZZ');
            $mail->addAddress($email, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Votre compte a été créé';
            $mail->Body    = "Bonjour $username,<br><br>Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
            $mail->AltBody = "Bonjour $username, Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";

            $mail->send();
        } catch (Exception $e) {
        }
    }

    public function getUserProfile($user_id)
    {
        return $this->userModel->getUserById($user_id);
    }
}
