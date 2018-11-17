<?php
session_start();

require_once( "../lib/lib.php" );
require_once '../database/mysqlDatabase.php';
require_once( "../lib/lib-mail-v2.php" );
require_once("encrypt_decrypt.php");
include '../lib/isPostMethod.php';

$isOK = TRUE;

if (isset($_POST["registed_userName"])) {
    $userName = $_POST["registed_userName"];
} else {
    echo "Username está vazio";
    $isOK = FALSE;
}

if (isset($_POST["real_name"])) {
    $realName = $_POST["real_name"];
} else {
    echo "Sem nome de utilizador";
    $isOK = FALSE;
}

if (isset($_POST["registed_password1"]) && isset($_POST["registed_password2"]) && $_POST["registed_password1"] === $_POST["registed_password2"]) {
    $password = $_POST["registed_password1"];
} else {
    $isOK = FALSE;
}

if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isOK = FALSE;
    }
} else {
    $isOK = FALSE;
}



if (isset($_POST['g-recaptcha-response'])) {
    $secret = "6LcS_2AUAAAAAEjM0UIkASevwMHtFV03oSWWQvQo";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $result = file_get_contents("https://www.google.com/recaptcha/"
            . "api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
    $arr = json_decode($result, true);
    //var_dump($arr);
    //ver se no array associativo existe sucess => TRUE  se for false nao continuar
    if (!$arr['success']) {
        $isOK = FALSE;
    }
}

//simpatizante
$hierarchy = NULL;
$nickname = NULL;
$role = NULL;

if (isset($_POST['Simpatizante']) && isset($_POST['hierarchy'])) {
    $hierarchy = $_POST['hierarchy'];

    //opcional
    $nickname = $_POST['nickname'];
    $nickname = !empty($nickname) ? $nickname : NULL;
}

function sendMail($email, $userName) {
    #header('Content-type: text/html; charset=utf-8');

    $newLine = "\r\n";
    $_senderEmail = "gruposmi1718@gmail.com";

    $from = "TFISEL <" . $_senderEmail . ">";
    $replyTo = $from;

    $hash = encrypt_decrypt($userName, 'e');

    $subject = "TFISEL | Registo bem sucedido";
    $message = "Foi registado com sucesso no website da TFISEL. "
            . "Clique neste link para validar o seu registo: "
            . "http://$_SERVER[HTTP_HOST]/projetoFinal/SMI_Site/"
            . "processEmailConfirmation.php?cod=$hash";

    $headers = "MIME-Version: 1.0" . $newLine;
    $headers .= "Content-Type: text/plain; charset=UTF-8" . $newLine;

    $headers .= encodeHeaderEmail(
            "From", "TFISEL", $_senderEmail);
    $headers .= encodeHeaderEmail(
            "Reply-To", "TFISEL", $_senderEmail);

    $result = mail($email, $subject, $message, $headers);
}
?>
<?php
require './header_login.php';
if ($isOK) :
        ?>
        <head>
            <title>
                TFISEL - Registo
            </title>
        </head>
        <body>
            <div class="container">
                &emsp;
                <div class="row">
                    <div class="col-md-12">
                        <h4> <strong>
                            <?php if (insertNewUser($userName, $realName, $password, $email, $role, $nickname, $hierarchy)) : ?>
                                <?php echo $realName ?>, confirme o registo no seu email.
                                <?php sendMail($email, $userName); ?>
                            <?php else: ?>
                                Falha no registo  
                            <?php endif; ?>
                        </strong> </h4>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
endif;
?>


