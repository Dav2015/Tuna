<?php
session_start();
require_once("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");
require_once '../database/azureManipulate_SGF.php';

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

if (isset($_GET['event'])) {
    $nomeEvento = $_GET['event'];
}

$local = getLocal($nomeEvento);

$gallery = getAllPostsWithEvent($nomeEvento, $visibility);
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

            <h4 class="my-4 text-center text-lg-left" id="<?php echo $nomeEvento ?>"><?php echo $nomeEvento ?></h4>

            <div class="popup-gallery">
                
            <div class="row text-center text-lg-left" id="galeria">

                <?php
                foreach ($gallery as $g) :
                    $format = $g['Format'];
                    $description = "<b>" . $g['Username'] . "</b>";
                    if($g['Description'] != "") {
                        $description .= ": " . $g['Description'];
                    }
                    if($g['S_Category'] != ""){
                        $description .= "<br>" . "<b>" . "Categorias Secundárias" . "</b>" . ": " . $g['S_Category'];
                    }
                    ?>
                    <div class="col-lg-3 col-md-4 col-xs-6">

                     <?php if ($format == 'image') : ?>
                        <a href="<?php echo $g['Path'] ?>" class="image" alt="<?php echo $description ?> ">
                        <img src="<?php echo $g['Path'] ?>" class="img-fluid img-thumbnail" />
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

                <a id="local" name="<?php echo $local ?>"></a>

                <div class="col-md-12" id = "map" style="width:100%;height:300px;">
                    <script>
                        function initMap() {
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 12,
                            });

                            var geocoder = new google.maps.Geocoder();
                            var address = document.getElementById("local").name;

                            geocoder.geocode({'address': address}, function (results, status) {
                                if (status === 'OK') {
                                    map.setCenter(results[0].geometry.location);
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: results[0].geometry.location
                                    });
                                }
                            });
                        }


                    </script>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQGvbVPykNaJOAvLxdDfGokrwIQYcCi0k&amp;callback=initMap">
                    </script>

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

<?php include './footer.php'; ?>