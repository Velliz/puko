<?php

use Puko\Core\Service\Service;
use Puko\Core\View\View;

class Main extends View
{

    var $id;

    function __construct($vars)
    {
        $this->id = $vars;
    }

    function main()
    {
        var_dump($this->id);
        return array(
            'PageTitle' => 'Puko Framework',
            'Welcome' => 'uiie',
        );
    }
}