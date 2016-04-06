<?php

namespace Puko\Core\Presentation\Html;

use Puko\Core\Auth\Authentication;

/**
 * Class View
 * @package Puko\Core\Presentation\Html
 *
 * @property-read Authentication $PukoAuthObject
 */
abstract class View
{

    /**
     * View constructor.
     */
    public function __construct($authCode)
    {
        $this->PukoAuthObject = Authentication::GetInstance($authCode);
    }

    public abstract function main();
}