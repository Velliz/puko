<?php

use Puko\Core\Backdoor\Data;
use Puko\Core\Presentation\Html\View;

class Main extends View
{

    private $id;

    function __construct($vars, $authCode)
    {
        parent::__construct($authCode);
        $this->id = $vars;
    }

    function main()
    {

        $vars['PageTitle'] = 'Puko Framework';
        $vars['Welcome'] = 'Selamat Datang di Puko Framework';
        $vars['Pertama'] = array(
            array('PertamaValue' => 'Test 1'),
            array('PertamaValue' => 'Test 2'),
            array('PertamaValue' => 'Test 3'),
            array('PertamaValue' => 'Test 4'),
            array('PertamaValue' => 'Test 5'),

            /*
            'Kedua' => array(
                array('KeduaValue' => 'Dua 1'),
                array('KeduaValue' => 'Dua 2'),
            )
            */

        );

        $vars['Puko'] = Data::From('select * from family')->FetchAll();

        $vars['Value'] = 'Didit Velliz';

        return $vars;
    }
}