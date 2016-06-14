<?php

use Model\Member;
use Puko\Core\Presentation\Html\View;

/**
 * Class Main
 */
class Main extends View
{

    private $id;

    function __construct($vars)
    {
        parent::__construct();
        $this->id = $vars;
    }

    /**
     * @return mixed
     *
     * #PageTitle Main Puko Pages
     */
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

        $vars['Puko'] = Member::GetFamily(1);
        $vars['Value'] = 'Didit Velliz';
        return $vars;
    }

    public function NoAccess()
    {

    }
}