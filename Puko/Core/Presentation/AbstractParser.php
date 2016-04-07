<?php

namespace Puko\Core\Presentation;

abstract class AbstractParser
{

    private $ARRAYS = 0;
    private $STRINGS = 1;
    private $BOOLEANS = 2;
    private $NULLS = 4;
    private $NUMERIC = 5;
    private $UNDEFINED = 6;

    public function __construct()
    {

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


    public abstract function ValueRender();

    public abstract function ConditionRender();

    public abstract function LoopRender();

    public abstract function ScriptRender();

    public abstract function StyleRender();

    public abstract function UrlRender();

    public abstract function ReturnEmptyRender();


}