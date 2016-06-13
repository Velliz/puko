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
    public function __construct()
    {
        $this->PukoAuthObject = Authentication::GetInstance();
    }

    public abstract function main();

    public function RedirectTo($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }
}