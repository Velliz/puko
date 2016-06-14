<?php

/**
 * Global namespace
 */
namespace Puko {

    define('CONTROLLERS', '/Controllers/');
    define('ASSETS', 'Assets/html/');
    define('MASTER', 'Assets/templates/');

    define('PRODUCTION', 'live');
    define('DEVELOPMENT', 'dev');

}

namespace Puko\Core {

    use Puko\Core\Auth\Authentication;
    use Puko\Core\Presentation\Html\HtmlParser;
    use Puko\Core\Presentation\Html\View;
    use Puko\Core\Presentation\Json\JSONParser;
    use Puko\Core\Presentation\Json\Service;
    use Puko\Core\Router\RouteParser;
    use ReflectionClass;

    class Puko
    {

        /**
         * @var object
         */
        private static $PukoInstance;

        /**
         * @var string
         */
        public static $Environment;

        /**
         * @var bool
         */
        private static $VariableDump;

        /**
         * @var array
         */
        private $returnVars;

        /**
         * @param $environment
         * @return object|Puko
         */
        public static function Init($environment)
        {
            self::$Environment = $environment;
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

        /**
         * @param $className
         */
        private static function ClassLoader($className)
        {
            $className .= '.php';
            if (file_exists($className)) {
                require_once($className);
            }
        }

        public function Start()
        {
            $start = microtime(true);

            $view = new ReflectionClass(View::class);
            $service = new ReflectionClass(Service::class);

            $router = new RouteParser($this->GetRouter());
            $routerObj = $router->InitializeClass();
            $this->returnVars = $router->InitializeFunction($routerObj);

            if (self::$VariableDump && strcmp(self::$Environment, 'dev') == 0) {
                $dump['LoginData'] = Authentication::GetInstance()->GetUserData();
                $dump['Return'] = $this->returnVars;
                echo '<pre>';
                var_dump($dump);
                echo '</pre>';
            }

            $routeResult = new ReflectionClass($routerObj);
            $classDocs = $routeResult->getDocComment();
            $fnDocs = $routeResult->getMethod($router->FunctionNames)->getDocComment();

            $classParse = $router->DocParser($classDocs);
            $fnParse = $router->DocParser($fnDocs);

            if (sizeof($classParse[0]) > 0) {
                foreach ($classParse[0] as $k => $v) {
                    $preg = explode(' ', $v);
                    $params = null;
                    foreach ($preg as $key => $val) {
                        switch ($key) {
                            case 0:
                                break;
                            default:
                                if ($key != sizeof($preg) - 1) $params .= $val . ' ';
                                else $params .= $val;
                                break;
                        }
                    }
                    call_user_func(array($this, str_replace('#', '', $preg[0])), $params);
                }
            }

            if (sizeof($fnParse[0]) > 0) {
                foreach ($fnParse[0] as $k => $v) {
                    $preg = explode(' ', $v);
                    $params = null;
                    foreach ($preg as $key => $val) {
                        switch ($key) {
                            case 0:
                                break;
                            default:
                                if ($key != sizeof($preg) - 1) $params .= $val . ' ';
                                else $params .= $val;
                                break;
                        }
                    }
                    call_user_func(array($this, str_replace('#', '', $preg[0])), $params);
                }
            }

            if ($routeResult->isSubclassOf($view)) {
                $template = new HtmlParser(ASSETS . $router->ClassName . '/' . $router->FunctionNames . ".html");
                $template->setArrays($this->returnVars);
                $template->StyleRender($router->ClassName, $router->FunctionNames);
                $template->ScriptRender($router->ClassName, $router->FunctionNames);
                echo $template->output();
            } elseif ($routeResult->isSubclassOf($service)) {
                $service = new JSONParser($this->returnVars, $start);
                echo json_encode($service->output());
            } else {
                if (strcmp(self::$Environment, 'dev') == 0) {
                    die('Controller must extends its type');
                } else {
                    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
                    include 'Assets/templates/notfound.html';
                    die();
                }
            }
        }

        /**
         * @return string
         */
        private function GetRouter()
        {
            $clause = isset($_GET['query']) ? $_GET['query'] : 'main/main/';
            $ClauseTail = substr($clause, -1);
            if ($ClauseTail != '/') {
                $clause .= '/';
            }
            return $clause;
        }

        /**
         * @param bool $option
         * @return object
         */
        public static function VariableDump($option = false)
        {
            self::$VariableDump = $option;
            return self::$PukoInstance;
        }


        #region php docs tags
        /**
         * @param $value
         */
        public function PageTitle($value) {
            $this->returnVars['PageTitle'] = $value;
        }
        #endregion php docs tags
    }
}