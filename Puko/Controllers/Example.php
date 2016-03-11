<?php

class Example
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
            'Welcome' => 'Welcome To Puko Framework',
        );
    }

    function run($var)
    {
        echo "whoa mama " . $var;
    }
}