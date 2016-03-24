<?php

class main
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
            'Welcome' => 'uiie',
        );
    }
}