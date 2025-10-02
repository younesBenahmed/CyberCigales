<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../models/ResetPasswords.php';
require_once '../helpers/session_helper.php';
require_once '../models/User.php';

//Require PHP Mailer 
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/SMTP.php';

class ResetPasswordsController{
    private $resetModel;
    private $userModel;
    private $mail;

    public function __construct()
    {
    $this->resetModel = new ResetPassword;
    $this->userModel = new User;
    // Set up PHPMailer
    $this->mail = new PHPMailer();
    $this->mail->SMTPDebug = 0;
    $this->mail->isSMTP();
    $this->mail->Host = "smtp.gmail.com";
    $this->mail->SMTPAuth = true;   
    $this->mail->Username = "cybercigales@gmail.com";
    $this->mail->Password = "megr wvzc czjy iejh ";
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = 587;
}

    public function sendEmail(){
        $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $usersEmail = trim($_POST['usersEmail']);

        if(empty($usersEmail)){
            flash("reset", "SVP rentrée un email");
            redirect("../reset-password.php");
        }

        if(!filter_var($usersEmail, FILTER_VALIDATE_EMAIL)){
            flash("reset", "Email invalide");
            redirect("../reset-password.php");
        }

        //Sera utilisé pour interroger l'utilisateur à partir de la base de données.
        $selector = bin2hex(random_bytes(8));
        // sera utilisé pour confirmation une fois que l'entrée dans la base de données aura été trouvée
        $token = random_bytes(32);
        $url = "https://benahmed.alwaysdata.net/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        // Expire au bout de 30 minutes
        $expires = date("U") + 1800;
        if(!$this->resetModel->deleteEmail($usersEmail)){
            die ("There was an error");
        }
        $hashedToken = password_hash(bin2hex($token), PASSWORD_DEFAULT);
        if(!$this->resetModel->insertToken($usersEmail, $selector, $hashedToken, $expires)){
            die ("There was an error");
        }
        //Envoyer l'email
        $subject = 'Réinitialisation de votre mot de passe';
        $message = '<p>Nous avons reçu une demande de réinitialisation de mot de passe. Le lien pour réinitialiser votre mot de passe est le suivant : </p>';
        $message .= '<p>Voici votre lien de réinitialisation : </br>';
        $message .= '<a href="' . $url . '">' . $url . '</a</p>';

        $this->mail->setFrom('cybercigales@gmail.com', 'CyberCigales'); 
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->addAddress($usersEmail);

        $this->mail->send();

        flash("reset", "Un email de réinitialisation a été envoyé !", 'form-message form-messge-green');
        redirect("../reset-password.php");
    }
    public function resetPassword(){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_DEFAULT);
        $data = [
            'selector' => trim($_POST['selector']),
            'validator' => trim($_POST['validator']),
            'pwd' => trim($_POST['pwd']),
            'pwd-repeat' => trim($_POST['pwd-repeat'])
        ];
        $url = 'https://benahmed.alwaysdata.net/create-new-password.php?selector=' . $data['selector'] . 
        '&validator=' . $data['validator'];

        if(empty($_POST['pwd']) || empty($_POST['pwd-repeat'])){
            flash("newpwd", "SVP remplissez tous les champs");
            redirect($url);
        } else if($data['pwd'] != $data['pwd-repeat']){
            flash("newReset", "Les mots de passe ne correspondent pas");
            redirect($url);
        } else if(strlen($data['pwd']) < 6){
            flash("newReset", "Le mot de passe doit contenir au moins 6 caractères");
            redirect($url);
        }

        $currentDate = date("U");
        if(!$row = $this->resetModel->resetPassword($data['selector'], $currentDate)){
            flash("newReset", "Vous devez renvoyer une nouvelle demande de réinitialisation de mot de passe.");
            redirect($url);
        }

        $tokenBin = hex2bin($data['validator']);
        $tokenCheck = password_verify($tokenBin, $row->pwdResetToken);
        if(!$tokenCheck){
            flash("newReset", "Vous devez renvoyer une nouvelle demande de réinitialisation de mot de passe.");
            redirect($url);
        }

        $tokenEmail = $row->pwdResetEmail;
        if(!$this->userModel->findUserByEmailOrUsername($tokenEmail, $tokenEmail)){
            flash("newReset", "Il n'y a pas d'utilisateur avec cet email.");
            redirect($url);
        }

        $newPwdHash = password_hash($data['pwd'], PASSWORD_DEFAULT);
        if(!$this->userModel->resetPassword($newPwdHash, $tokenEmail)){
            flash("newReset", "Il y a eu une erreur.");
            redirect($url);
        }

        if(!$this->resetModel->deleteEmail($tokenEmail)){
            flash("newReset", "Il y a eu une erreur.");
            redirect($url);
        }

        flash("newReset", "Votre mot de passe a été mis à jour ! Vous pouvez vous connecter avec votre nouveau mot de passe.", 'form-message form-message-green');
        redirect($url);
    }
}

$init = new ResetPasswordsController;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['type']){
        case 'send':
            $init->sendEmail();
            break;
        case 'reset':
            $init->resetPassword();
            break;
        default:
        header("location: ../index.php");
    }
}else {
    header("location: ../index.php");
}

