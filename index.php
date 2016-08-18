<?php
define('ROOT', __DIR__);
define('BASE_URL', "http://" . $_SERVER['SERVER_NAME'] . "/microcapital-client/");
require __DIR__ . '/vendor/autoload.php';
$framework = new \pukoframework\Framework();
$framework->RouteMapping(array(
    'register' => 'main/register',
    'login' => 'main/client_login',
    'logout' => 'main/client_logout',
    'about' => 'main/about',
    'faq' => 'main/faq',
    'success' => 'main/success',
));
$framework->Start();