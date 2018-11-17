<?php

session_start();

require_once( "../database/mysqlDatabase.php" );
require_once '../database/azureManipulate_SGF.php';

include '../lib/isPostMethod.php';

$userName = $_POST["login_userName"];
$password = $_POST["login_password"];

if (ctype_alnum($userName) && ctype_alnum($password)) {
    //ver se existe o utilizador na base de dados
    $isUserOK = isValid($userName, $password);
    if ($isUserOK) {
        //papel do utilizador
        $userRole = getRole($userName);
        //criar sessao de login
        //esta informação ira em cookie  de session
        $_SESSION['role'] = $userRole;
        $_SESSION['userName'] = $userName;
        $_SERVER['PHP_AUTH_USER'] = $userName;
        $_SERVER['PHP_AUTH_PW'] = $password;
        header("Location: http://$linkRoot/home.php"); /* Redirect browser */
    } else {
        header("Location: http://$linkRoot/login.php");
        echo "NAO DEU";
    }
} else {
    header("Location: http://$linkRoot/login.php");
    echo 'erro';
}

exit();

