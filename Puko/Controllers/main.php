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
        return array(
            'PageTitle' => 'Puko Framework',
            'Welcome' => 'Selamat Datang di Puko Framework',
            'Pertama' => array(
                'Kedua' => array(
                    'Value' => 'KetigaSimpleValue'
                ),
                'Value' => 'KeduaValue'
            ),
            'Value' => 'PertamaValue'
        );
    }
}