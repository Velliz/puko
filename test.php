<?php
define('FILE', dirname(__FILE__));
define('CONTROLLERS', '/Puko/Controllers/');

define('ROOT', 'http://localhost/puko/');

include('Puko/Core/Puko.php');
include('Puko/Core/RouteParser.php');
include('Puko/Core/Template.php');

use Puko\Core\Puko;

Puko::Init()->Start();