<?php

namespace Puko\Util;

use DateTime as Dates;

class DateAndTime
{

    private $dateObject;

    public function __construct()
    {
        $this->dateObject = new Dates();
        return $this;
    }

    public static function NowDate()
    {
        $obj = new Dates();
        return $obj->format('y-m-d');
    }

    public static function NowDateTime()
    {
        $obj = new Dates();
        return $obj->format('y-m-d h:i:s');
    }

}