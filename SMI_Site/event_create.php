<?php
session_start();
require_once("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");
require_once './header_login.php';

$pCats = getPrimaryCat();

?>
<html>
<head>
<title>
TFISEL - Criar Evento
</title>
<meta charset = "utf-8">

<link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.min.css"> 
<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/piexif.min.js" type = "text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/themes/fa/theme.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/(lang).js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

</head>
<body>
    <form method="post" action="event_process.php" enctype="multipart/form-data">
        <div class="container">
            &emsp;
            <div class="row">
                <div class="col-md-6">
                    <h5>Nome</h5>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name_event" placeholder="Nome do Evento" name="nameEvent" required>
                    </div>

                    <h5>Descrição</h5>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Descrição" name="descEvent"></textarea>
                    </div>

                    <h5>Categoria Principal</h5>
                    <div class="form-group">
                        <select class="form-control" id="selectPrimaryCat" name="catPEvent" required>
                            <option value="" disabled selected>Escolher...</option>
                              <?php foreach ($pCats as $p): ?>
                                <option value="<?php echo $p ?>"><?php echo $p ?></option>         
                              <?php endforeach; ?>
                        </select>
                    </div>

                    <h5>Local</h5>
                    <div class="form-group">
                        <input type="text" class="form-control" id="local_event" placeholder="Local" name="localEvent" required>
                    </div>

                    <h5>Data</h5>
                    <div class="form-group">
                        <input class="form-control" data-date-format="yyyy-mm-dd" id="datepicker" name="dateEvent" required>
                    </div>

                    <div class="form-group">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="form-check-input" type="checkbox" value="1" id="visibilityCheckbox" name="visEvent">
                        <label class="form-check-label" for="visibilityCheckbox">
                            Privado
                        </label>
                    </div>
                </div>
                <div class="col-md-6" >
                    <h5>Cartaz</h5>
                    <div class="form-group">
                        <div class="file-loading"> 
                            <input id="input-b3" name="input-b3[]" type="file" class="file" data-show-caption="false" data-msg-placeholder="Selecione ficheiros..." >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker').datepicker("setDate", new Date());
    </script>
</body>
</html>