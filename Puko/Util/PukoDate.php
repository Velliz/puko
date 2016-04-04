<?php

namespace Puko\Util;

use DateTime;

class PukoDate
{

    private $dateObject;

    public function __construct()
    {
        $this->dateObject = new DateTime();
        return $this;
    }

    public static function NowDate()
    {
        $obj = new DateTime();
        return $obj->format('y-m-d');
    }

    public static function NowDateTime()
    {
        $obj = new DateTime();
        return $obj->format('y-m-d h:i:s');
    }

}