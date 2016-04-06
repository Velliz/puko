<?php

namespace Puko\Core\Presentation\Json;

use Puko\Core\Auth\Authentication;

/**
 * Class Service
 * @package Puko\Core\Presentation\Json
 *
 * @property-read Authentication $PukoAuthObject
 */
abstract class Service
{

    /**
     * Service constructor.
     */
    public function __construct($authCode)
    {
        $this->PukoAuthObject = Authentication::GetInstance($authCode);
    }

    public abstract function main();
}