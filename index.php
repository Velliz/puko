<?php
define('ROOT', 'http://localhost/puko/');
define('FILE', dirname(__FILE__));

include('Puko/Core/Puko.php');
use Puko\Core\Puko;

Puko::Init()->Start(PUKO_AUTH);