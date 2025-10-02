<?php
    if(empty($_GET['selector']) || empty($_GET['validator'])) {
        echo "Nous ne pouvons pas valider votre demande de réinitialisation de mot de passe.";
    } else {
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];

        if(ctype_xdigit($selector) && ctype_xdigit($validator)) { ?>

<?php
    include_once 'header.php';
    include_once './helpers/session_helper.php';
?>

    <h1 class="header">Créer un nouveau mot de passe</h1>


    <form method="post" action="./controllers/ResetPasswords.php">
        <input type="hidden" name="type" value="reset"/>
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" name="pwd" placeholder="Entrez le nouveau mot de passe...">
        <input type="password" name="pwd-repeat" placeholder="Répétez le nouveau mot de passe...">
        <button type="submit" name="submit">Recevoir un email</button>
    </form>

    <?php
        include_once 'footer.php';
    ?>

<?php
    }else {
        echo "Nous ne pouvons pas valider votre demande de réinitialisation de mot de passe.";
    }
}
?> 