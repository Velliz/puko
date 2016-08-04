<?php
/**
 * Service based data parser for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace puko\core\presentation;

use puko\core\auth\Authentication;

/**
 * Class Service
 * @package Puko\Core\Presentation\Json
 *
 * @property-read Authentication $PukoAuthObject
 */
abstract class Service
{

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->PukoAuthObject = Authentication::GetInstance();
    }

    public abstract function main();
}