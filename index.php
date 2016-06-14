<?php
define('ROOT', 'http://localhost/puko/');
define('FILE', dirname(__FILE__));

include('Puko/Core/Puko.php');
use Puko\Core\Puko;

/**
 * Use with variable dump true/false
 */
Puko::Init(DEVELOPMENT)->VariableDump(false)->Start();
