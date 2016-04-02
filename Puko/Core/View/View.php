<?php

namespace Puko\Core\View;

abstract class View
{

    /**
     * View constructor.
     */
    public function __construct()
    {
    }

    public abstract function main();
}