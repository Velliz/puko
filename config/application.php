<?php

/*
 *---------------------------------------------------------------
 * APP ROOT
 *---------------------------------------------------------------
 *
 */
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