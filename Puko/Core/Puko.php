<?php

namespace Puko\Core;

use Puko\Core\Service\Service;
use Puko\Core\View\HtmlParser;
use Puko\Core\View\View;
use ReflectionClass;

class Puko
{

    static $PukoInstance;

    public static function Init()
    {
        self::Autoload();
        if (!is_object(self::$PukoInstance)) {
            self::$PukoInstance = new Puko();
        }
        return self::$PukoInstance;
    }

    private function Autoload()
    {
        spl_autoload_register(array('\Puko\Core\Puko', 'ClassLoader'));
    }

    private static function ClassLoader($className)
    {
        if (file_exists($className)) {
            require_once($className);
        }

    }

    public function Start()
    {
        $router = new RouteParser($this->GetRouter());
        $routerObj = $router->InitializeClass();
        $vars = $router->InitializeFunction($routerObj);

        $hasil = new ReflectionClass($routerObj);

        $view = new ReflectionClass(new View());
        $service = new ReflectionClass(new Service());

        if ($hasil->isSubclassOf($view)) {
            $template = new HTMLParser('Assets/html/' . $router->ClassName . '/' .
                $router->FunctionNames . ".html", false, false);

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
            echo json_encode($vars);
        } else {
            die('Controller must extends its type');
        }
    }

    private function GetRouter()
    {
        $clause = isset($_GET['query']) ? $_GET['query'] : 'main/main/';

        $ClauseTail = substr($clause, -1);
        if ($ClauseTail != '/') {
            $clause .= '/';
        }

        return $clause;
    }

    private function ClassType($source, $dest)
    {
        return $source == $dest || is_subclass_of($source, $dest);
    }
}