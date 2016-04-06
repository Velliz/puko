<?php
$root = include('Config/root.php');
define('ROOT', $root);
define('FILE', dirname(__FILE__));
define('CONTROLLERS', '/Controllers/');

include('Puko/Core/Puko.php');
use Puko\Core\Puko;

Puko::Init()->Start(PUKO_AUTH);