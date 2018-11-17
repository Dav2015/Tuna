<?php
require_once '../database/azureManipulate_SGF.php';
require '../lib/lib.php';
logout();
header("Location: http://$linkRoot/login.php");
exit();