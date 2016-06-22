<?php
/**
 * Date and Time modules for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */

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