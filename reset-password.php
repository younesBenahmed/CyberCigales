<?php 
    include_once 'header.php';
    include_once 'helpers/session_helper.php';
    flash('reset');
    flash('newpwd');
    flash('newReset');
?>
    <h1 class="header">Reset Password</h1>

    <form method="post" action="./controllers/ResetPasswords.php">
        <input type="hidden" name="type" value="send">
        <input type="text" name="usersEmail" placeholder="Email...">
        <button type="submit" name="submit">Recevoir un email</button>
    </form>

<?php
    include_once 'footer.php';
?>