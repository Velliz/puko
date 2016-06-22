<?php
/**
 * HTML view based data parser for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace Puko\Core\Presentation;

use Puko\Core\Auth\Authentication;

/**
 * Class View
 * @package Puko\Core\Presentation\Html
 *
 * @property-read Authentication $PukoAuthObject
 */
abstract class View
{

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->PukoAuthObject = Authentication::GetInstance();
    }

    public function RedirectTo($url, $permanent = false)
    {
        if(strpos($url, '/') === false) header('Location: ' . $url, true, $permanent ? 301 : 302);
        if(strpos($url, '/') !== false) header('Location: ' . ROOT . $url, true, $permanent ? 301 : 302);
        exit();
    }

    public abstract function Main();
}