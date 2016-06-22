<?php
define('FILE', dirname(__FILE__));
define('ROOT', 'http://localhost/puko/');

define('NOT_FOUND', 'Assets/templates/not_found.html');
define('EXCEPTION', 'Assets/templates/exception.html');

include('Puko/Core/Puko.php');
use Puko\Core\Puko;
Puko::Init(DEVELOPMENT)->VariableDump(false)->Start(
    array(
        'home' => 'main/noaccess',
        'dashboard' => 'example',
        'anak' => 'example/fileupload',
    )
);
