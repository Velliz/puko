<?php
define('ROOT', __DIR__);
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);

require __DIR__ . '/vendor/autoload.php';

$framework = new \pukoframework\Framework();
$framework->RouteMapping(array(
    'example' => 'main/example',
));
$framework->Start();