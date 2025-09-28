<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Login System</title>
    <link rel="stylesheet" href="./style.css" type="text/css">
</head>
<body>
    <nav>
        <ul>
            <a href="index.php"><li>Accueil</li></a>
            <?php if(!isset($_SESSION['id'])) : ?>
                <a href="signup.php"><li>Inscription</li></a>
            <?php endif; ?>
        </ul>
    </nav>


