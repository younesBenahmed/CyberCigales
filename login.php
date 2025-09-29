<?php
include_once header.php ?>

    <h1 class=header">Veuillez vous connecter</h1>

    <form method=post action="./controllers/Users.php">
        <input type="hidden" name="type" value="login">

        <input type="text" name="name/email" 
               placeholder="Pseudo/Email...">

        <input type="password" name="password" 
               placeholder="Mot de passe...">

        <button type="submit" name="submit">Se connecter</button>
    </form>

    <div class="form-sub-msg"><a href="./reset_password.php">Mot de passe oublié ?</a></div>

    <?php
    include_once "footer.php";
    ?>