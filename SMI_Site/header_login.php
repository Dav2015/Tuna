<?php

error_reporting(0);
ini_set('display_errors', 0);
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

require_once '../database/mysqlDatabase.php';
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v3.0';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <style>
            option {
                -moz-appearance: none !important;
                -webkit-appearance: none !important;
                appearance:none !important;
            }

            option:hover {
                background-color: #D74E26 !important;
                color: white;
            }

            .form-control:focus {
                border-color: #adb5bd !important;
                box-shadow: inset 0 1px 1px #adb5bd, 0 0 14px #adb5bd !important;
            }

            #id_cat, #id_cat:hover, #id_cat:active, #id_cat:visited {
                color: #D74E26 !important;
            }

            .navbar {
                background-color: #495057 !important;
                border-color: #495057 !important;
            }

            .btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {
                background-color: #D74E26 !important;
                border-color: #D74E26 !important;

            }

            .btn-primary:focus{
                border-color: #D74E26 !important;
                box-shadow: inset 0 1px 1px #D74E26, 0 0 14px #D74E26 !important;
            } 

            .lg-view{
                display:inline-block;
            }

            .sm-view{
                display:none;
            }

            @media screen and (max-width: 500px) {
                .lg-view{
                    display:none;
                }

                .sm-view{
                    display:inline-block;
                }
            }

            body { padding-top: 54px; }

            @media (min-width: 992px) {
                body { padding-top: 54px; }
                html { overflow-y: scroll; }
            }

            .modal-footer {
                justify-content: flex-start;
            }

            .img-thumbnail {
                width: 200px;
                height: 200px;
                background-position: center center;
                background-repeat: no-repeat;
                margin-bottom: 70px;
            }

            img.mfp-img {
                height: 95%;
            }         
            
            .mfp-title {
                position:absolute;
                color: #FFF;
            }
            
             .file-drop-zone {
                height: auto !important;
            }
        </style>
    </head>

    <div class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#" onclick="window.location = './home.php'"> 
                <!--<img src="./resources/logo_tfisel.png" width="50">-->
                <span class="lg-view">Tuna Feminina</span>
                <span class="sm-view">Tuna</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="window.location = './about.php'">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="window.location = './contacts.php'">Contactos</a>
                    </li>    
                    <?php if (isset($_SESSION['userName'])): ?>
                        <li id="profile" class="nav-item">
                            <a id="profileText" class="nav-link" href="#" onclick="window.location = './profile.php'"><?php echo $_SESSION['userName'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="window.location = './logoutProcess.php'" id="userName">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="window.location = './login.php'" id="userName">Login | Registo</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    &emsp;
</html>
