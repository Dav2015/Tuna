<?php

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $_INPUT_METHOD = INPUT_POST;
} else {
    echo "Invalid HTTP method (" . $method . ")";
    exit();
}