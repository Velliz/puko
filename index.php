<?php
/*
 *---------------------------------------------------------------
 * PUKO FRAMEWORK
 *---------------------------------------------------------------
 *
 */

use pukoframework\Framework;

require __DIR__ . '/vendor/autoload.php';

define('ROOT', __DIR__);

/*
 *---------------------------------------------------------------
 * APP BASE_URL
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/puko/');

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