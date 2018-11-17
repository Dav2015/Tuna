<?php
session_start();
require_once("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");
require_once ('../database/azureManipulate_SGF.php');

include './header_login.php';

$roleUser = "";
if (isset($_SESSION['userName'])) {
    $roleUser = getRole($_SESSION['userName']);
    if ($roleUser == "Utilizador") {
        $visibility = 0;
    } else {
        $visibility = 1;
    }
} else {
    $visibility = 0;
}
?>

<html>
    <head>
        <title>TFISEL - Galeria</title>

        <style>
            .mfp-title {
                position:absolute;
                color: #FFF;
            }
        </style>

    </head>
    <body>
        <div class="container">
                        &emsp;

            <?php
            if (isset($_POST['search'])) :
                $pesquisa = $_POST['search'];
                $gallery = getResults($pesquisa, $visibility);
                if (sizeof($gallery) > 0) :
                    ?>         
                    <h4><strong>Resultados: <?php echo $pesquisa?></strong></h4>
                    &emsp;
                    <div class="popup-gallery">
                        <div class="row text-center text-lg-left" id="galeria">
                            <?php
                            foreach ($gallery as $g) :
                                $format = $g['Format'];
                                $description = "<b>" . $g['Username'] . "</b>" . ": " . $g['Description'];
                                $poster = "../SGF/videoplay.png";
                                ?>
                                <div class="col-lg-3 col-md-4 col-xs-6">

                                    <?php if ($format == 'image') : ?>
                                        <a href="<?php echo getFile($g['Path']) ?>" class="image" alt="<?php echo $description ?> ">
                                            <img src="<?php echo getFile($g['Path']) ?>" class="img-fluid img-thumbnail" />
                                        </a>

                                    <?php endif; ?>
                                    <?php if ($format == 'video') : ?>
                                        <a href="<?php echo getFile($g['Path']) ?>" class="video" alt="<?php echo $description ?>">
                                            <video src="<?php echo getFile($g['Path']) ?>" poster="./resources/video.png" class="img-fluid img-thumbnail"/>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($format == 'audio') : ?>                        
                                        <a href="<?php echo getFile($g['Path']) ?>" class="video" alt="<?php echo $description ?>">
                                            <video src="<?php echo getFile($g['Path']) ?>" poster="./resources/audio.png" class="img-fluid img-thumbnail"/>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                              <h4><strong>Não há resultados</strong></h4>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            &emsp;
        </div>
    </div>
    <script>
        $('.video').magnificPopup({
            type: 'iframe',

            iframe: {
                markup: '<div class="mfp-iframe-scaler">' +
                        '<div class="mfp-close"></div>' +
                        '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                        '<div class="mfp-title">Some caption</div>' +
                        '</div>'
            },
            callbacks: {
                markupParse: function (template, values, item) {
                    values.title = item.el.attr('alt');
                }
            }


        });
    </script>

    <script>
        $('.image').magnificPopup({
            type: 'image',
            callbacks: {
                markupParse: function (template, values, item) {
                    values.title = item.el.attr('alt');
                }
            }
        });
    </script>
</body>
</html>


<?php require_once './footer.php' ?>