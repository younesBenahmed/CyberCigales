<?php 
    include_once 'header.php';
?>

    <h1 id="index-text">Bienvenue, <?php if(isset($_SESSION['user_id'])) {
        echo explode(" ", $_SESSION['user_pseudo'])[0];
    }else{
        echo 'Invité';
    } 
    ?> </h1>
    
<?php include_once 'footer.php'; ?>
