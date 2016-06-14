<?php
define('ROOT', 'http://localhost/puko/');
define('FILE', dirname(__FILE__));
define('NOT_FOUND', 'Assets/templates/notfound.html');

include('Puko/Core/Puko.php');
use Puko\Core\Puko;

/**
 * Use with variable dump true/false
 */
Puko::Init(DEVELOPMENT)->VariableDump(false)->Start();
