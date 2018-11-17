<div class="row">
&ensp;
    <div class="form-group col-md-12">
        <form action="" method="post">
            <h6>Remover</h6>
            <div class="input-group col-md-6">
                <select class="form-control" id="eventToRemove" name="eventToRemove" required>
                    <?php
                       $allEventNames = getAllEventNames();
                       foreach ($allEventNames as $event):
                    ?>
                        <option> <?php echo $event ?> </option>
                    <?php     
                       endforeach;
                    ?>
                </select>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalRem">OK</button>
            </div>
            <div class="modal fade" id="modalRem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Remover Evento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Tem a certeza de que quer remover o evento e todos os seus conteúdos associados?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" name="confirmRemove">Remover</button>
                        </div>
                    </div>
                </div>
            </div>  
        </form>
        <?php
            if (isset($_POST["confirmRemove"]) && isset($_POST["eventToRemove"])) {
                $eventRemove = $_POST["eventToRemove"];
                removeEvent($eventRemove);
            } 
        ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
    <form action="" method="post">
        <h6>Editar</h6>
        <div class="input-group col-md-12">
            <select class="form-control" id="eventToEdit"  name="eventToEdit" required>
                <?php
                   $allEventNames = getAllEventNames();
                   foreach ($allEventNames as $event):
                ?>
                    <option> <?php echo $event ?> </option>
                <?php     
                   endforeach;
                ?>
            </select>
            <input class="form-control" data-date-format="yyyy-mm-dd" id="datepicker" name="dateToEdit">
            <input type="text" class="form-control" name="localToEdit" placeholder="Local">
            <select class="form-control" id="catToEdit"  name="catToEdit">
                <option value="">Categorias</option>
                <?php
                   $pCategories = getAllCategories();
                   foreach ($pCategories as $cat):
                ?>
                    <option> <?php echo $cat ?> </option>
                <?php     
                   endforeach;
                ?>
            </select>
            <select class="form-control" id="visToEdit"  name="visToEdit">
                <option value="">Visibilidade</option>
                <option value="0"> Público </option>
                <option value="1"> Privado </option>
            </select>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit">OK</button>
        </div>
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Editar Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem a certeza de que quer editar o evento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="confirmEdit">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
        if (isset($_POST["confirmEdit"]) && isset($_POST["eventToEdit"])) {
            $eventEdit = $_POST["eventToEdit"];
            $dateEdit = $_POST["dateToEdit"];
            $pCatEdit = $_POST["catToEdit"];
            $visEdit = $_POST["visToEdit"];
            $localEdit = $_POST["localToEdit"];
            
            $eventFromName = getEventFromName($eventEdit);
            
            if ($pCatEdit === "") {
                $pCatEdit = $eventFromName['P_Category'];
            }
            if ($visEdit === "") {
                $visEdit = $eventFromName['Visibility'];
            }
            if ($localEdit === "") {
                $localEdit = $eventFromName['Local'];
            }
            
            editEvent($eventEdit, $dateEdit, $pCatEdit, $visEdit, $localEdit);
        } 
    ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker').datepicker("setDate", new Date());
    </script>
    </div>
</div>

&emsp;
<div class="row">
    <?php
    #require_once("../lib/lib.php");
    #require_once ("../../acess_dataBases/msqlDatabase/mysqlDatabase.php");

    $visibility = 1;
    $events = getAllEvents($visibility);
    ?>

    <div class="col-md-12" id="tabela">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Evento</th>
                    <th scope="col">Data</th>
                    <th scope="col">Local</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Visibilidade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $e): ?>
                <tr>
                    <td>
                        <?php echo $e['Name'] ?>
                    </td>
                    <td>
                        <?php echo $e['Date'] ?>
                    </td>
                    <td>
                        <?php echo $e['Local'] ?>
                    </td>
                    <td>
                        <?php echo $e['P_Category'] ?>
                    </td>
                    <td>
                        <?php echo $e['Description'] ?>
                    </td>
                    <td>
                        <?php
                        if ($e['Visibility'] === "1" ){
                            echo "Privado";
                        } else {
                            echo "Público";
                        }
                        ?>
                    </td>
                <tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>