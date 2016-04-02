<?php

namespace Puko\Core\Service;

abstract class Service
{

    /**
     * Service constructor.
     */
    public function __construct()
    {
    }

    public abstract function main();
}