<?php

namespace Puko\Core\Presentation\Json;

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