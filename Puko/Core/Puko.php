<?php

namespace {
    define('PUKO_AUTH', 800);
    define('CUSTOM_AUTH', 900);
}

namespace Puko\Core {

    use Puko\Core\Presentation\Html\HtmlParser;
    use Puko\Core\Presentation\Html\View;
    use Puko\Core\Presentation\Json\JSONParser;
    use Puko\Core\Presentation\Json\Service;
    use Puko\Core\Router\RouteParser;
    use ReflectionClass;

    class Puko
    {
        private static $PukoInstance;

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
            $className .= '.php';
            if (file_exists($className)) {
                require_once($className);
            }
        }

        public function Start($authCode)
        {
            $start = microtime(true);

            $view = new ReflectionClass(View::class);
            $service = new ReflectionClass(Service::class);

            $router = new RouteParser($this->GetRouter());
            $routerObj = $router->InitializeClass($authCode);
            $vars = $router->InitializeFunction($routerObj);

            $hasil = new ReflectionClass($routerObj);

            if ($hasil->isSubclassOf($view)) {
                $template = new HtmlParser('Assets/html/' . $router->ClassName . '/' .
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

                $service = new JSONParser($vars, $start);
                echo json_encode($service->output());

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

    }
}