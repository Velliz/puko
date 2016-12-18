<?php

define('ROOT', __DIR__);
define('BASE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/puko/');

require __DIR__.'/vendor/autoload.php';

$framework = new \pukoframework\Framework();
$framework->RouteMapping([
    'example' => 'main/example',
]);
$framework->Start();
