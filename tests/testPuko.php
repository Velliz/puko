<?php
define('FILE', dirname(__FILE__));
define('ROOT', 'http://localhost/puko/');

define('PAGE_404', 'Assets/templates/not_found.html');
define('PAGE_401', 'Assets/templates/unauthorized.html');

define('PAGE_EXCEPTION', 'Assets/templates/exception.html');

define('CONTROLLERS', '/Controllers/');
define('ASSETS', 'Assets/html/');
define('MASTER', 'Assets/templates/');

define('PRODUCTION', 'live');
define('DEVELOPMENT', 'dev');

require_once('puko/core/router/RouteParser.php');
require_once('puko/core/Puko.php');
use Puko\Core\Router\RouteParser;

class testPuko extends \PHPUnit_Framework_TestCase
{

    public function testFrameworkRun(){
        $route = new RouteParser('main/main');
        $this->assertInstanceOf('Main', $route->InitializeClass());
    }

}
