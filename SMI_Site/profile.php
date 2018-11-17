<?php

session_start();

require_once '../database/mysqlDatabase.php';

$role = getRole($_SESSION['userName']);

if($role === 'Administrador') {
    header("Location: profile_admin.php");
} else {
    header("Location: profile_others.php");
}