<?php
session_start();
require_once("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");

include './header_login.php';

if (isset($_SESSION["userName"])) {
    $userName = $_SESSION["userName"];
    $realName = getName($userName);
    $role = getRole($userName);

    if ($role === 'Simpatizante' || $role === 'Administrador') {
        $nickname = getFromUser($userName, 'Nickname');
        $hierarchy = getFromUser($userName, 'Hierarchy');
    }
}
?>
<html>
    <head>
        <title>TFISEL - Perfil</title>
    </head>
    <body>
        <div class="container">
                    &emsp;
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <table class="table">
                        <tbody id="table">
                            <tr>
                                <th>Nome</th>
                                <td id="nameProfile"><?php echo $realName ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td id="userProfile"><?php echo $userName ?></td>
                            </tr>
                            <tr>
                                <th>Tipo de Perfil</th>
                                <td id="roleProfile"><?php echo $role ?></td>
                            </tr>
                            <?php
                            if ($role === 'Simpatizante'):
                            ?>
                            <tr>
                                <th>Alcunha</th>
                                <td id="roleProfile"><?php echo $nickname ?></td>
                            </tr>
                            <tr>
                                <th>Hierarquia</th>
                                <td id="roleProfile"><?php echo $hierarchy ?></td>
                            </tr>
                            <?php
                                endif;
                            ?>
                        </tbody>
                      </table>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>