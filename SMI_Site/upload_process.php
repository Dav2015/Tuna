<?php
//header('Content-Type: text/html; charset=UTF-8', true);

session_start();

require "../database/mysqlDatabase.php";
require "../database/manipulate_SGF.php";
require_once "./header_login.php";

$isOK = TRUE;

if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    $isOK = FALSE;
}

if (isset($_POST['event'])) {
    $event = $_POST['event'];
} else {
    $isOK = FALSE;
}


if (isset($_POST['pCategory'])) {
    $pCategory = $_POST['pCategory'];
} else {
    $isOK = FALSE;
}

if (isset($_POST['desc'])) {
    $desc = $_POST['desc'];
} else {
    $isOK = FALSE;
}

$sCategory = NULL;
if (isset($_POST['sCategory'])) {
    $sCategory = $_POST['sCategory'];
} else {
    $isOK = FALSE;
}

$vis = isset($_POST["vis"]) ? 1 : 0;

?>
<html>
    <head>
        <title>
            TFISEL - Upload
        </title>
    </head>
    <body>
        <div class="container">
            &emsp;
            <div class="row">
                <div class="col-md-12">
                    <h4 id="uploadResult"> <strong>
                            <?php if ($isOK) {
                            $year = getEventYear($pCategory, $event); 
                            try {
                            addMultimediaFile($year, $pCategory, $event, $userName, $sCategory, $desc, $vis, TRUE); ?>
                            Upload de conteúdos realizado com sucesso
                            <?php } catch (Exception $ex) { 
                            echo $ex->getMessage();
                            }
                            } else { ?>
                            Dados em falta
                            <?php } ?>
                        </strong></h4>
                </div>
            </div>
        </div>
    </body>
</html>