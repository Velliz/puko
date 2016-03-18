<?php

namespace Puko\Core;

class RouteParser
{
    public $RawRouter;
    public $ClassName;
    public $ConstructVars;
    public $FunctionNames;
    public $FunctionVars = array();

    public function loader($class)
    {
        require_once PUKO_ROOT . '/Puko/Controllers/' . $class . EXT;
    }

    public function __construct($router)
    {
        $this->RawRouter = $router;
        $variables = explode('/', $this->RawRouter);

        $construct = null;
        if (isset($variables[1])) {
            $construct = ctype_digit($variables[1]) ? intval($variables[1]) : null;
        }

        if (sizeof($variables) > 3) {
            $this->ClassName = $variables[0];
            $this->ConstructVars = $variables[1];
            if ($construct === null) {
                $this->FunctionNames = $variables[2 - 1];
            } else {
                $this->FunctionNames = $variables[2];
            }

            if ($construct === null) {
                foreach ($variables as $k => $v) {
                    if ($k > 1) {
                        array_push($this->FunctionVars, $v);
                    }
                }
            } else {
                foreach ($variables as $k => $v) {
                    if ($k > 2) {
                        array_push($this->FunctionVars, $v);
                    }
                }
            }
        } else {
            if (sizeof($variables) == 3) {
                $this->ClassName = $variables[0];
                $this->ConstructVars = $variables[1];
                if ($construct === null) {
                    $this->FunctionNames = $variables[2 - 1];
                } else {
                    $this->FunctionNames = $variables[2];
                }
            } else {
                if (sizeof($variables) == 2) {
                    $this->ClassName = $variables[0];
                    $this->ConstructVars = $variables[0];
                    if ($construct === null) {
                        $this->FunctionNames = $variables[1 - 1];
                    } else {
                        $this->FunctionNames = $variables[1];
                    }
                } else {
                    if (sizeof($variables) == 1) {
                        $this->ClassName = $router;
                        $this->FunctionNames = 'main';
                    }
                }
            }
        }
    }

    public function InitializeClass()
    {
        $realFilePath = PUKO_ROOT . '/Puko/Controllers/' . $this->ClassName . EXT;
        if (!file_exists($realFilePath)) {
            die('Controller file ' . $this->ClassName . ' is not found.');
        }
        $this->loader($this->ClassName);
        return new $this->ClassName($this->ConstructVars);
    }

    /**
     * @param $object
     * @return mixed
     */
    public function InitializeFunction($object)
    {

        if (empty($this->FunctionVars)) {
            if (method_exists($object, $this->FunctionNames)
                && is_callable(array($object, $this->FunctionNames))
            ) {
                return call_user_func(
                    array($object, $this->FunctionNames)
                );
            } else {
                die("Method not found");
            }
        } else {
            if (method_exists($object, $this->FunctionNames)
                && is_callable(array($object, $this->FunctionNames))
            ) {
                return call_user_func_array(
                    array($object, $this->FunctionNames), $this->FunctionVars
                );
            } else {
                die("Method with var not found");
            }
        }
    }
}