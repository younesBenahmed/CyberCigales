<?php

include_once 'header.php';
include_once 'helpers/session_helper.php';
?>

<h1 class="header"> Inscrivez-vous </h1>

<?php flash('register'); ?>

<form method="post" action="controllers/Users.php">
    <input type="hidden" name="type" value="register">
    
    <input type="text" name="prenom" 
           placeholder="Prénom...">
    
    <input type="text" name="nom" 
           placeholder="Nom...">
    
    <input type="text" name="pseudo" 
           placeholder="Pseudo...">
    
    <input type="email" name="email" 
           placeholder="Email...">
    
    <input type="password" name="password" 
           placeholder="Mot de passe...">
    
    <input type="password" name="password_repeat" 
           placeholder="Confirmer mot de passe...">
    
    <button type="submit" name="submit">S'inscrire</button>
</form>

