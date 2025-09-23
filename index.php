<?php
include "Autoloader.php";

use Controllers\User\Login;
use Controllers\User\LoginPost;

$controller = [new Login(), new LoginPost()];

//  AFFICHAGE DU SITE SELON URI
foreach ($controller as $key => $value) {
    if($value::support($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'])){
        $value->control();
        exit();
    }
}

echo "ERREUR 404 ";
    exit();
