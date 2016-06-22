<?php

use Model\Member;
use Puko\Core\Presentation\View;

/**
 * Class Main
 * #Value PageTitle Main Puko Pages
 */
class Main extends View
{

    private $id;

    function __construct($vars)
    {
        parent::__construct();
        $this->id = $vars;
    }

    function Main()
    {
        $vars['PageTitle'] = 'Puko Framework';
        $vars['Welcome'] = 'Selamat Datang di Puko Framework';
        $vars['Pertama'] = array(
            array('PertamaValue' => 'Test 1'),
            array('PertamaValue' => 'Test 2'),
            array('PertamaValue' => 'Test 3'),
            array('PertamaValue' => 'Test 4'),
            array('PertamaValue' => 'Test 5'),
        );
        $vars['Kedua'] = array(
            array('KeduaValue' => 'Piringan Divell'),
        );


        $vars['Puko'] = Member::GetFamily(1);
        $vars['Value'] = 'Didit Velliz';
        $vars['Block'] = false;
        return $vars;
    }

    public function NoAccess($a, $b)
    {
        var_dump($this->id);
    }
}