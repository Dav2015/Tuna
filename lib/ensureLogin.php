<?php
//garantir que o utilizador esta autenticado
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    $_SESSION['locationAfterAuth'] = $_SERVER['REQUEST_URI'];
    header("Location: formLogin.php");
    exit;
}

?>
