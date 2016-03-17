<?php
define('PUKO_ROOT', dirname(__FILE__));
define('PUKO_CONTROLLER', '/Puko/Controllers/');
define('PUKO_CONFIG', '/Config/');
define('EXT', '.php');

spl_autoload_register(function ($class_name) {
    include $class_name . EXT;
});

use Puko\Core\RouteParser;
use Puko\Core\Template;

#region url router
$router = new RouteParser(isset($_GET['query']) ? $_GET['query'] : 'main/main');
$routerObj = $router->InitializeClass();
$vars = $router->InitializeFunction($routerObj);
#end region

$template = new Template('Assets/html/' . $router->ClassName . '/' . $router->FunctionNames . ".html",
    false, false);
$template->setValueRule("{!", "}");
$template->setOpenLoopRule("{!", "}");
$template->setClosedLoopRule("{/", "}");

$template->setOpenBlockedRule("{!!", "}");
$template->setClosedBlockedRule("{/", "}");

$template->setArrays($vars);
echo $template->output();