<?php

class Main extends \Puko\Core\Presentation\View
{
    private $id;

    public function __construct($val)
    {
        parent::__construct();
        $this->id = $val;
    }

    /**
     * #Value PageTitle Selamat Datang
     * #Value Nama Didit Velliz
     */
    public function Main()
    {
        echo 'Puko';
    }
}
