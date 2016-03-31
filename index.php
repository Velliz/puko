<?php
$root = include('Config/root.php');
define('ROOT', $root);
define('FILE', dirname(__FILE__));
define('CONTROLLERS', '/Puko/Controllers/');

include('Puko/Core/Puko.php');
include('Puko/Core/RouteParser.php');
include('Puko/Core/View/View.php');
include('Puko/Core/View/HTMLParser.php');
include('Puko/Core/Service/Service.php');
include('Puko/Core/Service/JSONParser.php');

use Puko\Core\Puko;
Puko::Init()->Start();