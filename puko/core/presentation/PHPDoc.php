<?php
/**
 * Created by PhpStorm.
 * User: didit
 * Date: 6/26/2016
 * Time: 10:12 PM
 */

namespace Puko\Core\Presentation;


interface PHPDoc
{

    public function Value($key, $val);

    public function User($key, $val);

    public function Date($key, $val);

    public function Throws($key, $val);

    public function Validation($key, $val);

    public function View($key, $val);

}