<?php
/*
 *---------------------------------------------------------------
 * PUKO FRAMEWORK
 *---------------------------------------------------------------
 *
 */

use pukoframework\Framework;

require __DIR__ . '/vendor/autoload.php';
require 'config/application.php';

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