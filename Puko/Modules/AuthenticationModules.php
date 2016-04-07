<?php

namespace Puko\Modules;

class AuthenticationModules
{
    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    function CustomAuthentication($username, $password)
    {
        // todo : your authentication code belongs here.

        // todo : return your session data.
        return array(
            'username' => $username,
            'email' => $password
        );
    }
}