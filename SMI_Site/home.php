<?php
session_start();
require_once '../database/mysqlDatabase.php';
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

$categories = getAllCategories();
$count = countEvents($visibility);

$nCountPP = 5;
$nCols = ceil($count / $nCountPP);

if (isset($_GET['page'])) {
    $offset = $_GET['page'] - 1;
    $initLimit = $offset * $nCountPP;
    $endLimit = $offset * $nCountPP + $nCountPP;
    $events = getEvents($visibility, $initLimit, $endLimit);
} else {
    $initLimit = 0;
    $endLimit = 5;
    $events = getEvents($visibility, $initLimit, $endLimit);
}
?>

<html>
    <head>
        <title>TFISEL</title>
    </head>
    <body>
        <div class="container">
            &emsp;
            <div class="row">
                <div class="col-md-8" id="blog">
                    <?php foreach ($events as $e) : ?>
                        <div class="card mb-4">
                            <img class="card-img-top card" src="<?php echo getFile($e['Path']) ?>" alt="Card image cap"><div class="card-body">
                                <h2 class="card-title" id="tituloEvento"><?php echo $e['Name'] ?></h2>
                                <p class="card-text" id="Descricao"><?php echo $e['Description'] ?></p>
                                <a href="#" class="btn btn-primary" onclick="window.location = './event_gallery.php?event=<?php echo $e['Name'] ?>'">Ver Mais</a>
                            </div>
                            <div class="card-footer text-muted">
                                <a></a><a><?php echo $e['Local'] ?></a><a> | </a><a><?php echo $e['Date'] ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">

                    <?php if ($visibility == 1) : ?>
                        <div class="card my-4" id="btnCreateEvent" >
                            <a href="#" class="btn btn-primary" onclick="window.location = './event_create.php'">Criar Evento</a>
                        </div>
                        <div class="card my-4" id="btnUpload" >
                            <a href="#" class="btn btn-primary" onclick="window.location = './upload_create.php'">Upload de Ficheiros</a>
                        </div>
                    <?php endif; ?>
                    <div class="card my-4">
                        <h5 class="card-header">Procura</h5>
                        <div class="card-body">
                            <form method="post" action="./search.php">
                                <div class="input-group"> 
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Procurar por..." required>
                                    <button type="submit" class="btn btn-secondary">Ir!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card my-4">
                        <h5 class="card-header">Categorias</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="list-unstyled mb-0" id ="categorias">
                                        <?php foreach ($categories as $c): ?>
                                            <li >
                                                <a href="#" id="id_cat" onclick="window.location = './event_category.php?category=<?php echo $c ?>'"><?php echo $c ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                &ensp;&ensp;
                <form method='get'>
                    <ul class="pagination justify-content-center mb-4">
                        <?php for ($i = 1; $i <= $nCols; $i++) : ?>
                            <li class="page-item">
                                <input type="submit" class="page-link" name="page" value="<?php echo $i ?>"/>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </form>
            </div>
        </div>
    </body>
</html>

<?php include './footer.php'; ?>
