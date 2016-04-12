<?php

use Puko\Core\Presentation\Html\HtmlParser;
use Puko\Core\Presentation\Html\View;
use Puko\Core\Presentation\Json\JSONParser;
use Puko\Core\Presentation\Json\Service;
use Puko\Core\Router\RouteParser;

class Main extends PHPUnit_Framework_TestCase
{

    public function main()
    {
        $authCode = 800;
        $start = microtime(true);

        $view = new ReflectionClass(View::class);
        $service = new ReflectionClass(Service::class);

        $router = new RouteParser($this->GetRouter());
        $routerObj = $router->InitializeClass($authCode);
        $vars = $router->InitializeFunction($routerObj);

        //$vars['Auth'] = Authentication::GetInstance($authCode)->GetUserData();

        $hasil = new ReflectionClass($routerObj);

        if ($hasil->isSubclassOf($view)) {
            $template = new HtmlParser(ASSETS . $router->ClassName . '/' . $router->FunctionNames . ".html", false, false);

            $template->setValueRule("{!", "}");
            $template->setOpenLoopRule("{!", "}");
            $template->setClosedLoopRule("{/", "}");

            $template->setOpenBlockedRule("{!!", "}");
            $template->setClosedBlockedRule("{/", "}");

            $template->setArrays($vars);

            $template->renderStyleProperty($router->ClassName, $router->FunctionNames);
            $template->renderScriptProperty($router->ClassName, $router->FunctionNames);

            echo $template->output();

        } elseif ($hasil->isSubclassOf($service)) {

            $service = new JSONParser($vars, $start);
            echo json_encode($service->output());

        } else {
            die('Controller must extends its type');
        }
    }

    private function GetRouter()
    {
        $clause = 'main/main';
        $ClauseTail = substr($clause, -1);
        if ($ClauseTail != '/')
            $clause .= '/';
        return $clause;
    }

}
