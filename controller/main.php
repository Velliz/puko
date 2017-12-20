<?php

namespace controller;

use plugins\elements\userbadge\UserBadge;
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
        $data['User'] = new UserBadge('User', array(
            'Name' => 'Didit Velliz',
            'Jobs' => 'Web Developer',
            'Contacts' => '081381461286',
            'User' => new UserBadge('User', array(
                'Name' => 'Didit Velliz',
                'Jobs' => 'Web Developer',
                'Contacts' => '081381461286',
                'User' => 'END'
            ))
        ));
        return $data;
    }

    public function OnInitialize()
    {
    }

}
