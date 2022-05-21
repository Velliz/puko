<?php
/**
 * This file is used only for php build in web-server.
 */
define('APPLICATION_ENV', 'development');

$preg = preg_match('/\.(?:png|jpg|jpeg|gif|ico|.eot*([?v=a-zA-Z0-9._-]+)|woff*([?v=a-zA-Z0-9._-]+)|svg|eot*([?v=a-zA-Z0-9._-]+)|woff2*([?v=a-zA-Z0-9._-]+)|ttf*([?v=a-zA-Z0-9._-]+)|mp4|mpeg|js*([?v=a-zA-Z0-9._-]+)|css*([?v=a-zA-Z0-9._-]+))$/', $_SERVER['REQUEST_URI']);
$exists = file_exists(__DIR__.'/'.$_SERVER['REQUEST_URI']);

if ($preg || $exists) {
    return false;
} else {
    $_GET['request'] = substr($_SERVER['REQUEST_URI'], 1);
    $_GET['lang'] = 'id';
    include_once 'index.php';
}
