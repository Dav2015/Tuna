<?php

session_start();

require_once( "../lib/lib.php" );
require_once '../database/mysqlDatabase.php';
require_once '../database/manipulate_SGF.php';
require_once( "../lib/lib-mail-v2.php" );

include '../lib/isPostMethod.php';

$isOK = TRUE;

if (isset($_SESSION["userName"])) {
    $userName = $_SESSION["userName"];
} else {
    $isOK = FALSE;
}

if (isset($_POST["nameEvent"])) {
    $nameEvent = $_POST["nameEvent"];
} else {
    echo "O nome do Evento está vazio";
    $isOK = FALSE;
}

if (isset($_POST["descEvent"])) {
    $descEvent = $_POST["descEvent"];
} else {
    echo "A descrição do Evento está vazia";
    $isOK = FALSE;
}

if (isset($_POST["catPEvent"])) {
    $catPEvent = $_POST["catPEvent"];
} else {
    echo "A categoria do Evento está vazia";
    $isOK = FALSE;
}

if (isset($_POST["localEvent"])) {
    $localEvent = $_POST["localEvent"];
} else {
    echo "O local do evento está vazio";
    $isOK = FALSE;
}

if (isset($_POST["dateEvent"])) {
    $dateEvent = $_POST["dateEvent"];
    $year = substr($dateEvent, 0, 4);
} else {
    echo "A data do Evento está vazia";
    $isOK = FALSE;
}

$visEvent = isset($_POST["visEvent"]) ? 1 : 0;

require './header_login.php';
?>
<head>
    <title>
        TFISEL - Evento
    </title>
</head>
<div class="container">
    &emsp;
    <div class="row">
        <div class="col-md-12">
            <h4><strong>
         
<?php if ($isOK) { 
    try {
        if (addMultimediaFile($year, $catPEvent, $nameEvent, $userName, NULL, $descEvent, $visEvent, FALSE)) {
            list($fileMultimediaType, $notUse) = explode("/", $_FILES['input-b3']['type'][0]);
            if($_FILES['input-b3']['type'][0] == 'image/jpeg' || $_FILES['input-b3']['type'][0] == 'image/png') {
            $path = "../SGF/" . $year . "/" .
                    $catPEvent . "/" . $nameEvent . "/" . $userName
                    . "/" . $fileMultimediaType . "/" . $_FILES['input-b3']['name'][0];
            if (createNewEvent($nameEvent, $path, $descEvent, $dateEvent, $catPEvent, $visEvent, $localEvent)) { ?>
                O evento <?php echo $nameEvent?> foi criado com sucesso
            <?php } else { ?>
               Falha na criação do Evento <?php echo $nameEvent?>;
           <?php }
        } else { ?>
             O cartaz do evento só pode ser uma imagem
        <?php }} else { ?>
           Falha no Upload do ficheiro
        <?php } 
    } catch (Exception $ex) { 
        echo $ex->getMessage();
    }
} else {?>
    Dados em falta;
<?php } ?>
            </strong> </h4>
        </div>
    </div>
</div>