<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../models/ResetPassword.php';
require_once '../helpers/session_helper.php';
require_once '../models/User.php';

//Require PHP Mailer 
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/SMTP.php';

class ResetPassword{
    private $resetModel;
    private $userModel;
    private $mail;

    public function __construct()
    {
        $this->resetModel = new ResetPassword;
        $this->userModel = new User;
        // Set up PHPMailer
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = ''; // Rajouter l'username une fois le mailer créé
        $this->mail->Password = ''; // Rajouter le mot de passe une fois le mailer créé 
    }

    public function sendEmail(){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $usersEmail = trim($_POST['usersEmail']);

        if(empty($usersEmail)){
            flash("reset", "Plese input email");
            redirect("../reset-password.php");
        }

        if(!filter_var($usersEmail, FILTER_VALIDATE_EMAIL)){
            flash("reset", "Invalid email");
            redirect("../reset-password.php");
        }

        //Sera utilisé pour interroger l'utilisateur à partir de la base de données.
        $selector = bin2hex(random_bytes(8));
        // sera utilisé pour confirmation une fois que l'entrée dans la base de données aura été trouvée
        $token = random_bytes(32);
        $url = "http://localhost:8080/login-system/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        // Expire au bout de 30 minutes
        $expires = date("U") + 1800;
        if(!$this->resetModel->deleteEmail($usersEmail)){
            die ("There was an error");
        }
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        if(!$this->resetModel->insertToken($usersEmail, $selector, $hashedToken, $expires)){
            die ("There was an error");
        }
        //Envoyer l'email
        $subject = 'Réinitialisation de votre mot de passe';
        $message = '<p>Nous avons reçu une demande de réinitialisation de mot de passe. Le lien pour réinitialiser votre mot de passe est le suivant : </p>';
        $message .= '<p>Voici votre lien de réinitialisation : </br>';
        $message .= '<a href="' . $url . '">' . $url . '</a</p>';

        $this->mail->setFrom(''); // Rajouter l'email quand nous l'aurons créé
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->addAddress($usersEmail);

        $this->mail->send();

        flash("reset", "Un email de réinitialisation a été envoyé !", 'form-message form-messge-green');
        redirect("../reset-password.php");
    }
}

$init = new ResetPasswords;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['type']){
        case 'send':
            $init->sendEmail();
            break;
    }
}

