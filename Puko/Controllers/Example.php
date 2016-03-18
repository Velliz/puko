<?php

/**
 * Class Example
 */
class Example
{
    public $id;

    function __construct($vars)
    {
        $this->id = $vars;
    }

    function main()
    {
        return array(
            'PageTitle' => 'Puko Framework',
            'Welcome' => 'Welcome To Puko Framework Test Programs',
        );
    }
}