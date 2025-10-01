<?php 

require_once '../config/Database.php';

class ResetPassword{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function deleteEmail($email){
        $this->db->query('DELETE FROM resetpasswords WHERE resetEmail = :email');
        $this->db->bind(':email', $email);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function insertToken($email, $selector, $hashedToken, $expires){
        $this->db->query('INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, 
        pwdResetExpires) VALUES (:email, :selector, :token, :expires)');

        $this->db->query('SELECT id FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->bind(':selector', $selector);
        $this->db->bind(':token', $hashedToken);
        $this->db->bind(':expires', $expires);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}