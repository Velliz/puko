<?php
define('PUKO_ROOT', dirname(__FILE__));
define('PROJECT_ROOT', 'http://localhost/puko/');
define('PUKO_CONTROLLER', '/Puko/Controllers/');
define('PUKO_CONFIG', '/Config/');
define('EXT', '.php');

spl_autoload_register(function ($class_name) {
    include $class_name . EXT;
});

use Puko\Core\RouteParser;
use Puko\Core\Template;

#region url router
$route = isset($_GET['query']) ? $_GET['query'] : 'main/main/';
$routeCheck = substr($route, -1);

if($routeCheck != '/')
    $route .= '/';

$router = new RouteParser($route);
$routerObj = $router->InitializeClass();
$vars = $router->InitializeFunction($routerObj);
#end region

#region template engine
$template = new Template('Assets/html/' . $router->ClassName . '/' .
    $router->FunctionNames . ".html", false, false);

$template->setValueRule("{!", "}");
$template->setOpenLoopRule("{!", "}");
$template->setClosedLoopRule("{/", "}");

$template->setOpenBlockedRule("{!!", "}");
$template->setClosedBlockedRule("{/", "}");

$template->setArrays($vars);

$template->renderStyleProperty($router->ClassName, $router->FunctionNames);
$template->renderScriptProperty($router->ClassName, $router->FunctionNames);
#end region template engine

/**
 * Send the output to browser
 */
echo $template->output();