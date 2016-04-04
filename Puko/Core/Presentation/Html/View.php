<?php

namespace Puko\Core\Presentation\Html;

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