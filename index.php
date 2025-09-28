<?php 
    include_once 'header.php'
?>

    <h1 id="index-text">Bienvenue, <?php if(isset($_SESSION['id'])){
        echo explode(" ", $_SESSION['pseudo'])[0];
    }else{
        echo 'Invité';
    } 
    ?>
    

