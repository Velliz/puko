<?php
/**
 * Date and Time modules for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 1.0
 * @package Puko Core
 */
namespace puko\util;


class NumberAndCurrency
{


    public function __construct()
    {
    }

    public static function NumberFormat($number) {
        return number_format($number);
    }

}