<?php

define('FILE', dirname(__FILE__));
define('ROOT', 'http://localhost/puko/');

define('PAGE_404', 'Assets/templates/not_found.html');
define('PAGE_401', 'Assets/templates/unauthorized.html');

define('PAGE_EXCEPTION', 'Assets/templates/exception.html');

use Puko\Core\Puko;

class PukoFramework extends \PHPUnit_Framework_TestCase
{

    public function testFrameworkRun(){
        $_GET['query'] = 'main/main';
        print_r($_GET);
        return Puko::Init(DEVELOPMENT)->VariableDump(false)->Start(
            array()
        );
    }

}
