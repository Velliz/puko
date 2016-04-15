<?php
define('ROOT', 'http://localhost/puko/');
define('FILE', dirname(__FILE__));

include('Puko/Core/Puko.php');
use Puko\Core\Puko;

Puko::Init(PRODUCTION)
    ->VariableDump(true)
    ->Start(USE_PUKO_DEFAULT_AUTH);
