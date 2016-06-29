<?php
/**
 * Authentication modules for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */

namespace Puko\Modules;

class AuthenticationModules
{
    /**
     * @param $username
     * @param $password
     *
     * @return int
     */
    protected function CustomAuthentication($username, $password)
    {
        // todo : your authentication code belongs here.

        // todo : return your session ID.
        return 1;
    }

    protected function FetchUserData($sid)
    {
        // todo : get userdata from session ID.
        return 1;
    }
}