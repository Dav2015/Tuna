<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("../database/mysqlDatabase.php");

$q = strval($_GET['q']);

$events = getEventWithPCat($q);
    
echo json_encode($events, JSON_UNESCAPED_UNICODE);

?>

