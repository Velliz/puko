<?php
/**
 * This file is used only for php build in web-server.
 */

define('APPLICATION_ENV', 'development');

$preg = preg_match('/\.(?:png|jpg|jpeg|gif|ico|js*([?=a-zA-Z0-9_-]+)|css*([?=a-zA-Z0-9_-]+))$/', $_SERVER['REQUEST_URI']);
$exists = file_exists(__DIR__.'/'.$_SERVER['REQUEST_URI']);

if ($preg || $exists) {
    return false;
} else {
    $_GET['request'] = substr($_SERVER['REQUEST_URI'], 1);
    $_GET['lang'] = 'id';
    include_once 'index.php';
}
