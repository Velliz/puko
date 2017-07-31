<?php
define('APPLICATION_ENV', 'development');

if (preg_match('/\.(?:png|jpg|jpeg|gif|ico)$/', $_SERVER['REQUEST_URI']) || file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    return false;
} else {
    $_GET['request'] = substr($_SERVER['REQUEST_URI'], 1);
    $_GET['lang'] = 'id';
    include_once 'index.php';
}