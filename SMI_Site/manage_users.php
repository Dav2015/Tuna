&emsp;
<div class="row">
    
    <div class="form-group col-md-6">
        <form action="" method="post">
            <h6>Validar Simpatizante</h6>
            <div class="input-group col-md-12">
                <select class="form-control" id="userSimp" name="userSimp" required>
                    <?php
                       $allUsersSimp = getAllUsersSimp();
                       echo $allUsersSimp;
                       foreach ($allUsersSimp as $u):
                    ?>
                        <option> <?php echo $u ?> </option>
                    <?php     
                       endforeach;
                    ?>
                </select>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalVal">OK</button>
            </div>
            <div class="modal fade" id="modalVal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Validar Simpatizante</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Tem a certeza de que quer dar permissões de Simpatizante?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" name="confirmValidate">Validar</button>
                        </div>
                    </div>
                </div>
            </div>  
        </form>
        <?php
            if (isset($_POST["confirmValidate"]) && isset($_POST["userSimp"])) {
                $userSimp = $_POST["userSimp"];
                validateSimp($userSimp);
            } 
        ?>
    </div>
    
    <div class="form-group col-md-6">
        <form action="" method="post">
            <h6>Remover</h6>
            <div class="input-group col-md-12">
                <select class="form-control" id="userRem" name="userRem" required>
                    <?php
                    $allUsersNames = getAllUsersName();
                    foreach ($allUsersNames as $name):
                    ?>
                        <option> <?php echo $name ?> </option>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Remover Utilizador</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Tem a certeza de que quer remover o utilizador e todos os conteúdos associados?
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
            if (isset($_POST["confirmRemove"]) && isset($_POST["userRem"])) {
                $userRem = $_POST["userRem"];
                removeUser($userRem);
            } 
        ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
    <form action="" method="post">
        <h6>Editar</h6>
        <div class="input-group col-md-12">
            <select class="form-control" id="userToEdit"  name="nameToEdit" required>
                <?php
                   $allUsersNames = getAllUsersName();
                   foreach ($allUsersNames as $name):
                ?>
                    <option> <?php echo $name ?> </option>
                <?php     
                   endforeach;
                ?>
            </select>
            <input type="text" class="form-control" name="emailToEdit" placeholder="Email">
             <select class="form-control" id="roleToEdit"  name="roleToEdit">
                <option value="">Tipo de Utilizador</option>
                <option value="Utilizador"> Utilizador </option>
                <option value="Simpatizante"> Simpatizante </option>
                <option value="Administrador"> Administrador </option>
            </select>
            <input type="text" class="form-control" name="nicknameToEdit" placeholder="Alcunha">
            <select class="form-control" id="hierToEdit"  name="hierToEdit">
                <option value="">Hierarquia</option>
                <option value="Caloira"> Caloira </option>
                <option value="Veterana"> Veterana </option>
            </select>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit">OK</button>
        </div>
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Editar Utilizador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem a certeza de que quer editar o utilizador?
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
        if (isset($_POST["confirmEdit"]) && isset($_POST["nameToEdit"])) {
            
            $nameEdit = $_POST["nameToEdit"];
            $emailEdit = $_POST["emailToEdit"];
            $roleEdit = $_POST["roleToEdit"];
            $nicknameEdit = $_POST["nicknameToEdit"];
            $hierEdit = $_POST["hierToEdit"];
            
            $profileFromUsername = getProfileFromUsername($nameEdit);

            if ($emailEdit === "") {
                $emailEdit = $profileFromUsername['Email'];
            }
            if ($roleEdit === "") {
                $roleEdit = $profileFromUsername['Role'];
            }
            if ($nicknameEdit === "") {
                $nicknameEdit = $profileFromUsername['Nickname'];
            }
            if ($hierEdit === "") {
                $hierEdit = $profileFromUsername['Hierarchy'];
            }

            editUser($nameEdit, $emailEdit, $roleEdit, $nicknameEdit, $hierEdit);
        } 
    ?>
    </div>
</div>


&emsp;
<div class="row">
    <?php
    $users = getAllProfiles();
    ?>

    <div class="col-md-12" id="tabela">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Tipo de Perfil</th>
                    <th scope="col">Alcunha</th>
                    <th scope="col">Hierarquia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php echo $user['Username'] ?>
                    </td>
                    <td>
                        <?php echo $user['Name'] ?>
                    </td>
                    <td>
                        <?php echo $user['Email'] ?>
                    </td>
                    <td>
                        <?php echo $user['Role'] ?>
                    </td>
                    <td>
                        <?php echo $user['Nickname'] ?>
                    </td>
                    <td>
                        <?php echo $user['Hierarchy'] ?>
                    </td>
                <tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
