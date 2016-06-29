<?php
define('FILE', dirname(__FILE__));
define('ROOT', 'http://localhost/puko/');

define('PAGE_404', 'Assets/templates/not_found.html');
define('PAGE_401', 'Assets/templates/unauthorized.html');

define('PAGE_EXCEPTION', 'Assets/templates/exception.html');

include('Puko/Core/Puko.php');
use Puko\Core\Puko;
Puko::Init(PRODUCTION)->VariableDump(false)->Start(
    array(
        'home' => 'main/noaccess',
        'dashboard' => 'example',
        'anak' => 'example/fileupload',
    )
);
