<div class="col-md-12">
&emsp;
<div class="row">
    <?php
    #require_once("../lib/lib.php");
    #require_once ("../database/mysqlDatabase.php");

    $cats = getPrimaryCat();
    ?>
    <div class="col-md-1"></div>
    <div class="col-md-6">
        <form action="" method="post">
            <h6>Remover</h6>
            <div class="input-group col-md-12">
                <select class="form-control" id="catToRemove" name="catToRemove" required>
                    <option value="">Categoria</option>
                    <?php
                       $allCats = getPrimaryCat();
                       foreach ($allCats as $cat):
                    ?>
                        <option> <?php echo $cat ?> </option>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Remover Categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Tem a certeza de que quer remover a categoria e todos os seus conteúdos associados?
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
            if (isset($_POST["confirmRemove"]) && isset($_POST["catToRemove"])) {
                $catRemove = $_POST["catToRemove"];
                removeCategory($catRemove);
            } 
        ?>
        &emsp;
        <form action="" method="post">
            <h6>Adicionar</h6>
            <div class="input-group col-md-12">
                <input type="text" class="form-control" name="catToAdd" placeholder="Nome da Categoria" required>
                <button type="submit" class="btn btn-secondary" name="confirmAdd">OK</button>
            </div>
        </form>
        <?php
            if (isset($_POST["confirmAdd"]) && isset($_POST["catToAdd"])) {
                $catAdd = $_POST["catToAdd"];
                addCategory($catAdd);
            } 
        ?>
    </div>

    <div class="col-md-4" id="tabela">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Categorias Primárias</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cats as $c): ?>
                <tr>
                    <td>
                        <?php echo $c ?>
                    </td>
                <tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>