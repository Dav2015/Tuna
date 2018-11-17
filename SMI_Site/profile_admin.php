<?php
session_start();
require_once("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");
require_once ("manager.php");

include './header_login.php';

if (isset($_SESSION["userName"])) {
    $userName = $_SESSION["userName"];
    $realName = getName($userName);
    $role = getRole($userName);
    $nickname = getFromUser($userName, 'Nickname');
    $hierarchy = getFromUser($userName, 'Hierarchy');
}
?>
<html>
    <head>
        <title>TFISEL - Perfil</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    </head>
    <body>
        <div class="container">
            &emsp;
            <div class="row">
                <div class="col-md-1"></div>
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
                            <tr>
                                <th>Alcunha</th>
                                <td id="roleProfile"><?php echo $nickname ?></td>
                            </tr>
                            <tr>
                                <th>Hierarquia</th>
                                <td id="roleProfile"><?php echo $hierarchy ?></td>
                            </tr>
                        </tbody>
                      </table>
                </div>
                <div class="col-md-4">
                    <form method='get'>
                        <div class="card my-4" id="btnManageUsers" >
                            <input type="submit" class="btn btn-primary" name="mUsers" value="Gerir Utilizadores" />
                        </div>
                        
                        <div class="card my-4">
                            <input type="submit" class="btn btn-primary" name="mEvents" value="Gerir Eventos" />
                        </div>

                        <div class="card my-4" id="btnManageCats" >
                            <input type="submit" class="btn btn-primary" name="mCats" value="Gerir Categorias" />
                        </div>

                    </form>
                </div>
                <div class="col-md-1"></div>
            </div>     
                <?php
                    if(isset($_GET["mEvents"])) {
                        include ('./manage_events.php');
                    } elseif (isset($_GET["mCats"])) {
                        include ('./manage_categories.php');
                    } elseif (isset($_GET["mUsers"])) {
                        include ('./manage_users.php');
                    }
                ?>
    </body>
</html>


