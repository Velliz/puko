<?php

namespace apps\frontend\controller;

use pukoframework\middleware\View;

/**
 * Class main
 * @package controller
 *
 * #Master master.html
 */
class main extends View
{
    /**
     * #Value title Puko Framework
     * #Template master true
     */
    public function main()
    {
    }

    /**
     * @return array
     */
    public function didit()
    {
        return array(
            'nama' => 'Velliz'
        );
    }

}
