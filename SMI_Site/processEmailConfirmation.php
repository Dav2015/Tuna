<?php

require_once '../database/mysqlDatabase.php';
require_once("encrypt_decrypt.php");
require_once './header_login.php';

$isOK = TRUE;

if (isset($_GET["cod"])) {
    $userName = encrypt_decrypt($_GET["cod"], 'd');
} else {
    echo "Username está vazio";
    $isOK = FALSE;
}

if ($isOK) {
    echo '<div class="container">';
    echo '&emsp;';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    if (approveUser($userName)) {
        echo "<h4><strong>Seu registo foi validado com sucesso</strong></h4>";
    } else {
        echo "<h4><strong>Ocorreu um erro, é possivel que a sua conta já esteja validada</strong></h4>";
    }
    echo ' </div> </div> </div>';
    require_once './footer.php';
}

exit();