<?php

use Dotenv\Dotenv;
use pukoframework\config\Factory;
use pukoframework\Framework;

require 'vendor/autoload.php';

//spin up environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$protocol = 'http';
if (isset($_SERVER['HTTPS'])) {
    $protocol = 'https';
} elseif (isset($_SERVER['HTTP_X_SCHEME'])) {
    $protocol = strtolower($_SERVER['HTTP_X_SCHEME']);
} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $protocol = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
} elseif (isset($_SERVER['SERVER_PORT'])) {
    $serverPort = (int) $_SERVER['SERVER_PORT'];
    if ($serverPort == 80) {
        $protocol = 'http';
    } elseif ($serverPort == 443) {
        $protocol = 'https';
    }
}

$factory = [
    'cli_param'   => null,
    'environment' => 'DEV', //possible value: PROD, DEV, MAINTENANCE
    'base'        => ($protocol.'://'.$_SERVER['HTTP_HOST'].'/'),
    'root'        => __DIR__,
    'start'       => microtime(true),
];
$fo = new Factory($factory);

$framework = new Framework($fo);
$framework->Start();
