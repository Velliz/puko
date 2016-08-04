<?php
/**
 * Core class for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */

namespace puko\core;

use ErrorException;
use Exception;
use Puko\Core\Auth\Authentication;
use Puko\Core\Presentation\PHPDocProcessor;
use Puko\Core\Presentation\View;
use Puko\Core\Presentation\Service;
use Puko\Core\Presentation\Html\HtmlParser;
use Puko\Core\Presentation\Json\JSONParser;
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

    private static $AuthObject;

    /**
     * @param $environment
     * @return object|Puko
     */
    public static function Init($environment)
    {
        if (version_compare(phpversion(), '5.6', '<')) {
            die("PHP installation does not match the requirement.");
        }
        self::$Environment = $environment;
        self::Autoload();
        if (!is_object(self::$PukoInstance)) {
            self::$PukoInstance = new Puko();
            self::$AuthObject = Authentication::GetInstance();
        }

        error_reporting(E_ALL);

        register_shutdown_function(array('\puko\core\Puko', 'check_for_fatal'));
        set_error_handler(array('\puko\core\Puko', 'log_error'));
        set_exception_handler(array('\puko\core\Puko', 'log_exception'));

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
        $className = ltrim($className, '');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;

        /*
        $className = DIRECTORY . $className . '.php';
        if (file_exists($className)) {
            require_once($className);
        }*/
    }

    public function Start($routeConfig = array())
    {
        $start = microtime(true);
        $router = new RouteParser($this->GetDefaultRouter());
        foreach ($routeConfig as $key => $value) {
            if (strpos($this->GetDefaultRouter(), $key) !== false) {
                $value = str_replace($key, $value, $this->GetDefaultRouter());
                $router = new RouteParser($this->GetRouter($value));
                break;
            }
        }

        $view = new ReflectionClass(View::class);
        $service = new ReflectionClass(Service::class);
        $routerObj = $router->InitializeClass();
        $this->returnVars = $router->InitializeFunction($routerObj);
        $this->returnVars['token'] = $_COOKIE['token'];

        $routeResult = new ReflectionClass($routerObj);
        $classDocs = $routeResult->getDocComment();
        $fnDocs = $routeResult->getMethod($router->FunctionNames)->getDocComment();

        $docParser = new PHPDocProcessor($classDocs);
        $docParser->Output($this->returnVars);
        $fnParser = new PHPDocProcessor($fnDocs);
        $fnParser->Output($this->returnVars);

        if (self::$VariableDump && strcmp(self::$Environment, 'dev') == 0) {
            $dump['LoginData'] = Authentication::GetInstance()->GetUserData();
            $dump['Return'] = $this->returnVars;
            echo '<pre>';
            var_dump($dump);
            echo '</pre>';
        }

        if ($routeResult->isSubclassOf($view)) {
            $language = self::$AuthObject->getSessionData('lang');
            if ($language == '') {
                $language = 'id';
            }
            $language = $language . '/';
            $template = new HtmlParser(ASSETS . $language . $router->ClassName . '/' . $router->FunctionNames . ".html");
            $template->setArrays($this->returnVars);
            $template->StyleRender($router->ClassName, $router->FunctionNames);
            $template->ScriptRender($router->ClassName, $router->FunctionNames);
            $template->Parse();
            echo $template->ClearOutput();
        } elseif ($routeResult->isSubclassOf($service)) {
            $service = new JSONParser($this->returnVars, $start);
            echo json_encode($service->output());
        } else {
            if (strcmp(self::$Environment, 'dev') == 0) {
                die('Controller must extends its type');
            } else {
                header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
                include PAGE_404;
                die();
            }
        }
    }

    /**
     * @return string
     */
    private function GetDefaultRouter()
    {
        $clause = isset($_GET['query']) ? $_GET['query'] : 'main/main/';
        $ClauseTail = substr($clause, -1);
        if ($ClauseTail != '/') {
            $clause .= '/';
        }
        return $clause;
    }

    private function GetRouter($clause)
    {
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

    /**
     * Error handler, passes flow over the exception logger with new ErrorException.
     * @param $num
     * @param $str
     * @param $file
     * @param $line
     */
    static function log_error($num, $str, $file, $line)
    {
        self::log_exception(new ErrorException($str, 0, $num, $file, $line));
    }

    /**
     * Uncaught exception handler.
     * @param Exception $e
     */
    static function log_exception(Exception $e)
    {
        if (strcmp(self::$Environment, 'dev') == 0) {
            print "<div style='text-align: center;'>";
            print "<h2 style='color: rgb(190, 50, 50);'>Exception Occured</h2>";
            print "<table style='width: 800px; display: inline-block;'>";
            print "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Type</th><td>" . get_class($e) . "</td></tr>";
            print "<tr style='background-color:rgb(240,240,240);'><th>Message</th><td>{$e->getMessage()}</td></tr>";
            print "<tr style='background-color:rgb(230,230,230);'><th>File</th><td>{$e->getFile()}</td></tr>";
            print "<tr style='background-color:rgb(240,240,240);'><th>Line</th><td>{$e->getLine()}</td></tr>";
            print "</table></div>";
        } else {
            $message = "Type: " . get_class($e) . "; Message: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()};";
            file_put_contents("exceptions.log", $message . PHP_EOL, FILE_APPEND);
            include PAGE_404;
        }

        exit();
    }

    /**
     * Checks for a fatal error.
     * work around for set_error_handler not working on fatal errors.
     */
    static function check_for_fatal()
    {
        $error = error_get_last();
        if ($error["type"] == E_ERROR) {
            self::log_error($error["type"], $error["message"], $error["file"], $error["line"]);
        }
    }

}