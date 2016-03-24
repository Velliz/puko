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

    public function NowDate()
    {
        return $this->dateObject->format('y-m-d');
    }

    public function NowDateTime()
    {
        return $this->dateObject->format('y-m-d h:i:s');
    }

}