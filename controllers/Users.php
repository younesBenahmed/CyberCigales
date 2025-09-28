<?php
require_once '../models/User.php';

class Users {
    // Je stocke mon modèle User pour pouvoir l'utiliser dans toutes mes méthodes de cette classe
    private $userModel;
    
    // Le constructeur qui se lance automatiquement dès que je crée un objet Users
    public function __construct() {
        // Je crée une instance de ma classe User pour pouvoir faire des opérations en BDD
        // Maintenant je peux utiliser $this->userModel partout dans ma classe pour :
        // - Insérer un nouvel utilisateur
        // - Vérifier si un email existe déjà
        // - Récupérer un utilisateur pour le login
        // - etc.
        $this->userModel = new User;
    }
    
    // Ma méthode pour gérer l'inscription d'un nouvel utilisateur
    public function register(){
        // Je nettoie TOUTES les données POST en une seule fois
        // FILTER_SANITIZE_STRING va :
        // - Enlever les balises HTML (<script>, <img>, etc.)
        // - Supprimer les caractères dangereux
        // - Protéger contre les attaques XSS (cross-site scripting)
        // Exemple : si quelqu'un tape "<script>alert('hack')</script>" dans le prénom,
        // ça devient juste "scriptalert('hack')script" (inoffensif)
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Je récupère et nettoie toutes les données du formulaire d'inscription
        $data = [
            'prenom' => trim($_POST['prenom']), // Je récupère le prénom et j'enlève les espaces
            'nom' => trim($_POST['nom']), // Je récupère le nom et j'enlève les espaces
            'pseudo' => trim($_POST['pseudo']), // Je récupère le pseudo et j'enlève les espaces
            'email' => trim($_POST['email']), // Je récupère l'email et j'enlève les espaces
            'password' => trim($_POST['password']), // Je récupère le mot de passe
            'password_repeat' => trim($_POST['password_repeat']) // Je récupère la confirmation du mot de passe
        ];
        
        // Validation des inputs - je vérifie que tous les champs sont remplis
        if(empty($data['prenom']) || empty($data['nom']) || empty($data['pseudo']) || empty($data['email']) || empty($data['password']) || empty($data['password_repeat'])) {
            // code à venir
        }
    }
}

// Je crée une instance de ma classe Users pour pouvoir utiliser ses méthodes
$init = new Users;

// Je vérifie si quelqu'un a envoyé des données via un formulaire (méthode POST)
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Je regarde quel type d'action l'utilisateur veut faire
    switch($_POST['type']){
        case 'register': // Si c'est une inscription
            $init->register(); // J'appelle ma méthode register()
            break;
    }
}
?>