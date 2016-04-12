<?php

use Puko\Core\Puko;

class Main extends PHPUnit_Framework_TestCase
{
    /**
     * Main constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function main()
    {
        \Puko\VariableDump(array('test' => 'root namespace'));
    }

}
