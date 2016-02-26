<?php

namespace Puko\Core;

class RouteParser
{
    public $RawRouter;
    public $ClassName;
    public $ConstructVars;
    public $FunctionNames;
    public $FunctionVars = array();

    function loader($class)
    {
        require_once PUKO_ROOT . '/Puko/Controllers/' . $class . EXT;
    }

    function __construct($router)
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

    function InitializeClass()
    {
        $realFilePath = PUKO_ROOT . '/Puko/Controllers/' . $this->ClassName . '.php';
        if (!file_exists($realFilePath)) {
            die('Controller file ' . $this->ClassName . ' is not found.');
        }
        $this->loader($this->ClassName);
        return new $this->ClassName($this->ConstructVars);
    }

    function InitializeFunction($classObj)
    {
        if (empty($this->FunctionVars)) {
            return call_user_func(
                array($classObj, $this->FunctionNames)
            );
        } else {
            return call_user_func_array(
                array($this->ClassName, $this->FunctionNames), $this->FunctionVars
            );
        }
    }

}