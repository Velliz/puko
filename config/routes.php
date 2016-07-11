<?php

/*
| -------------------------------------------------------------------
| APPLICATION ROOT PATH
| -------------------------------------------------------------------
|
*/
define('ROOT', 'http://localhost/puko/');
define('CONTROLLERS', '/Controllers/');

/*
| -------------------------------------------------------------------
| APPLICATION VIEW
| -------------------------------------------------------------------
|
*/
define('ASSETS', 'assets/html/');
define('MASTER', 'assets/html/templates/');
define('EXTENSIONS', 'assets/extensions/');

/*
| -------------------------------------------------------------------
| APPLICATION HTTP ERROR PAGES
| -------------------------------------------------------------------
|
*/
define('PAGE_404', 'assets/html/templates/confused.html');
define('PAGE_401', 'assets/html/templates/unauthorized.html');

/*
| -------------------------------------------------------------------
| APPLICATION ERROR
| -------------------------------------------------------------------
|
*/
define('PAGE_ERROR', 'assets/html/templates/error.html');
define('PAGE_EXCEPTION', 'assets/html/templates/exception.html');

/*
| -------------------------------------------------------------------
| APPLICATION ENVIRONMENT
| -------------------------------------------------------------------
|
*/
define('PRODUCTION', 'live');
define('DEVELOPMENT', 'dev');