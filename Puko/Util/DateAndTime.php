<?php

namespace Puko\Util;

use DateTime as Dates;

/**
 * Class DateAndTime
 * @package Puko\Util
 */
class DateAndTime
{

    /**
     * @var Dates
     */
    private $dateObject;

    /**
     * DateAndTime constructor.
     */
    public function __construct()
    {
        $this->dateObject = new Dates();
        return $this;
    }

    /**
     * @return string
     */
    public static function NowDate()
    {
        $obj = new Dates();
        return $obj->format('y-m-d');
    }

    /**
     * @return string
     */
    public static function NowDateTime()
    {
        $obj = new Dates();
        return $obj->format('y-m-d h:i:s');
    }

}