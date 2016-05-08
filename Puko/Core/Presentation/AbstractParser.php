<?php

namespace Puko\Core\Presentation;

abstract class AbstractParser
{

    protected $ARRAYS = 0;
    protected $STRINGS = 1;
    protected $BOOLEANS = 2;
    protected $NULLS = 4;
    protected $NUMERIC = 5;
    protected $UNDEFINED = 6;

    protected $logs;
    protected $displayEmptyTag;

    public function __construct($logs = false, $displayEmptyTag = false)
    {
        $this->logs = $logs;
        $this->displayEmptyTag = $displayEmptyTag;
    }

    public function getVarType($var)
    {
        if (is_array($var))
            return $this->ARRAYS;
        if (is_null($var))
            return $this->NULLS;
        if (is_string($var))
            return $this->STRINGS;
        if (is_bool($var))
            return $this->BOOLEANS;
        if (is_numeric($var))
            return $this->NUMERIC;
        else
            return $this->UNDEFINED;
    }

    public abstract function ScriptRender($controllerName, $functionName);

    public abstract function StyleRender($controllerName, $functionName);

    public abstract function ReturnEmptyRender();


}