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
define('ASSETS', 'Assets/html/');
define('MASTER', 'Assets/templates/');

/*
| -------------------------------------------------------------------
| APPLICATION HTTP ERROR PAGES
| -------------------------------------------------------------------
|
*/
define('PAGE_404', 'Assets/templates/not_found.html');
define('PAGE_401', 'Assets/templates/unauthorized.html');

/*
| -------------------------------------------------------------------
| APPLICATION ERROR
| -------------------------------------------------------------------
|
*/
define('PAGE_ERROR', 'Assets/templates/exception.html');
define('PAGE_EXCEPTION', 'Assets/templates/exception.html');

/*
| -------------------------------------------------------------------
| APPLICATION ENVIRONMENT
| -------------------------------------------------------------------
|
*/
define('PRODUCTION', 'live');
define('DEVELOPMENT', 'dev');