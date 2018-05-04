<?php
/*
 *---------------------------------------------------------------
 * PUKO FRAMEWORK
 *---------------------------------------------------------------
 *
 */

use pukoframework\Framework;

require __DIR__ . '/vendor/autoload.php';

$protocol = 'http';
if (isset($_SERVER['HTTPS'])) {
    $protocol = 'https';
} else if (isset($_SERVER['HTTP_X_SCHEME'])) {
    $protocol = strtolower($_SERVER['HTTP_X_SCHEME']);
} else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $protocol = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
} else if (isset($_SERVER['SERVER_PORT'])) {
    $serverPort = (int)$_SERVER['SERVER_PORT'];
    if ($serverPort == 80) {
        $protocol = 'http';
    } else if ($serverPort == 443) {
        $protocol = 'https';
    }
}

define('BASE_URL', ($protocol . "://" . $_SERVER['HTTP_HOST'] . "/"));

/*
 *---------------------------------------------------------------
 * APP ROOT
 *---------------------------------------------------------------
 *
 */
define('ROOT', __DIR__);
/*
 *---------------------------------------------------------------
 * APP START
 *---------------------------------------------------------------
 *
 * This variable used to calculate the framework performance.
 */
define('START', microtime(true));

//Initialize framework object
$framework = new Framework();
//Start framework
$framework->Start();