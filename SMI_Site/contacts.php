<?php

session_start();
include './header_login.php';
?>

<head>
    <title>
        TFISEL - Contactos
    </title>
</head>
<div class="container">
    &emsp;

    <div class="row">

        <div class="col-md-7" id="map" style="width:100%;height:400px;">

            <script>
                function myMap() {
                    var mapCanvas = document.getElementById("map");
                    var mapOptions = {
                        center: new google.maps.LatLng(38.755564, -9.1178486), zoom: 18
                    };
                    var map = new google.maps.Map(mapCanvas, mapOptions);
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQGvbVPykNaJOAvLxdDfGokrwIQYcCi0k&callback=myMap"></script>
        </div>

        <div class="col-md-5">
            <h4><strong>Contacte-nos</strong></h4>
            &emsp;
            <div id="fb-root"></div>
            <div class="fb-page" data-href="https://www.facebook.com/gruposmi" data-tabs="messages" data-height="330" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/gruposmi" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/gruposmi">Grupo SMI</a></blockquote></div>
        </div>
    </div>
</div>

<?php include './footer.php';


exit();
?>