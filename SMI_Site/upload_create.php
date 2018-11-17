<?php

session_start();
require_once ("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");
require_once ("./header_login.php");

$pCats = getPrimaryCat();

?>

<html>
    <head>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.min.css"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/piexif.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/themes/fa/theme.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/(lang).js"></script>
        <script>
            function getEvents(str) {
                if (str == "") {
                    document.getElementById("selectEvents").innerHTML = "";
                    return;
                } else {
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }

                    xmlhttp.onreadystatechange = function () {
                        let events = "";
                        if (this.readyState === 4 && this.status === 200) {
                            events = JSON.parse(this.responseText);
                            
                            let childEvents = document.getElementById("selectEvents");
                            while (childEvents.firstChild) {
                                childEvents.removeChild(childEvents.firstChild);
                            }
                            
                            for (e in events) {
                                let option = document.createElement("option");
                                option.textContent = events[e].toString();
                                document.getElementById("selectEvents").appendChild(option);
                            }
                        }
                    }
                    xmlhttp.open("GET", "./get_events_upload.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
        </script>
        <meta charset="windows-1252">
    <title>
        TFISEL - Upload
    </title>
    </head>
    
    <body>
        <form action="upload_process.php" method="post" enctype="multipart/form-data">
            <div class="container">
                &emsp;
                <div class="row">
                    <div class="col-md-7">
                        <div class="file-loading"> 
                            <input id="input-b3" name="input-b3[]" type="file" class="file" multiple data-show-caption="true" data-msg-placeholder="Selecione ficheiros para upload..." >
                        </div>
                        &emsp;
                    </div>
                    
                    <div class="col-md-5">
                        <h5>Categoria Principal</h5>
                        <div class="form-group">
                            <select class="form-control" id="selectPrimaryCat"  name="pCategory" onchange="getEvents(this.value)" required>
                                <option value="" disabled selected>Escolher...</option>
                                <?php foreach ($pCats as $p): ?>
                                <option value="<?php echo $p ?>"><?php echo $p ?></option>         
                              <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <h5>Evento</h5>
                        <div class="form-group">
                            <select class="form-control" id="selectEvents" name="event" required>
                                <option value="" disabled selected>Escolher...</option>
                            </select>
                        </div>
                        
                        <h5>Descrição</h5>
                        <div class="form-group">
                            <textarea class="form-control" name="desc" id="textDesc" rows="2" placeholder="Descrição"></textarea>
                        </div>
                        
                        <h5>Categorias Secundárias</h5>
                        <div class="form-group">
                            <textarea class="form-control" name="sCategory" id="textSecondary" rows="2" placeholder="Separar categorias por ; (Exemplo: lisboa;tuna; ...)"></textarea>
                        </div>
                        
                        <div class="form-group">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="form-check-input" type="checkbox" value="1" id="visibilityCheckbox" name="vis">
                        <label class="form-check-label" for="visibilityCheckbox">
                            Privado
                        </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>	
    </body>
</html>

<?php require_once './footer.php' ?>