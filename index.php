<?php 
    include_once 'views/header.php'
?>

    <h1 id="index-text">Bienvenue, <?php if(isset($_SESSION['usersId'])){
        echo explode(" ", $_SESSION['usersName'])[0];
    }else{
        echo 'Guest';
    } 
    ?>
    

